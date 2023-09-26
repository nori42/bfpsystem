export const toggleDisplay = (elem) => {
    elem.classList.toggle("d-none");
};

window.addEvent = (event, elem, fnct) => {
    elem.addEventListener(event, fnct);
};

window.select = (selector) => {
    return document.querySelector([selector]);
};

window.selectAll = (selector) => {
    return document.querySelectorAll([selector]);
};
