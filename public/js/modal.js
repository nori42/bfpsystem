// Get the modal
var modal = document.getElementById("Modalowner");

// Get the button that opens the modal
var btn = document.getElementById("Mbutton");

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