<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple ChatBot</title>
    <link rel="stylesheet" href="../styles/chatBot.css">
</head>
<body>
<div class="chatBot-container">
          <div class="chatBot-box" id="chatBotBox">
              <!-- Messages will appear here -->
          </div>
          <form id="chatBotForm" onsubmit="sendMessage(event )">
              <input type="text" id="userInput" placeholder="Type a message..." autocomplete="off" required>
              <button type="submit">Send</button>
          </form>
        </div>

    <script src="../js/chatBot.js"></script>
</body>
</html>
