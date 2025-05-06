<div class="chat-containers">
  <!-- AI Assistant Chat -->
  <div class="chatBot-container">
    <div class="exit-header">
      <button class="clear-btn" id="clearChatBtn">Clear</button>
      <button class="bot-exit-btn">Exit</button>
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
      <button class="chat-exit-btn">Exit</button>
    </div>
    <div class="autoChat-box" id="autoChatBox">
      <!-- Chat messages will be added here -->
    </div>
  </div>
</div>