
// Use this for showing modal
const openModal = (modalTarget) => {

  const modal = document.getElementById(modalTarget);
    modal.style.display = "block"
}

const closeModal = (modalTarget) => {

  const modal = document.getElementById(modalTarget);
  modal.style.display = "none"
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {

    modals = document.querySelectorAll('[data-modal]')

    modalContent = event.target.closest('.modal-content')


    //If clicked inside the modal content dont close
    if(modalContent !== null)
      return;

    modals.forEach(modal => {
      if (modalContent === null && event.target.style.display == "block") {
        modal.style.display = "none";
      }
    });
}

