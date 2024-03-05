let selectedText;

document.addEventListener("click", (event) => {
    elem = event.target;
    const isElemEditable = elem.hasAttribute("data-text-editable");
    const textTools = document.querySelector("[data-text-tools]");

    if (isElemEditable) {
        const fontSize = document.querySelector("#fontSize");
        fontSize.selectedIndex = 0;

        selectedText = event.target;
        textTools.classList.remove("d-none");
    } else {
        if (!elem.closest("[data-text-tools]"))
            textTools.classList.add("d-none");
    }
});

function fontSizeChange() {
    const fontSize = document.querySelector("#fontSize");
    if (selectedText != null || selectedText != undefined) {
        selectedText.style.fontSize = fontSize.selectedOptions[0].value + "pt";
    }
}
