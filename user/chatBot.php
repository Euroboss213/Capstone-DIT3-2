<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple ChatBot</title>
    <link rel="stylesheet" href="../styles/chatBot.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-box" id="chatBox">
            <!-- Messages will appear here -->
        </div>
        <form id="chatForm" onsubmit="sendMessage(event )">
            <input type="text" id="userInput" placeholder="Type a message..." autocomplete="off" required>
            <button type="submit">Send</button>
        </form>
    </div>

    <script src="../js/chatBot.js"></script>
</body>
</html>
