
import scriptModule from '../js/script.js';
import scriptModal from '../js/modal.js';


window.addEventListener("click",(event)=>{
    const dropdowns = document.querySelectorAll('[data-dropdown-menu]')

    const currentMenu = event.target.parentNode.nextElementSibling || event.target.parentNode.children[1] ;

    const currentMenuClicked = event.target.closest('[data-dropdown-menu]')

    dropdowns.forEach(dropdown => {
        if(dropdown != currentMenu )
        {
            if(dropdown.style.display == "block")
            {
                dropdown.style.display = "none";
            }
        }
});
})


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {

    const modals = document.querySelectorAll('[data-modal]')
  
    const modalContent = event.target.closest('.modal-content')
  
  
    //If clicked inside the modal content dont close
    if(modalContent !== null)
      return;
  
    modals.forEach(modal => {
      if (modalContent === null && event.target.style.display == "block") {
        modal.style.display = "none";
      }
    });
  }



window.toggleShow = scriptModule.toggleShow;
window.openModal = scriptModal.openModal;
window.closeModal = scriptModal.openModal;