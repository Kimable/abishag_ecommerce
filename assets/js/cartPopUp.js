class CartPopup {
  constructor() {
    this.initializePopup();
    this.createBlurOverlay();
  }

  initializePopup() {
    // Create popup element if it doesn't exist
    if (!document.getElementById("cart-popup")) {
      const popup = document.createElement("div");
      popup.id = "cart-popup";
      popup.style.cssText = `
        display: none;
        position: fixed;
        top: 40px;
        right: 20px;
        background-color:#f1dd09;
        color: #191919;
        font-weight:700;
        padding: 15px;
        border-radius: 5px;
        z-index: 1100;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: opacity 0.3s ease-in-out;
        text-align: center;
        min-width: 200px;
      `;
      document.body.appendChild(popup);
    }
  }

  createBlurOverlay() {
    if (!document.getElementById("blur-overlay")) {
      const overlay = document.createElement("div");
      overlay.id = "blur-overlay";
      overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(0px);
        z-index: 1000;
        pointer-events: none;
        opacity: 0;
        transition: backdrop-filter 0.3s ease, opacity 0.3s ease;
      `;
      document.body.appendChild(overlay);
    }
  }

  show(message, duration = 2000) {
    const popup = document.getElementById("cart-popup");
    const blurOverlay = document.getElementById("blur-overlay");

    // Apply blur to main content
    document.body.style.transition = "filter 0.3s ease";
    blurOverlay.style.opacity = "1";
    blurOverlay.style.pointerEvents = "auto";

    // Set the message
    popup.textContent = message;

    // Show the popup
    popup.style.display = "block";
    popup.style.opacity = "1";
    popup.style.zIndex = "1100";

    // Automatically hide the popup after specified duration
    setTimeout(() => {
      // Remove blur
      blurOverlay.style.opacity = "0";
      blurOverlay.style.pointerEvents = "none";

      // Hide popup
      popup.style.opacity = "0";
      setTimeout(() => {
        popup.style.display = "none";
      }, 300);
    }, duration);
  }
}
