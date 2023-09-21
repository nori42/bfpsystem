import scriptModule from "../js/script.js";
import scriptModal from "../js/modal.js";
import { closeDropdownOnClick, addEventDropdown } from "../js/dropdown.js";

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    // Modal variable
    const modals = document.querySelectorAll("[data-modal]");
    const modalContent = event.target.closest(".modal-content");

    //Dropdown CloseEvent
    closeDropdownOnClick(event);

    //If clicked inside the modal content dont close
    if (modalContent !== null) return;

    //close opened modal
    modals.forEach((modal) => {
        if (modalContent === null && event.target.style.display == "block") {
            modal.style.display = "none";
        }
    });
};

// Prevent submitting form when enter is press except in the search page
window.addEventListener("keypress", (e) => {
    const search = document.querySelector("#search")
        ? document.querySelector("#search")
        : null;
    if (e.key == "Enter" && search == null) e.preventDefault();
});

//dropdown btn event
addEventDropdown(document.querySelectorAll("[dropdown]"));

window.toggleShow = scriptModule.toggleShow;
window.openModal = scriptModal.openModal;
window.closeModal = scriptModal.closeModal;

window.addEvent = (event, elem, fnct) => {
    elem.addEventListener(event, fnct);
};

window.select = (selector) => {
    return document.querySelector([selector]);
};

window.selectAll = (selector) => {
    return document.querySelectorAll([selector]);
};
