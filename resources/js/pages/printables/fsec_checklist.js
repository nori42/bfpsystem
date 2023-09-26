function addCheckmark(event) {
    // Do Nothing if the button is clicked
    if (event.target.id == "btnAddCheck" || event.target.id == "btnCancel")
        return;

    if (event.target.hasAttribute("checkmark")) {
        // Remove the clicked checkmark
        event.target.remove();
        return;
    }

    const printables = document.querySelectorAll(".printablePage");

    // Create a new <span> element
    var checkmark = document.createElement("span");

    // Set the inner HTML to display the checkmark symbol (✓)
    checkmark.innerHTML = "&#10003;";

    // Add CSS styles to the checkmark
    checkmark.style.fontSize = "32px";
    checkmark.style.position = "absolute";
    checkmark.style.cursor = "cursor";
    checkmark.style.left = event.offsetX - 6 + "px";
    checkmark.style.top = event.offsetY - 10 + "px";
    checkmark.setAttribute("checkmark", "");
    // Append the checkmark to the body of the document

    try {
        // Get the target page to add the checkmark
        const targetPage = event.target.parentElement.attributes.page.value;

        printables[targetPage - 1].appendChild(checkmark);
    } catch (e) {}
}

function addCheckmarkEvent(event) {
    const pages = document.querySelectorAll(".printablePage");

    if (event.target.innerText === "Toggle Checkmark") {
        document.addEventListener("click", addCheckmark);

        // Change Cursor when hover on page
        pages.forEach((item) => {
            item.style.cursor = "cell";
        });
        event.target.innerText = "Done";
        event.target.classList.add("btn-success");
        event.target.classList.remove("btn-primary");
        select("[printbtn]").disabled = true;
    } else {
        document.removeEventListener("click", addCheckmark);
        // Change Cursor when hover on page
        pages.forEach((item) => {
            item.style.cursor = "default";
        });
        event.target.innerText = "Toggle Checkmark";
        event.target.classList.remove("btn-success");
        event.target.classList.add("btn-primary");
        select("[printbtn]").disabled = false;
    }
}

function cancel() {
    document.removeEventListener("click", addCheckmark);
    document.querySelector("#body").style.cursor = "default";
    console.log("Remove Event Listener");
}

addEvent("click", select("#btnCheckmarkAdd"), (ev) => addCheckmarkEvent(ev));
