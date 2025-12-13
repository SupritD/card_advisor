 const input = document.getElementById("msgInput");
    const chatBox = document.getElementById("chatContainer");
    const centerBox = document.getElementById("centerBox");
    const inputArea = document.getElementById("inputArea");
const chatInput = document.getElementById("chat-input-section");
let lastMsg = document.querySelector(".chat-container .message:last-child");
    input.addEventListener("keypress", function (e) {
        if (e.key === "Enter" && input.value.trim() !== "") {

            // Move input to bottom on first message
            centerBox.style.display = "none";
            chatBox.style.display = "block";
            // inputArea.classList.add("bottom-fixed");
            chatInput.classList.add("bottom-fixed");
            chatInput.classList.remove("w-100");

            // Add message
            const msgContainer = document.createElement("div");
            msgContainer.className = "d-flex justify-content-end";
            const msg = document.createElement("div");
            msg.className = "message user-message lst-msg-margin";
            msg.innerText = input.value;
            // lastMsg.classList.remove("lst-msg-margin");
            msgContainer.appendChild(msg);
            chatBox.appendChild(msgContainer);

            input.value = "";
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });