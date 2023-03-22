
// Use this for showing modal
const openModal = (modalTarget) => {

    modal = document.getElementById(modalTarget);
    modal.style.display = "block"
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  
    modals = document.querySelectorAll('[data-modal="modal"]')

    modals.forEach(modal => {
      if (event.target.style.display == "block") {
        modal.style.display = "none";
      }
    });
}

