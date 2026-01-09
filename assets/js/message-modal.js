document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("messageModal");

  // Check if the modal exists before trying to manipulate it
  if (modal) {
    // Show the modal (for demonstration)
    modal.classList.remove("hidden");

    // Automatically close modal after 9 seconds
    setTimeout(() => {
      closeModal();
    }, 9000);

    function closeModal() {
      modal.classList.add("hidden");
    }
  } else {
    console.log("No message to display");
  }
});
