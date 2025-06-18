
  function sendMessage(){
    const input = document.getElementById("user-input");
    const message = input.value.trim();
    const chat = document.getElementById("chat-messages");
    if(!message) return;
  addMessage("user", message);
  input.value = "";

  setTimeout(() => {
    respondToMessage(message);
  }, 1000);
}

function sendQuick(text) {
  const input = document.getElementById("user-input");

  addMessage("user", text);
  setTimeout(() => {
    respondToMessage(text);
  }, 1000);
}

function addMessage(sender, text) {
  const chat = document.getElementById("chat-messages");
  const msg = document.createElement("div");
  msg.className = sender + "-message";
  msg.textContent = text;
  chat.appendChild(msg);
  chat.scrollTop = chat.scrollHeight;
}

function respondToMessage(text) {
  text = text.toLowerCase().replace(/[^\w\s]/gi, "");
  let response = "Thanks for your message. I’ll help you shortly.";

  if (text.includes("mpc")) {
    response = "MPC (Maths, Physics, Chemistry) is best for future engineers, tech experts, and scientists. It requires hard work.";
  } else if (text.includes("heg")) {
    response = "HEG (History, Economics, Geography) is ideal for careers in law, business, or social studies.";
  } else if (text.includes("mce")) {
    response = "MCE (Maths, Computer Science, Economy) suits students aiming to be accountants, computer engineers, or entrepreneurs.";
  } else if (text.includes("meg")) {
    response = "MEG (Maths, Economy, Geography) is great for business, social studies, and sometimes aviation.";
  } else if (text.includes("choose") || text.includes("combination")) {
    response = "To choose a combination, think about your best subjects and future dreams. Want help deciding?";
  } else if (text.includes("career")) {
    response = "Different combinations lead to different careers. For example, MPC for engineering, HEG for business.";
  } else if (text.includes("choice")) {
    response = "Life is full of choices. Your combination is one of them—a step toward your future.";
  } else if (text.includes("languages")) {
    response = "Languages connect us. They’re bridges between cultures and keys to communication.";
  } else if (text.includes("future")) {
    response = "Your future is shaped by your choices today. Dream big and take steps toward it.";
  } else if (text.includes("science")) {
    response = "Science is key to innovation. It’s essential for engineers, doctors, and tech experts. Combinations like MPC, PCB, MCE, and MEG work well.";
  } else if (text.includes("math")) {
    response = "Math is the language of the universe. Great for MPC, MCE, MEG, and PCB.";
  } else if (text.includes("pilot")) {
    response = "Piloting needs strong math skills. Combinations like MPC and MEG are ideal.";
  } else if (text.includes("doctor") || text.includes("medicine")) {
    response = "Becoming a doctor needs strong science and math. The best combinations are PCB and MCB.";
  } else if (text.includes("lawyer")) {
    response = "Law needs critical thinking and communication. HEG and MEG are best.";
  } else if (text.includes("business")) {
    response = "Business values math and communication. MCE and MEG are great options.";
  } else if (text.includes("agriculture")) {
    response = "Agriculture needs science and math. MPC and PCB are great combinations.";
  } else if (text.includes("teacher")) {
    response = "Teaching needs strong communication. Practice speaking and helping others.";
  } else if (text.includes("politician")) {
    response = "Politics needs communication and thinking. HEG and MEG are ideal.";
  } else if (text.includes("social science")) {
    response = "Social sciences are for careers in law, business, and society. HEG and MEG are perfect.";
  } else if (text.endsWith("?") || text.includes("how") || text.includes("why") || text.includes("when") || text.includes("where")) {
    response = "That's a great question! Can you give me more details?";
  } else if (text.includes("help")) {
    response = "I’m here to help. What do you need?";
  } else if (text.includes("thank")) {
    response = "You’re welcome!";
  } else if (text.includes("hello")) {
    response = "Hello my dear, how can I help you today?";
  } else if (text.includes("hi")) {
    response = "Hi there! What can I help you with?";
  } else if (text.includes("good morning")) {
    response = "Good morning! What would you like to talk about today?";
  } else if (text.includes("i like") || text.includes("i enjoy")) {
    response = "That's great! Tell me more about what you enjoy.";
  } else if (text.includes("confused") || text.includes("dont know") || text.includes("lost")) {
    response = "It’s okay to feel unsure. Let’s explore your favorite subjects.";
  } else if (text.includes("motivate") || text.includes("encourage")) {
    response = "Believe in yourself! Each step you take brings you closer.";
  } else if (text.endsWith("!")) {
    response = "Wow, that's exciting! Tell me more.";
  } else {
    response = "I'm not sure I understand. Could you please rephrase?";
  }

  addMessage("bot", response); 
}
