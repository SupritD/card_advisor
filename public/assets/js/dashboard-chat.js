document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("msgInput");
    const chatBox = document.getElementById("chatContainer");
    const centerBox = document.getElementById("centerBox");
    const inputArea = document.getElementById("inputArea");
    const chatInput = document.getElementById("chat-input-section");

    // If the page doesn't have the chat elements (e.g., different view), do nothing
    if (!input || !chatBox) return;

    // Attempt to restore previous session messages if we have a session token
    (async () => {
        try {
            const token = localStorage.getItem("chat_session_token");
            if (!token) return;
            const resp = await fetch(
                `/api/chat/history?session_token=${encodeURIComponent(token)}`,
                { credentials: "same-origin" }
            );
            if (!resp.ok) return;
            const data = await resp.json();
            if (!data.messages) return;

            data.messages.forEach((m) => {
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

            if (data.messages.length > 0) {
                chatBox.scrollTop = chatBox.scrollHeight;
                if (centerBox) centerBox.style.display = "none";
                chatBox.style.display = "block";
                if (chatInput) chatInput.classList.add("bottom-fixed");
            }
        } catch (e) {
            // ignore restore errors
            console.warn("Failed to restore chat session", e);
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
    // if (btnShow) {
    //     btnShow.addEventListener("click", () => {
    //         const t = localStorage.getItem("chat_session_token");
    //         tokenEl.innerText = t ? t : "No active session";
    //         tokenEl.style.display = "inline";

    //         setTimeout(() => {
    //             tokenEl.style.display = "none";
    //         }, 10000);
    //     });
    // }
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

//     if (btnShow) {
//         btnShow.addEventListener("click", function () {
//             const t = localStorage.getItem("chat_session_token");
//             if (!t) {
//                 tokenEl.innerText = "No active session.";
//                 tokenEl.style.display = "inline";
//                 setTimeout(() => {
//                     tokenEl.style.display = "none";
//                 }, 3000);
//                 return;
//             }
//             tokenEl.innerText = t + " (click to copy)";
//             tokenEl.style.display = "inline";

//             tokenEl.addEventListener(
//                 "click",
//                 async function copyToken() {
//                     try {
//                         await navigator.clipboard.writeText(t);
//                         tokenEl.innerText = "Copied to clipboard";
//                         setTimeout(() => {
//                             tokenEl.style.display = "none";
//                         }, 2000);
//                     } catch (e) {
//                         // fallback: select
//                         const tmp = document.createElement("textarea");
//                         tmp.value = t;
//                         document.body.appendChild(tmp);
//                         tmp.select();
//                         document.execCommand("copy");
//                         document.body.removeChild(tmp);
//                         tokenEl.innerText = "Copied to clipboard";
//                         setTimeout(() => {
//                             tokenEl.style.display = "none";
//                         }, 2000);
//                     }
//                     tokenEl.removeEventListener("click", copyToken);
//                 },
//                 { once: true }
//             );
//         });
//     }

//     if (btnClear) {
//         btnClear.addEventListener("click", async function () {
//             const t = localStorage.getItem("chat_session_token");
//             const ok = confirm(
//                 "Clear chat session? This will remove local history and optionally delete it from the server."
//             );
//             if (!ok) return;

//             if (t) {
//                 try {
//                     await fetch("/api/chat/session", {
//                         method: "DELETE",
//                         credentials: "same-origin",
//                         headers: {
//                             "Content-Type": "application/json",
//                             "X-CSRF-TOKEN": document
//                                 .querySelector('meta[name="csrf-token"]')
//                                 .getAttribute("content"),
//                         },
//                         body: JSON.stringify({ session_token: t }),
//                     });
//                 } catch (e) {
//                     console.warn("Failed to delete session on server", e);
//                 }
//             }

//             // clear local data and reset UI
//             localStorage.removeItem("chat_session_token");
//             tokenEl.style.display = "none";
//             chatBox.innerHTML = "";
//             if (centerBox) centerBox.style.display = "block";
//             chatBox.style.display = "none";
//             if (chatInput) chatInput.classList.remove("bottom-fixed");
//         });
//     }

//     let lastMsg = document.querySelector(".chat-container .message:last-child");

//     input.addEventListener("keypress", function (e) {
//         if (e.key === "Enter" && input.value.trim() !== "") {
//             // Move input to bottom on first message
//             if (centerBox) centerBox.style.display = "none";
//             chatBox.style.display = "block";
//             // inputArea.classList.add("bottom-fixed");
//             if (chatInput) {
//                 chatInput.classList.add("bottom-fixed");
//                 chatInput.classList.remove("w-100");
//             }

//             // Add message
//             const msgContainer = document.createElement("div");
//             msgContainer.className = "d-flex justify-content-end";
//             const msg = document.createElement("div");
//             msg.className = "message user-message";
//             msg.innerText = input.value;
//             // lastMsg.classList.remove("lst-msg-margin");
//             msgContainer.appendChild(msg);
//             chatBox.appendChild(msgContainer);

//             input.value = "";
//             // chatBox.scrollTop = chatBox.scrollHeight;
//             msgContainer.scrollIntoView({
//                 behavior: "smooth",
//                 block: "end",
//             });
//             input.disabled = true;
//             input.placeholder = "Bot is typing...";

//             // ===== SEND USER MESSAGE TO SERVER =====
//             const typingContainer = document.createElement("div");
//             typingContainer.className = "d-flex justify-content-start";
//             const typingMsg = document.createElement("div");
//             typingMsg.className = "message bot-message";
//             typingMsg.innerText = "Bot is typing...";
//             typingContainer.appendChild(typingMsg);
//             chatBox.appendChild(typingContainer);
//             typingContainer.scrollIntoView({
//                 behavior: "smooth",
//                 block: "end",
//             });

//             const langEl = document.getElementById("chatLanguage");
//             const language = langEl ? langEl.value : "en";

//             // Streaming POST request using fetch + readable stream
//             (async () => {
//                 try {
//                     const resp = await fetch("/api/chat/stream", {
//                         method: "POST",
//                         credentials: "same-origin",
//                         headers: {
//                             "Content-Type": "application/json",
//                             Accept: "text/event-stream",
//                             "X-Requested-With": "XMLHttpRequest",
//                             "X-CSRF-TOKEN": document
//                                 .querySelector('meta[name="csrf-token"]')
//                                 .getAttribute("content"),
//                         },
//                         body: JSON.stringify({
//                             message: msg.innerText,
//                             language,
//                             session_token:
//                                 localStorage.getItem("chat_session_token") ||
//                                 undefined,
//                         }),
//                     });

//                     if (!resp.ok)
//                         throw new Error(
//                             "Stream request failed: " + resp.status
//                         );

//                     const reader = resp.body.getReader();
//                     const decoder = new TextDecoder();
//                     let buffer = "";

//                     // create bot message container and append immediately so tokens can be streamed into it
//                     typingContainer.remove();
//                     const botContainer = document.createElement("div");
//                     botContainer.className = "d-flex justify-content-start";
//                     const botMsg = document.createElement("div");
//                     botMsg.className = "message bot-message";
//                     botMsg.innerText = "";
//                     botContainer.appendChild(botMsg);
//                     chatBox.appendChild(botContainer);

//                     while (true) {
//                         const { done, value } = await reader.read();
//                         if (done) break;
//                         buffer += decoder.decode(value, { stream: true });

//                         // SSE framing: segments separated by \n\n; lines may have `data: ...`
//                         let parts = buffer.split("\n\n");
//                         buffer = parts.pop();

//                         for (const part of parts) {
//                             if (!part) continue;
//                             let line = part.replace(/^data:\s*/, "").trim();
//                             if (line === "") continue;
//                             try {
//                                 const obj = JSON.parse(line);
//                                 if (obj.done) {
//                                     // end of stream
//                                     reader.cancel();
//                                     break;
//                                 }

//                                 // session token event
//                                 if (obj.session_token) {
//                                     try {
//                                         localStorage.setItem(
//                                             "chat_session_token",
//                                             obj.session_token
//                                         );
//                                     } catch (e) {
//                                         // ignore storage errors
//                                     }
//                                     continue;
//                                 }

//                                 if (obj.delta) {
//                                     botMsg.innerText += obj.delta;
//                                     botMsg.scrollIntoView({
//                                         behavior: "smooth",
//                                         block: "end",
//                                     });
//                                 } else if (obj.chunk) {
//                                     // Fallback: chunk may itself be a JSON string containing further tokens;
//                                     // try to parse it and extract deltas, otherwise append as text.
//                                     try {
//                                         const inner = JSON.parse(obj.chunk);
//                                         // try common shapes
//                                         if (inner.choices && inner.choices[0]) {
//                                             const c = inner.choices[0];
//                                             if (c.delta && c.delta.content) {
//                                                 botMsg.innerText +=
//                                                     c.delta.content;
//                                             } else if (
//                                                 c.message &&
//                                                 c.message.content
//                                             ) {
//                                                 botMsg.innerText +=
//                                                     c.message.content;
//                                             } else if (c.content) {
//                                                 botMsg.innerText += c.content;
//                                             } else {
//                                                 botMsg.innerText += obj.chunk;
//                                             }
//                                         } else {
//                                             botMsg.innerText += obj.chunk;
//                                         }
//                                     } catch (e) {
//                                         botMsg.innerText += obj.chunk;
//                                     }
//                                     botMsg.scrollIntoView({
//                                         behavior: "smooth",
//                                         block: "end",
//                                     });
//                                 }
//                             } catch (e) {
//                                 // not JSON, append raw
//                                 botMsg.innerText += line;
//                                 botMsg.scrollIntoView({
//                                     behavior: "smooth",
//                                     block: "end",
//                                 });
//                             }
//                         }
//                     }

//                     // finalize
//                     botMsg.scrollIntoView({ behavior: "smooth", block: "end" });
//                     input.disabled = false;
//                     input.placeholder = "Type your message...";
//                     input.focus();
//                 } catch (err) {
//                     typingContainer.remove();
//                     const botContainer = document.createElement("div");
//                     botContainer.className = "d-flex justify-content-start";

//                     const botMsg = document.createElement("div");
//                     botMsg.className = "message bot-message";
//                     botMsg.innerText =
//                         "Error: " + (err.message || "Request failed");

//                     botContainer.appendChild(botMsg);
//                     chatBox.appendChild(botContainer);

//                     botContainer.scrollIntoView({
//                         behavior: "smooth",
//                         block: "end",
//                     });

//                     input.disabled = false;
//                     input.placeholder = "Type your message...";
//                     input.focus();
//                 }
//             })();
//         }
//     });
// });
