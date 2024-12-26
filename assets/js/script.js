// Navbar actions
function toggleMenu() {
  const navbar = document.getElementById("navbar");
  const overlay = document.getElementById("overlay");

  navbar.classList.toggle("active");
  overlay.classList.toggle("active");
}

// Navbar dropdown
const dropdown = document.getElementById("dropdown");

dropdown.addEventListener("click", (event) => {
  event.stopPropagation();
  dropdown.classList.toggle("active");
});

document.addEventListener("click", () => {
  dropdown.classList.remove("active");
});
