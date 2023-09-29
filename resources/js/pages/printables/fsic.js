function makeElementEditable(element) {
    element.contentEditable = true;

    element.addEventListener("blur", () => {
        const newText = element.innerText.trim();
    });
}

function removeDraggable(element) {
    element.onmousedown = null;
}

function makeElementDraggable(element) {
    // Variables to hold the position of the draggable element
    var pos1 = 0,
        pos2 = 0,
        pos3 = 0,
        pos4 = 0;

    // Attach mousedown event listener to the element
    element.onmousedown = dragMouseDown;

    // Get the current mouse position
    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();

        // Get the position of the element
        pos3 = e.clientX;
        pos4 = e.clientY;

        document.onmousemove = elementDrag;
        document.onmouseup = stopElementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();

        // Calculate the new position of the element
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;

        // Set the element's new position
        element.style.top = element.offsetTop - pos2 + "px";
        element.style.left = element.offsetLeft - pos1 + "px";
    }

    function stopElementDrag() {
        // Remove the mousemove and mouseup event listeners
        document.onmouseup = null;
        document.onmousemove = null;
    }
}

function handleCheckbox() {
    const checkboxtoggle = selectAll("[checkboxtoggle]");
    checkboxtoggle.forEach((toggle) => {
        toggle.addEventListener("click", (ev) => {
            const checkbox = select(
                `[checkbox="${ev.target.getAttribute("checkboxtoggle")}"]`
            );
            checkbox.classList.toggle("hidden");
        });
    });
}
handleCheckbox();

// AddNote Event handler
addEvent("click", select("#btnAddNote"), () => {
    const btn = select("#btnAddNote");

    if (btn.getAttribute("toggled") == "false") {
        btn.innerHTML = `Done <i class="bi bi-check2 pointer-events-none"></i>`;
        btn.classList.add("btn-success");
        btn.classList.remove("btn-primary");
        btn.setAttribute("toggled", "true");
        select("[printbtn]").disabled = true;

        selectAll("[data-editable]").forEach((elem) => {
            makeElementEditable(elem);
            elem.classList.add("editable");
        });
    } else {
        btn.textContent = "Add Note";
        btn.classList.add("btn-primary");
        btn.classList.remove("btn-success");
        btn.setAttribute("toggled", "false");
        select("[printbtn]").disabled = false;

        selectAll("[data-editable]").forEach((elem) => {
            elem.contentEditable = false;
            elem.classList.remove("editable");
        });

        select("[others=input]").value = select("[others=descrpt]").textContent;
        select("[descrptInp1").value = select("[descrpt1]").textContent;
        select("[descrptInp2").value = select("[descrpt2]").textContent;
    }
});

function handleHighlight() {
    selectAll("[highlightable]").forEach((elem) => {
        addEvent("click", elem, (ev) => {
            ev.target.classList.toggle("highlight");
        });
    });
}
handleHighlight();
