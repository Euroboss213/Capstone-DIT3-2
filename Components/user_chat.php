<div class="chat-containers" id="id_cont">
  <!-- AI Assistant Chat -->
  <div class="chatBot-container">
    <div class="exit-header">
      <div class="chat-title">
        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712137.png" alt="Bot Icon" class="bot-icon">
        <span>AI Assistant (General Questions)</span>
      </div>
     <button class="bot-exit-btn" title="Close Chat">&times;</button>
    </div>
    <div class="chatBot-box" id="chatBotBox">
      <!-- Messages will appear here -->
    </div>
    <form id="chatBotForm" onsubmit="sendMessage(event)">
      <input type="text" id="userInput" placeholder="Type a message..." autocomplete="off" required>
      <button type="submit">Send</button>
    </form>
  </div>

  <!-- Auto Chat Bot -->
 <div class="autoChat-container">
  <div class="exit-header">
  <div class="chat-title">
    <img src="https://cdn-icons-png.flaticon.com/512/4712/4712106.png" alt="Bot Icon" class="bot-icon">
    <span>REQWEST Chat Bot</span>
  </div>
  <button class="chat-exit-btn" title="Close Chat">&times;</button>
</div>

  <div class="autoChat-box" id="autoChatBox">
    <!-- Chat messages will be added here -->
  </div>
</div>