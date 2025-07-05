<!-- <style>
#chatbox {
  position: fixed;
  bottom: 20px; right: 20px;
  width: 300px; height: 400px;
  background: #f5f5f5;
  border: 1px solid #ccc;
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  font-family: Arial, sans-serif;
}
#chat-messages {
  flex: 1;
  padding: 10px;
  overflow-y: auto;
}
.message {
  max-width: 70%;
  margin-bottom: 8px;
  padding: 8px 12px;
  border-radius: 15px;
  clear: both;
  word-wrap: break-word;
}
.message.self {
  background: #0084ff;
  color: white;
  float: right;
  border-bottom-right-radius: 0;
}
.message.other {
  background: #e5e5ea;
  color: black;
  float: left;
  border-bottom-left-radius: 0;
}
#chat-input {
  display: flex;
  border-top: 1px solid #ccc;
}
#chat-input input {
  flex: 1;
  padding: 10px;
  border: none;
  border-radius: 0 0 0 10px;
  outline: none;
}
#chat-input button {
  background: #0084ff;
  border: none;
  color: white;
  padding: 0 20px;
  cursor: pointer;
  border-radius: 0 0 10px 0;
}
</style>

<div id="chatbox">
  <div id="chat-messages"></div>
  <div id="chat-input">
    <input type="text" id="messageInput" placeholder="Nhập tin nhắn...">
    <button id="sendBtn">Gửi</button>
  </div>
</div>

<script>
const sender = prompt("Nhập tên của bạn") || "Khách"; // tên người gửi tạm

const chatMessages = document.getElementById('chat-messages');
const messageInput = document.getElementById('messageInput');
const sendBtn = document.getElementById('sendBtn');

// Hàm lấy tin nhắn từ server
function loadMessages() {
  fetch('chat_backend.php')
    .then(res => res.json())
    .then(data => {
      chatMessages.innerHTML = '';
      data.forEach(msg => {
        const div = document.createElement('div');
        div.classList.add('message');
        div.classList.add(msg.sender === sender ? 'self' : 'other');
        div.textContent = msg.sender + ': ' + msg.message;
        chatMessages.appendChild(div);
      });
      chatMessages.scrollTop = chatMessages.scrollHeight;
    });
}

// Gửi tin nhắn lên server
function sendMessage() {
  const message = messageInput.value.trim();
  if (!message) return;
  fetch('chat_backend.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `sender=${encodeURIComponent(sender)}&message=${encodeURIComponent(message)}`
  })
  .then(res => res.json())
  .then(res => {
    if (res.status === 'success') {
      messageInput.value = '';
      loadMessages();
    } else {
      alert('Gửi tin nhắn thất bại');
    }
  });
}

sendBtn.addEventListener('click', sendMessage);
messageInput.addEventListener('keydown', e => {
  if (e.key === 'Enter') sendMessage();
});

// Tự động tải tin nhắn mỗi 3 giây
setInterval(loadMessages, 3000);
loadMessages();
</script> -->
