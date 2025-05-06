let overlay = null;
let messageBox = null;
let hideTimeout = null;

function ShowMessage(text) {
  if (!overlay) {
    // Vytvor root overlay
    overlay = document.createElement("div");
    overlay.classList.add("overlay");

    const infoBox = document.createElement("div");
    infoBox.classList.add("logon_information");

    // Ikona
    const circle = document.createElement("div");
    circle.classList.add("circle", "success");
    const icon = document.createElement("i");
    icon.classList.add("fa", "fa-check-circle"); // Font Awesome ikona
    circle.appendChild(icon);

    // Textová časť
    messageBox = document.createElement("div");
    messageBox.classList.add("logon_information_text");

    // Poskladanie celého boxu
    infoBox.appendChild(circle);
    infoBox.appendChild(messageBox);
    overlay.appendChild(infoBox);
    document.body.appendChild(overlay);
  }

  // Zruš predchádzajúce skrytie
  if (hideTimeout) {
    clearTimeout(hideTimeout);
  }

  // Nastav nový text
  messageBox.innerHTML = text;

  // Reštartuj animáciu
  overlay.classList.remove("hidden", "fade-out");
  void overlay.offsetWidth;
  overlay.classList.add("fade-out");

  // Skry po 3 sekundách
  hideTimeout = setTimeout(() => {
    overlay.classList.add("hidden");
  }, 3000);
}
