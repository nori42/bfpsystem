
// Use this for showing modal
const openModal = (modalTarget) => {

    modal = document.getElementById(modalTarget);
    modal.style.display = "block"
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// Use this for inspectionPayment
const openInspPayment = (modalTarget, data) => {

  modal = document.getElementById(modalTarget);
  modal.style.display = "block"

  

}