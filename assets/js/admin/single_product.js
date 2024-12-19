// Function to open the modal and display the clicked image
function openModal(image) {
  const modal = document.getElementById("imageModal");
  const modalImage = document.getElementById("fullImage");

  modal.style.display = "flex";
  modalImage.src = image.src; // Set the modal image source to the clicked image source
}

// Function to close the modal
function closeModal() {
  const modal = document.getElementById("imageModal");
  modal.style.display = "none";
}

// Automatically submit the form when images are selected
document.getElementById("imgs").addEventListener("change", function (event) {
  // Access the file input element
  const fileInput = event.target;

  // Ensure files property exists and has files selected
  if (fileInput.files && fileInput.files.length > 0) {
    // Submit the form
    document.getElementById("uploadForm").submit();
  } else {
    console.error("No files selected.");
  }
});
