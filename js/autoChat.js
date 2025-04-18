const chatBox = document.getElementById("autoChatBox");

const faqs = {
  "How to request a Barangay Clearance?": {
    answer: "To request a Barangay Clearance, bring a valid ID and go to the barangay office. It usually costs ₱50.",
    related: ["How long does it take to get a Barangay Clearance?", "Can I request a clearance online?"]
  },
  "How to get a Certificate of Residency?": {
    answer: "Bring proof of residency (like a utility bill) and a valid ID to request a Certificate of Residency.",
    related: ["Do I need a Barangay ID to get residency?", "Is there a fee for the certificate?"]
  },
  "Requirements for Indigency Certificate": {
    answer: "Bring a valid ID and proof of low income. Processing is done within the day.",
    related: ["Who qualifies as indigent?", "Can someone else request on my behalf?"]
  }
};

const relatedAnswers = {
  "How long does it take to get a Barangay Clearance?": "Usually takes 15–30 minutes if there’s no queue.",
  "Can I request a clearance online?": "Currently, requests must be made in person.",
  "Do I need a Barangay ID to get residency?": "It's helpful but not always required.",
  "Is there a fee for the certificate?": "Yes, typically ₱20–₱50 depending on the barangay.",
  "Who qualifies as indigent?": "Residents with little or no income based on barangay assessment.",
  "Can someone else request on my behalf?": "Yes, with a signed authorization letter and IDs."
};

// Add a chat message
function addMessage(message, sender = "bot") {
  const msgDiv = document.createElement("div");
  msgDiv.classList.add(sender === "user" ? "auto-user-message" : "auto-bot-message");
  msgDiv.textContent = message;
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

// Clear the chat box
function clearChat() {
  chatBox.innerHTML = "";
}

// Disable all buttons currently in the chat
function disablePreviousButtons() {
  const buttons = chatBox.querySelectorAll("button");
  buttons.forEach(btn => {
    btn.disabled = true;
    btn.style.opacity = "0.6";
    btn.style.cursor = "not-allowed";
  });
}

// Show the list of main FAQ questions
function showMainQuestions() {
  addMessage("Hi! How can I assist you today?");
  Object.keys(faqs).forEach(question => {
    const btn = document.createElement("button");
    btn.className = "choice-btn auto-user-message";
    btn.textContent = question;
    btn.onclick = () => handleFaqClick(question, btn);
    chatBox.appendChild(btn);
    chatBox.scrollTop = chatBox.scrollHeight;
  });
}

// Handle click on a main FAQ question
function handleFaqClick(question, btn) {
  // Disable all existing buttons (main options)
  disablePreviousButtons();

  addMessage(question, "user");
  setTimeout(() => {
    addMessage(faqs[question].answer, "bot");
    showAfterAnswerOptions(question);
  }, 500);
}

// After showing the answer, present "View Related" and "Back" buttons
function showAfterAnswerOptions(selectedQuestion) {
  const related = faqs[selectedQuestion].related;

  // View Related Questions button
  const relatedBtn = document.createElement("button");
  relatedBtn.className = "choice-btn";
  relatedBtn.textContent = "View Related Questions";
  relatedBtn.onclick = () => {
    // Disable this button to prevent re-clicks
    relatedBtn.disabled = true;
    relatedBtn.style.opacity = "0.6";
    relatedBtn.style.cursor = "not-allowed";
    backBtn.disabled = true;
    backBtn.style.opacity = "0.6";
    backBtn.style.cursor = "not-allowed";
    showRelated(related);
  };
  chatBox.appendChild(relatedBtn);

  // Back to Main Questions button
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

// Display related questions and handle their clicks
function showRelated(relatedList) {
  addDivider();

  relatedList.forEach(relQuestion => {
    const btn = document.createElement("button");
    btn.className = "choice-btn auto-user-message";
    btn.textContent = relQuestion;
    btn.onclick = () => {
      // Disable all related-question buttons immediately
      disablePreviousButtons();

      addMessage(relQuestion, "user");
      setTimeout(() => {
        addMessage(relatedAnswers[relQuestion], "bot");

        // After showing the answer, add Back to Main Questions button
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

// Initialize the FAQ chatbot
showMainQuestions();
