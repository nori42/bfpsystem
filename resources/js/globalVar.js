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

// Disable all server action buttons if clicked
if (document.querySelector("[data-server-action]") != null) {
    const btn = document.querySelector("[data-server-action]");
    btn.addEventListener("click", () => {
        if (btn.tagName == "A") {
            btn.textContent = "Processing...";
            btn.style.pointerEvents = "none";
            btn.classList.add("d-none");
            return;
        }

        if (btn.closest("[action]").checkValidity()) {
            btn.textContent = "Processing...";
            btn.style.pointerEvents = "none";
        }
    });
}
