document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("msgInput");
    const chatBox = document.getElementById("chatContainer");
    const centerBox = document.getElementById("centerBox");
    const inputArea = document.getElementById("inputArea");
    const chatInput = document.getElementById("chat-input-section");

    // If the page doesn't have the chat elements (e.g., different view), do nothing
    if (!input || !chatBox) return;

    // Attempt to restore previous session messages if we have a session token
    // (async () => {
    //     try {
    //         const token = localStorage.getItem("chat_session_token");
    //         if (!token) return;
    //         const resp = await fetch(
    //             `/api/chat/history?session_token=${encodeURIComponent(token)}`,
    //             { credentials: "same-origin" }
    //         );
    //         if (!resp.ok) return;
    //         const data = await resp.json();
    //         if (!data.messages) return;

    //         data.messages.forEach((m) => {
    //             const container = document.createElement("div");
    //             container.className =
    //                 m.role === "user"
    //                     ? "d-flex justify-content-end"
    //                     : "d-flex justify-content-start";
    //             const msg = document.createElement("div");
    //             msg.className =
    //                 "message " +
    //                 (m.role === "user" ? "user-message" : "bot-message");
    //             msg.innerText = m.content;
    //             container.appendChild(msg);
    //             chatBox.appendChild(container);
    //         });

    //         if (data.messages.length > 0) {
    //             chatBox.scrollTop = chatBox.scrollHeight;
    //             if (centerBox) centerBox.style.display = "none";
    //             chatBox.style.display = "block";
    //             if (chatInput) chatInput.classList.add("bottom-fixed");
    //         }
    //     } catch (e) {
    //         // ignore restore errors
    //         console.warn("Failed to restore chat session", e);
    //     }
    // })();

    // =======================
    // RESTORE SESSION (URL → LocalStorage)
    // =======================
    (async () => {
        try {
            // ---- Read token from URL ----
            const parts = window.location.pathname.split("/").filter(Boolean);

            let urlToken = parts[parts.length - 1];

            // if route is /my-chat (no token)
            if (urlToken === "my-chat") {
                urlToken = null;
            }

            let token = urlToken || localStorage.getItem("chat_session_token");

            // console.log("🔹 URL token =", urlToken);
            // console.log(
            //     "🔹 LocalStorage token =",
            //     localStorage.getItem("chat_session_token")
            // );
            // console.log("🔹 Active token BEFORE sync =", token);

            // if user clicked chat from sidebar → update active session
            if (urlToken) {
                localStorage.setItem("chat_session_token", urlToken);
                token = urlToken;

                // console.log("🟢 Active token UPDATED FROM URL =", token);
            }

            if (!token) {
                console.log("⛔ No session token — skipping restore");
                return;
            }

            // console.log("📡 Fetching history for =", token);

            const resp = await fetch(
                `/api/chat/history?session_token=${encodeURIComponent(token)}`,
                { credentials: "same-origin" }
            );

            // console.log("📥 History API status =", resp.status);

            const data = await resp.json();

            // console.log("📦 History result =", data);

            if (!data.messages || data.messages.length === 0) {
                console.log("⚠ No messages found for session");
                return;
            }

            // ---------- Render messages ----------
            chatBox.innerHTML = "";

            data.messages.forEach((m) => {
                // console.log("💬", m.role, m.content);

                const container = document.createElement("div");
                container.className =
                    m.role === "user"
                        ? "d-flex justify-content-end"
                        : "d-flex justify-content-start";

                const msg = document.createElement("div");
                msg.className =
                    "message " +
                    (m.role === "user" ? "user-message" : "bot-message");

                msg.innerText = m.content;

                container.appendChild(msg);
                chatBox.appendChild(container);
            });

            centerBox.style.display = "none";
            chatBox.style.display = "block";
            chatInput.classList.add("bottom-fixed");
            chatBox.scrollTop = chatBox.scrollHeight;

            console.log("✅ Restore complete");
        } catch (e) {
            console.log("❌ Restore crashed", e);
        }
    })();

    // Session controls (show token, clear session)
    const btnNew = document.getElementById("btnNewSession");
    const btnShow = document.getElementById("btnShowSession");
    const btnClear = document.getElementById("btnClearSession");
    const tokenEl = document.getElementById("sessionTokenDisplay");

    // NEW SESSION
    if (btnNew) {
        btnNew.addEventListener("click", () => {
            localStorage.removeItem("chat_session_token");

            chatBox.innerHTML = "";
            chatBox.style.display = "none";
            centerBox.style.display = "block";
            chatInput.classList.remove("bottom-fixed");
            tokenEl.style.display = "none";

            console.log("New chat session started");
        });
    }
    // SHOW TOKEN
    if (btnShow) {
        btnShow.addEventListener("click", function () {
            const t = localStorage.getItem("chat_session_token");
            if (!t) {
                tokenEl.innerText = "No active session.";
                tokenEl.style.display = "inline";
                setTimeout(() => {
                    tokenEl.style.display = "none";
                }, 3000);
                return;
            }
            tokenEl.innerText = t + " (click to copy)";
            tokenEl.style.display = "inline";

            tokenEl.addEventListener(
                "click",
                async function copyToken() {
                    try {
                        await navigator.clipboard.writeText(t);
                        tokenEl.innerText = "Copied to clipboard";
                        setTimeout(() => {
                            tokenEl.style.display = "none";
                        }, 2000);
                    } catch (e) {
                        // fallback: select
                        const tmp = document.createElement("textarea");
                        tmp.value = t;
                        document.body.appendChild(tmp);
                        tmp.select();
                        document.execCommand("copy");
                        document.body.removeChild(tmp);
                        tokenEl.innerText = "Copied to clipboard";
                        setTimeout(() => {
                            tokenEl.style.display = "none";
                        }, 2000);
                    }
                    tokenEl.removeEventListener("click", copyToken);
                },
                { once: true }
            );
        });
    }
    // CLEAR SESSION (LOCAL + SERVER)
    if (btnClear) {
        btnClear.addEventListener("click", async () => {
            const token = localStorage.getItem("chat_session_token");
            if (!confirm("Clear chat session?")) return;

            if (token) {
                try {
                    await fetch("/api/chat/session", {
                        method: "DELETE",
                        credentials: "same-origin",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify({ session_token: token }),
                    });
                } catch {}
            }

            localStorage.removeItem("chat_session_token");
            chatBox.innerHTML = "";
            chatBox.style.display = "none";
            centerBox.style.display = "block";
            chatInput.classList.remove("bottom-fixed");
            tokenEl.style.display = "none";
        });
    }

    input.addEventListener("keypress", (e) => {
        if (e.key !== "Enter" || !input.value.trim()) return;

        centerBox.style.display = "none";
        chatBox.style.display = "block";
        chatInput.classList.add("bottom-fixed");

        const userMsg = input.value;
        input.value = "";
        input.disabled = true;
        input.placeholder = "Bot is typing...";

        const userRow = document.createElement("div");
        userRow.className = "d-flex justify-content-end";
        userRow.innerHTML = `<div class="message user-message">${userMsg}</div>`;
        chatBox.appendChild(userRow);

        const typingRow = document.createElement("div");
        typingRow.className = "d-flex justify-content-start";
        typingRow.innerHTML = `<div class="message bot-message">Bot is typing...</div>`;
        chatBox.appendChild(typingRow);

        chatBox.scrollTop = chatBox.scrollHeight;

        const payload = {
            message: userMsg,
            language: document.getElementById("chatLanguage")?.value || "en",
        };

        const token = localStorage.getItem("chat_session_token");
        if (token) {
            payload.session_token = token;
        }

        (async () => {
            try {
                const resp = await fetch("/api/chat/stream", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "text/event-stream",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify(payload),
                });

                if (!resp.ok) throw new Error("Stream failed: " + resp.status);

                typingRow.remove();

                const botRow = document.createElement("div");
                botRow.className = "d-flex justify-content-start";
                const botMsg = document.createElement("div");
                botMsg.className = "message bot-message";
                botRow.appendChild(botMsg);
                chatBox.appendChild(botRow);

                const reader = resp.body.getReader();
                const decoder = new TextDecoder();
                let buffer = "";

                while (true) {
                    const { done, value } = await reader.read();
                    if (done) break;

                    buffer += decoder.decode(value, { stream: true });
                    const parts = buffer.split("\n\n");
                    buffer = parts.pop();

                    for (const part of parts) {
                        const line = part.replace(/^data:\s*/, "").trim();
                        if (!line) continue;

                        const obj = JSON.parse(line);

                        if (obj.session_token) {
                            localStorage.setItem(
                                "chat_session_token",
                                obj.session_token
                            );
                            continue;
                        }

                        if (obj.delta) {
                            botMsg.innerText += obj.delta;
                        }
                    }

                    chatBox.scrollTop = chatBox.scrollHeight;
                }

                input.disabled = false;
                input.placeholder = "Ask anything...";
                input.focus();
            } catch (err) {
                typingRow.remove();
                chatBox.innerHTML += `<div class="message bot-message">Error: ${err.message}</div>`;
                input.disabled = false;
                input.placeholder = "Ask anything...";
            }
        })();
    });
});
