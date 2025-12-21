document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById("msgInput");
    const chatBox = document.getElementById("chatContainer");
    const centerBox = document.getElementById("centerBox");
    const inputArea = document.getElementById("inputArea");
    const chatInput = document.getElementById("chat-input-section");

    // If the page doesn't have the chat elements (e.g., different view), do nothing
    if (!input || !chatBox) return;

    let lastMsg = document.querySelector(".chat-container .message:last-child");

    input.addEventListener("keypress", function (e) {
        if (e.key === "Enter" && input.value.trim() !== "") {
            // Move input to bottom on first message
            if (centerBox) centerBox.style.display = "none";
            chatBox.style.display = "block";
            // inputArea.classList.add("bottom-fixed");
            if (chatInput) {
                chatInput.classList.add("bottom-fixed");
                chatInput.classList.remove("w-100");
            }

            // Add message
            const msgContainer = document.createElement("div");
            msgContainer.className = "d-flex justify-content-end";
            const msg = document.createElement("div");
            msg.className = "message user-message";
            msg.innerText = input.value;
            // lastMsg.classList.remove("lst-msg-margin");
            msgContainer.appendChild(msg);
            chatBox.appendChild(msgContainer);

            input.value = "";
            // chatBox.scrollTop = chatBox.scrollHeight;
            msgContainer.scrollIntoView({
                behavior: "smooth",
                block: "end"
            });
            input.disabled = true;
            input.placeholder = "Bot is typing...";

            // ===== SEND USER MESSAGE TO SERVER =====
            const typingContainer = document.createElement("div");
            typingContainer.className = "d-flex justify-content-start";
            const typingMsg = document.createElement("div");
            typingMsg.className = "message bot-message";
            typingMsg.innerText = "Bot is typing...";
            typingContainer.appendChild(typingMsg);
            chatBox.appendChild(typingContainer);
            typingContainer.scrollIntoView({ behavior: "smooth", block: "end" });

            const langEl = document.getElementById('chatLanguage');
            const language = langEl ? langEl.value : 'en';

            // Streaming POST request using fetch + readable stream
            (async () => {
                try {
                    const resp = await fetch('/api/chat/stream', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'text/event-stream',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ message: msg.innerText, language })
                    });

                    if (!resp.ok) throw new Error('Stream request failed: ' + resp.status);

                    const reader = resp.body.getReader();
                    const decoder = new TextDecoder();
                    let buffer = '';

                    // create bot message container and append immediately so tokens can be streamed into it
                    typingContainer.remove();
                    const botContainer = document.createElement("div");
                    botContainer.className = "d-flex justify-content-start";
                    const botMsg = document.createElement("div");
                    botMsg.className = "message bot-message";
                    botMsg.innerText = '';
                    botContainer.appendChild(botMsg);
                    chatBox.appendChild(botContainer);

                    while (true) {
                        const { done, value } = await reader.read();
                        if (done) break;
                        buffer += decoder.decode(value, { stream: true });

                        // SSE framing: segments separated by \n\n; lines may have `data: ...`
                        let parts = buffer.split('\n\n');
                        buffer = parts.pop();

                        for (const part of parts) {
                            if (!part) continue;
                            let line = part.replace(/^data:\s*/, '').trim();
                            if (line === '') continue;
                            try {
                                const obj = JSON.parse(line);
                                if (obj.done) {
                                    // end of stream
                                    reader.cancel();
                                    break;
                                }
                                if (obj.delta) {
                                    botMsg.innerText += obj.delta;
                                    botMsg.scrollIntoView({ behavior: 'smooth', block: 'end' });
                                } else if (obj.chunk) {
                                    // Fallback: chunk may itself be a JSON string containing further tokens;
                                    // try to parse it and extract deltas, otherwise append as text.
                                    try {
                                        const inner = JSON.parse(obj.chunk);
                                        // try common shapes
                                        if (inner.choices && inner.choices[0]) {
                                            const c = inner.choices[0];
                                            if (c.delta && c.delta.content) {
                                                botMsg.innerText += c.delta.content;
                                            } else if (c.message && c.message.content) {
                                                botMsg.innerText += c.message.content;
                                            } else if (c.content) {
                                                botMsg.innerText += c.content;
                                            } else {
                                                botMsg.innerText += obj.chunk;
                                            }
                                        } else {
                                            botMsg.innerText += obj.chunk;
                                        }
                                    } catch (e) {
                                        botMsg.innerText += obj.chunk;
                                    }
                                    botMsg.scrollIntoView({ behavior: 'smooth', block: 'end' });
                                }
                            } catch (e) {
                                // not JSON, append raw
                                botMsg.innerText += line;
                                botMsg.scrollIntoView({ behavior: 'smooth', block: 'end' });
                            }
                        }
                    }

                    // finalize
                    botMsg.scrollIntoView({ behavior: 'smooth', block: 'end' });
                    input.disabled = false;
                    input.placeholder = "Type your message...";
                    input.focus();
                } catch (err) {
                    typingContainer.remove();
                    const botContainer = document.createElement("div");
                    botContainer.className = "d-flex justify-content-start";

                    const botMsg = document.createElement("div");
                    botMsg.className = "message bot-message";
                    botMsg.innerText = 'Error: ' + (err.message || 'Request failed');

                    botContainer.appendChild(botMsg);
                    chatBox.appendChild(botContainer);

                    botContainer.scrollIntoView({ behavior: "smooth", block: "end" });

                    input.disabled = false;
                    input.placeholder = "Type your message...";
                    input.focus();
                }
            })();
        }
    });
});
