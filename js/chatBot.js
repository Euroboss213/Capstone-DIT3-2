function sendMessage(event) {
  if (event) event.preventDefault();

  const userInput = document.getElementById("userInput").value.trim();
  const chatBox = document.getElementById("chatBox");

  if (userInput === "") return;

  // Display user message
  const userMessage = document.createElement("div");
  userMessage.className = "user-message";
  userMessage.textContent = userInput;
  chatBox.appendChild(userMessage);

  // Send user message to PHP via fetch
  fetch("../php/chatbotFunction.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ message: userInput }),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      const botMessage = document.createElement("div");
      botMessage.className = "bot-message";

      let formattedText = data.error ? `Bot: ${data.error}` : data.response;

      // Replace * bullet points with list items
      if (formattedText.includes("*")) {
        const lines = formattedText.split("\n");
        let listHTML = "<ul>";
        lines.forEach((line) => {
          if (line.trim().startsWith("*")) {
            listHTML += `<li>${line.replace(/^\*\s*/, "")}</li>`;
          } else {
            listHTML += `<p>${line}</p>`;
          }
        });
        listHTML += "</ul>";
        botMessage.innerHTML = listHTML;
      } else {
        botMessage.textContent = `Bot: ${formattedText}`;
      }

      chatBox.appendChild(botMessage);
      document.getElementById("userInput").value = "";
      chatBox.scrollTop = chatBox.scrollHeight;
    })
    .catch((error) => {
      const errorMessage = document.createElement("div");
      errorMessage.className = "bot-message";
      errorMessage.textContent = `Bot: Failed to fetch response (${error.message})`;
      chatBox.appendChild(errorMessage);
      console.error("Fetch error:", error);
    });
}
