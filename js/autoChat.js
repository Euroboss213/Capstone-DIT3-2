const chatBox = document.getElementById("autoChatBox");

const faqs = {
  "What is the Address of Barangay West Kamias?": {
    answer: "2, K-10th Street, Cubao, Quezon City, 1109, Metro Manila, Philippines",
    related: ["What are the current available documents that I can request using the Reqwest System?"]
  },
  "What are the current available documents that I can request using the Reqwest System?": {
    answer: `
  <ul>
    <li><strong>Certificate of Residency:</strong> Certifies that a person is a resident of the barangay.</li>
    <li><strong>Barangay Indigency:</strong> For residents who are low-income or financially disadvantaged.</li>
    <li><strong>Barangay Permit:</strong> For school, travel, or employment requirements.</li>
    <li><strong>Barangay Good Moral Certificate:</strong> Affirms good behavior and no derogatory records.</li>
  </ul>
`,
related: ["How do I Request for a document using the Reqwest System?"]
  },
  "How do I Request for a document using the Reqwest System?": {
    answer: "On the Request Page, select the document type, fill out the form with the necessary requirements, then click submit. Wait for a Barangay Official to respond. The request may be Approved or Returned depending on your submission.",
    related: ["How long does it take for my document request to be approved?", "How do I get my document?"]
  },
  "How long does it take for my document request to be approved?": {
    answer: "If there are no issues, the request is approved within the same day (Monday to Friday). If returned, it depends on how quickly you resubmit the corrected request.",
    related: ["How do I get my document?"]
  },
  "How do I get my document?": {
    answer: "Once approved, the status will change to 'For Pickup'. Follow the instructions in the official's comment and proceed to the barangay office to claim your document. Pay fees if necessary.",
    related: ["How much is the fee for certificate of Indigency?", "How much is the fee for certificate of Residency?"]
  },
  "How much is the fee for certificate of Indigency?": {
    answer: "In Quezon City, a Certificate of Indigency is typically free of charge.",
    related: ["What are the current available documents that I can request using the Reqwest System?"]
  },
  "How much is the fee for certificate of Residency?": {
    answer: "In Quezon City, this ranges from ₱20 to ₱100. Prepare this amount so you're ready when the Barangay official confirms the fee.",
    related: ["How do I get my document?"]
  },
  "How much is the fee for Barangay Permit?": {
    answer: "In Quezon City, Barangay Permits range from ₱50 to ₱200 depending on purpose. Prepare the amount indicated by the Barangay official.",
    related: ["What are the current available documents that I can request using the Reqwest System?"]
  },
  "How much is the fee for Barangay Good Moral?": {
    answer: "In Quezon City, the fee typically ranges from ₱20 to ₱100. The exact amount will be noted by the Barangay official.",
    related: ["How do I get my document?"]
  }
};

// Display a message
function addMessage(message, sender = "bot") {
  const msgDiv = document.createElement("div");
  msgDiv.classList.add(sender === "user" ? "auto-user-message" : "auto-bot-message");

  if (sender === "bot") {
    msgDiv.innerHTML = message; // Render HTML for bot messages
  } else {
    msgDiv.textContent = message; // Keep user input safe
  }

  chatBox.appendChild(msgDiv);
  chatBox.scrollTop = chatBox.scrollHeight;
}
// Add a divider line
function addDivider(text = "Related Questions") {
  const divider = document.createElement("div");
  divider.className = "divider";
  divider.textContent = text;
  chatBox.appendChild(divider);
}

// Clear all messages
function clearChat() {
  chatBox.innerHTML = "";
}

// Disable all buttons to prevent re-clicks
function disablePreviousButtons() {
  const buttons = chatBox.querySelectorAll("button");
  buttons.forEach(btn => {
    btn.disabled = true;
    btn.style.opacity = "0.6";
    btn.style.cursor = "not-allowed";
  });
}

// Show all FAQ questions
function showMainQuestions() {
  addMessage("Welcome, ka-barangay. How can I help you?");
  Object.keys(faqs).forEach(question => {
    const btn = document.createElement("button");
    btn.className = "choice-btn auto-user-message";
    btn.textContent = question;
    btn.onclick = () => handleFaqClick(question, btn);
    chatBox.appendChild(btn);
    chatBox.scrollTop = chatBox.scrollHeight;
  });
}

// Handle user selecting a question
function handleFaqClick(question, btn) {
  disablePreviousButtons();
  addMessage(question, "user");

  setTimeout(() => {
    addMessage(faqs[question].answer, "bot");
    showAfterAnswerOptions(question);
  }, 500);
}

// Show "View Related" and "Back" buttons
function showAfterAnswerOptions(selectedQuestion) {
  const related = faqs[selectedQuestion].related;

  const relatedBtn = document.createElement("button");
  relatedBtn.className = "choice-btn";
  relatedBtn.textContent = "View Related Questions";
  relatedBtn.onclick = () => {
    relatedBtn.disabled = true;
    relatedBtn.style.opacity = "0.6";
    relatedBtn.style.cursor = "not-allowed";
    backBtn.disabled = true;
    backBtn.style.opacity = "0.6";
    backBtn.style.cursor = "not-allowed";
    showRelated(related);
  };
  chatBox.appendChild(relatedBtn);

  const backBtn = document.createElement("button");
  backBtn.className = "choice-btn";
  backBtn.textContent = "Back to Main Questions";
  backBtn.onclick = () => {
    clearChat();
    showMainQuestions();
  };
  chatBox.appendChild(backBtn);

  chatBox.scrollTop = chatBox.scrollHeight;
}

// Show related questions and handle answers
function showRelated(relatedList) {
  addDivider();

  relatedList.forEach(relQuestion => {
    const btn = document.createElement("button");
    btn.className = "choice-btn auto-user-message";
    btn.textContent = relQuestion;
    btn.onclick = () => {
      disablePreviousButtons();
      addMessage(relQuestion, "user");
      setTimeout(() => {
        addMessage(faqs[relQuestion]?.answer || "Sorry, I don't have information on that yet.", "bot");

        const backBtn = document.createElement("button");
        backBtn.className = "choice-btn";
        backBtn.textContent = "Back to Main Questions";
        backBtn.onclick = () => {
          clearChat();
          showMainQuestions();
        };
        chatBox.appendChild(backBtn);
        chatBox.scrollTop = chatBox.scrollHeight;
      }, 500);
    };
    chatBox.appendChild(btn);
    chatBox.scrollTop = chatBox.scrollHeight;
  });
}

// Initialize the chatbot
showMainQuestions();
