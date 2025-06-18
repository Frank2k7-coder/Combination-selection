<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ASK AI</title>
  <link rel="stylesheet" href="caht.css">
</head>
<body>
  <div class="chat-container">
    <div class="chat-header">
      <img src="https://img.freepik.com/free-vector/robotic-artificial-intelligence-technology-smart-lerning-from-bigdata_1150-48136.jpg?semt=ais_hybrid&w=740" alt="Assistant" class="avatar">
      <h2>Student AI Assistant</h2>
    </div>
    <div class="chat-messages" id="chat-messages">
      <div class="bot-message">Hi! How can I help you choose your combination?</div>
    </div>
    <div class="quick-replies">
      <button onclick="sendQuic('MPC')">MPC</button>
      <button onclick="sendQuick('PCB')">PCB</button>
      <button onclick="sendQuick('MEG')">MEG</button>
      <button onclick="sendQuick('MCE')">MCE</button>  
      <button onclick="sendQuick('HGL')">HGL</button>  
      <button onclick="sendQuick('Science')">social Science</button>
      <button onclick="sendQuick('Math & Physics')">Math & Physics</button>
      <button onclick="sendQuick('Languages')">Languages</button>
    </div>
    <div class="chat-input">
      <input type="text" id="user-input" placeholder="Type your message...">
      <button onclick="sendMessage()">Send</button>
      <button onclick="startVoice()">🎤</button>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
