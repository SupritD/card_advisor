document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("msgInput");
    const chatBox = document.getElementById("chatContainer");
    const centerBox = document.getElementById("centerBox");
    const sendBtn = document.getElementById("sendBtn");
    const stopBtn = document.getElementById("stopBtn");

    // Logic Refs
    let abortController = null;
    let isGenerating = false;
    let userHasScrolled = false;
    let scrollTimeout = null;

    // If the page doesn't have the chat elements, do nothing
    if (!input || !chatBox) return;

    // Detect manual scrolling
    chatBox.addEventListener('scroll', () => {
        clearTimeout(scrollTimeout);
        const isAtBottom = chatBox.scrollHeight - chatBox.scrollTop <= chatBox.clientHeight + 50;

        if (!isAtBottom && isGenerating) {
            userHasScrolled = true;
        }

        // Reset after user stops scrolling for 1 second
        scrollTimeout = setTimeout(() => {
            userHasScrolled = false;
        }, 1000);
    });

    // =======================
    // HELPER: RENDER MESSAGE
    // =======================
    function renderMessage(role, content) {
        const row = document.createElement("div");
        row.className = `message-row ${role === "user" ? "user" : "bot"}`;

        const bubble = document.createElement("div");
        bubble.className = "message-bubble";

        // Content
        const contentDiv = document.createElement("div");
        contentDiv.className = "message-content";

        if ((role === 'assistant' || role === 'bot') && typeof marked !== 'undefined') {
            contentDiv.innerHTML = marked.parse(content);
        } else {
            contentDiv.innerText = content;
        }
        bubble.appendChild(contentDiv);

        // Append bubble to row first
        row.appendChild(bubble);

        // Actions (Copy / Edit) - OUTSIDE the bubble
        const actionsDiv = document.createElement("div");
        actionsDiv.className = "message-actions";

        // Copy Button
        const copyBtn = document.createElement("button");
        copyBtn.className = "action-btn";
        copyBtn.innerHTML = '<i class="bi bi-clipboard"></i>';
        copyBtn.title = "Copy";
        copyBtn.onclick = () => {
            navigator.clipboard.writeText(content);
            copyBtn.innerHTML = '<i class="bi bi-check-lg"></i>';
            setTimeout(() => { copyBtn.innerHTML = '<i class="bi bi-clipboard"></i>'; }, 2000);
        };
        actionsDiv.appendChild(copyBtn);

        // Edit Button (Only for User)
        if (role === 'user') {
            const editBtn = document.createElement("button");
            editBtn.className = "action-btn";
            editBtn.innerHTML = '<i class="bi bi-pencil"></i>';
            editBtn.title = "Edit";
            editBtn.onclick = () => {
                input.value = content;
                input.focus();
            };
            actionsDiv.appendChild(editBtn);
        }

        // Append actions to row (not bubble)
        row.appendChild(actionsDiv);

        chatBox.appendChild(row);

        // Auto scroll - only if user hasn't manually scrolled
        setTimeout(() => {
            if (!userHasScrolled) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        }, 50);

        return contentDiv; // Return content part for streaming updates
    }

    // =======================
    // RESTORE SESSION
    // =======================
    (async () => {
        try {
            const parts = window.location.pathname.split("/").filter(Boolean);
            let urlToken = parts.includes("my-chat") && parts[parts.length - 1] !== "my-chat" ? parts[parts.length - 1] : null;

            // Strict Rule: If URL has no token, it is NEW SESSION. Clear local storage.
            if (!urlToken) {
                localStorage.removeItem("chat_session_token");
            }

            let token = urlToken || localStorage.getItem("chat_session_token");

            if (urlToken) {
                localStorage.setItem("chat_session_token", urlToken);
            }

            if (!token) return;

            const resp = await fetch(
                `/api/chat/history?session_token=${encodeURIComponent(token)}`,
                {
                    credentials: "same-origin",
                    headers: { "Accept": "application/json" }
                }
            );

            const data = await resp.json();

            if (!data.messages || data.messages.length === 0) return;

            // Render existing messages
            chatBox.innerHTML = "";
            data.messages.forEach((m) => {
                renderMessage(m.role === "user" ? "user" : "bot", m.content);
            });

            if (centerBox) centerBox.style.display = "none";
            chatBox.scrollTop = chatBox.scrollHeight;

            // Check for auto-trigger
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('trigger') === '1' && data.messages.length > 0) {
                const lastMsg = data.messages[data.messages.length - 1];
                if (lastMsg.role === 'user') {
                    // Trigger bot response for the last user message without re-rendering it
                    sendMessage(lastMsg.content, true);

                    // Cleanup URL
                    const newUrl = window.location.pathname;
                    history.replaceState({}, "", newUrl);
                }
            }

        } catch (e) {
            console.error("Restore failed", e);
        }
    })();

    // =======================
    // SESSION CONTROLS
    // =======================
    const btnNew = document.getElementById("btnNewSession");
    const btnClear = document.getElementById("btnClearSession");

    if (btnNew) {
        btnNew.addEventListener("click", () => {
            localStorage.removeItem("chat_session_token");
            location.href = '/dashboard/my-chat';
        });
    }

    if (btnClear) {
        btnClear.addEventListener("click", async () => {
            const token = localStorage.getItem("chat_session_token");
            if (!confirm("Clear this conversation?")) return;

            if (token) {
                try {
                    await fetch("/api/chat/session", {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                        body: JSON.stringify({ session_token: token }),
                    });
                } catch { }
            }
            localStorage.removeItem("chat_session_token");
            location.href = '/dashboard/my-chat';
        });
    }

    // Stop Logic
    // We need to store the current typing row to remove it on stop
    let currentTypingRow = null;

    if (stopBtn) {
        stopBtn.addEventListener("click", () => {
            if (abortController) {
                console.log("Stopping generation...");
                abortController.abort();
                abortController = null;
                isGenerating = false;

                // Immediately remove thinking/typing indicator
                if (currentTypingRow) {
                    currentTypingRow.remove();
                    currentTypingRow = null;
                }

                toggleInputState(true);
            }
        });
    }

    function toggleInputState(enabled) {
        input.disabled = !enabled;
        if (enabled) {
            sendBtn.classList.remove('d-none');
            stopBtn.classList.add('d-none');
            input.focus();
        } else {
            sendBtn.classList.add('d-none');
            stopBtn.classList.remove('d-none');
        }
    }

    // =======================
    // SEND LOGIC
    // =======================
    async function sendMessage(forceText = null, skipUserRender = false) {
        const text = forceText || input.value.trim();
        if (!text) return;

        // Cancel previous if any
        if (isGenerating && abortController) {
            abortController.abort();
        }

        if (centerBox) centerBox.style.display = "none";

        if (!forceText) input.value = "";

        // STEP 1: Create session FIRST if we don't have one
        let sessionToken = localStorage.getItem("chat_session_token");

        if (!sessionToken && !skipUserRender) { // Only create if naturally called
            try {
                const createResp = await fetch("/api/chat/session", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                });

                if (createResp.ok) {
                    const data = await createResp.json();
                    sessionToken = data.session_token;
                    localStorage.setItem("chat_session_token", sessionToken);

                    // Save the user message to DB before redirecting
                    // We use Accept: application/json to prevent 302 redirects if processing fails
                    await fetch("/api/chat", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                        body: JSON.stringify({
                            message: String(text), // Force to string to prevent [object MouseEvent]
                            session_token: sessionToken,
                            language: document.getElementById("chatLanguage")?.value || "en"
                        }),
                    });

                    // Save title
                    const firstMessage = String(text).substring(0, 50);
                    await fetch("/api/chat/update-title", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                        body: JSON.stringify({
                            session_token: sessionToken,
                            title: firstMessage
                        }),
                    }).catch(() => { });

                    // REDIRECT (Full page load ensures sidebar is updated and opened)
                    window.location.href = `/dashboard/my-chat/${sessionToken}?trigger=1`;
                    return;
                }
            } catch (e) {
                console.error("Failed to create session", e);
                return;
            }
        }

        // STEP 2: Now proceed with sending the message
        isGenerating = true;
        abortController = new AbortController();
        const signal = abortController.signal;

        toggleInputState(false);

        // Render User Message
        if (!skipUserRender) {
            renderMessage("user", text);
        }

        // Render Typing Indicator
        const typingRow = document.createElement("div");
        currentTypingRow = typingRow;
        typingRow.className = "message-row bot";
        typingRow.innerHTML = `
            <div class="message-bubble text-muted">
                <div class="typing-indicator">
                    <span></span><span></span><span></span>
                </div>
            </div>`;
        chatBox.appendChild(typingRow);
        chatBox.scrollTop = chatBox.scrollHeight;

        // Prepare payload
        const payload = {
            message: text,
            language: document.getElementById("chatLanguage")?.value || "en",
            session_token: sessionToken // Always include token now
        };

        try {
            const resp = await fetch("/api/chat/stream", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: JSON.stringify(payload),
                signal: signal
            });

            if (!resp.ok) throw new Error("API Error");

            // Remove typing indicator on success start
            if (currentTypingRow) currentTypingRow.remove();
            currentTypingRow = null;

            // Create Bot Message Bubble
            const botContentDiv = renderMessage("bot", "");

            // Stream Reader
            const reader = resp.body.getReader();
            const decoder = new TextDecoder();
            let fullText = "";

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;

                const chunk = decoder.decode(value, { stream: true });
                const parts = chunk.split("\n\n");

                for (const part of parts) {
                    const line = part.replace(/^data:\s*/, "").trim();
                    if (!line || line === "[DONE]") continue;

                    try {
                        const obj = JSON.parse(line);

                        if (obj.delta) {
                            fullText += obj.delta;
                            if (typeof marked !== 'undefined') {
                                botContentDiv.innerHTML = marked.parse(fullText);
                            } else {
                                botContentDiv.innerText = fullText;
                            }

                            // Only auto-scroll if user hasn't manually scrolled
                            if (!userHasScrolled) {
                                chatBox.scrollTop = chatBox.scrollHeight;
                            }
                        }
                    } catch (e) {
                        // ignore parse errors
                    }
                }
            }

        } catch (e) {
            if (e.name === 'AbortError') {
                console.log('Generation stopped by user');
                if (currentTypingRow) currentTypingRow.remove();
            } else {
                if (currentTypingRow) currentTypingRow.remove();
                renderMessage("bot", "⚠️ Sorry, something went wrong. Please try again.");
            }
        } finally {
            isGenerating = false;
            abortController = null;
            currentTypingRow = null;
            toggleInputState(true);
        }
    }

    // Listeners
    input.addEventListener("keypress", (e) => {
        if (e.key === "Enter") sendMessage();
    });

    if (sendBtn) {
        sendBtn.addEventListener("click", () => sendMessage());
    }
});
