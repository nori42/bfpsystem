
import scriptModule from '../js/script.js';
import scriptModal from '../js/modal.js';

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    // Modal variable
    const modals = document.querySelectorAll('[data-modal]')
    const modalContent = event.target.closest('.modal-content')

    //Dropdown variable
    const dropdowns = document.querySelectorAll('[dropdown-menu]')
    let currentMenu = event.target.closest('[dropdown-menu]');

    

    try{
      currentMenu = event.target.closest('.btn').nextElementSibling
       console.log(currentMenu)
    }
    catch{}

    // dropdown menu script 
    dropdowns.forEach(dropdown => {
      if(dropdown != currentMenu)
        {
          dropdown.style.display = "none";
          // dropdown.style.display = "none";
          // if(dropdown.style.display == "block")
          // {
          //     dropdown.style.display = "none";
          // }
      }
    });

    //If clicked inside the modal content dont close
    if(modalContent !== null)
      return;
      
    //close opened modal
    modals.forEach(modal => {
      if (modalContent === null && event.target.style.display == "block") {
        modal.style.display = "none";
      }
    });
  }

  // Prevent submitting form when enter is press except in the search page
  window.addEventListener('keypress',(e)=>{
    const search = document.querySelector('#search') ? document.querySelector('#search') : null;
      if(e.key == "Enter" && search == null)
        e.preventDefault();
  })

window.toggleShow = scriptModule.toggleShow;
window.openModal = scriptModal.openModal;
window.closeModal = scriptModal.closeModal;