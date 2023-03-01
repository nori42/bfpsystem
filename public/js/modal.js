// Get the modal
var modal;

// // Get the button that opens the modal
// var btn = document.getElementById("myBtn");

const openModal = (modalTarget) => {

    console.log(modalTarget)
    modal = document.getElementById(modalTarget);
    modal.style.display = "block"
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}