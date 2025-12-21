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

            // ===== BOT RESPONSE AFTER 3 SECONDS =====
            setTimeout(() => {
                const botContainer = document.createElement("div");
                botContainer.className = "d-flex justify-content-start";

                const botMsg = document.createElement("div");
                botMsg.className = "message bot-message";
                botMsg.innerText = "This is an automated response.";

                botContainer.appendChild(botMsg);
                chatBox.appendChild(botContainer);

                botContainer.scrollIntoView({ behavior: "smooth", block: "end" });

                input.disabled = false;
                input.placeholder = "Type your message...";
                input.focus();

            }, 3000);
        }
    });
});
