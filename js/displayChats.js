document.addEventListener('DOMContentLoaded', function () {
    // Get references to the buttons and chat containers
    const chatBotBtn = document.getElementById('chatBot-btn');
    const autoChatBtn = document.getElementById('autoChat-btn');
    const chatBotContainer = document.querySelector('.chatBot-container');      
    const autoChatContainer = document.querySelector('.autoChat-container');
    const idCont = document.getElementById("id_cont");
    
    // Get references to the exit buttons
    const botExitBtn = document.querySelector('.bot-exit-btn');
    const chatExitBtn = document.querySelector('.chat-exit-btn');

    // Function to show the chat container based on the button clicked
    function showChatContainer(containerToShow) {
        // Hide both containers
        chatBotContainer.style.display = 'none';
        autoChatContainer.style.display = 'none';
        idCont.style.zIndex = "100";

        // Show the selected container
        containerToShow.style.display = 'flex';
    }

    // Add event listeners to buttons to show containers
    chatBotBtn.addEventListener('click', function () {
        showChatContainer(chatBotContainer);
    });

    autoChatBtn.addEventListener('click', function () {
        showChatContainer(autoChatContainer);
    });

    // Function to hide the chat containers (exit functionality)
    function hideChatContainer() {
        chatBotContainer.style.display = 'none';
        autoChatContainer.style.display = 'none';
        idCont.style.zIndex = "-1";
    }

    // Add event listeners to exit buttons
    botExitBtn.addEventListener('click', hideChatContainer);
    chatExitBtn.addEventListener('click', hideChatContainer);
});
