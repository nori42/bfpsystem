import html2canvas from "html2canvas";

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

function addNumber(event) {
    saveNumber();
    // Do Nothing if the button is clicked
    if (event.target.id == "btnAddNumber" || event.target.id == "btnCancel")
        return;

    if (event.target.hasAttribute("number")) {
        // Remove the clicked checkmark
        event.target.remove();
        return;
    }

    const printables = document.querySelectorAll(".printablePage");

    // Create a new <span> element
    var number = document.createElement("span");

    // Set the inner HTML to display the checkmark symbol (0)
    number.innerHTML = "";
    number.contentEditable = true;

    // Add CSS styles to the checkmark
    number.style.fontSize = "10px";
    number.style.position = "absolute";
    number.style.cursor = "cursor";
    number.style.left = event.offsetX - 6 + "px";
    number.style.top = event.offsetY - 10 + "px";
    number.setAttribute("number", "");
    // Append the checkmark to the body of the document

    try {
        // Get the target page to add the checkmark
        const targetPage = event.target.parentElement.attributes.page.value;

        printables[targetPage - 1].appendChild(number);
        number.focus();
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
        select("#btnNumberAdd").disabled = true;
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
        select("#btnNumberAdd").disabled = false;
    }
}

function addNumberEvent(event) {
    const pages = document.querySelectorAll(".printablePage");

    if (event.target.innerText === "Toggle Number") {
        document.addEventListener("click", addNumber);

        // Change Cursor when hover on page
        pages.forEach((item) => {
            item.style.cursor = "cell";
        });
        event.target.innerText = "Done";
        event.target.classList.add("btn-success");
        event.target.classList.remove("btn-primary");
        select("[printbtn]").disabled = true;
        select("#btnCheckmarkAdd").disabled = true;
    } else {
        document.removeEventListener("click", addNumber);
        saveNumber();
        // Change Cursor when hover on page
        pages.forEach((item) => {
            item.style.cursor = "default";
        });
        event.target.innerText = "Toggle Number";
        event.target.classList.remove("btn-success");
        event.target.classList.add("btn-primary");
        select("[printbtn]").disabled = false;
        select("#btnCheckmarkAdd").disabled = false;
    }
}

function cancel() {
    document.removeEventListener("click", addCheckmark);
    document.removeEventListener("click", addNumber);
    document.querySelector("#body").style.cursor = "default";
    console.log("Remove Event Listener");
}

addEvent("click", select("#btnCheckmarkAdd"), (ev) => addCheckmarkEvent(ev));
addEvent("click", select("#btnNumberAdd"), (ev) => addNumberEvent(ev));

function saveNumber() {
    const numbers = selectAll("[number]");
    numbers.forEach((number) => {
        number.blur();
        number.contentEditable = false;
    });
}
