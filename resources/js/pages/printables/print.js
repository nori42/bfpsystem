window.select = (selector) => {
    return document.querySelector([selector]);
};

window.selectAll = (selector) => {
    return document.querySelectorAll([selector]);
};

// Remove Element if print preview

if (select("#isPreview")) {
    if (select("#isPreview").checked) {
        select("[printBtn]").remove();
    }

    window.addEventListener("beforeprint", (event) => {
        if (select("#isPreview").checked) {
            const printPage = document.querySelectorAll(".printablePage");
            printPage.forEach((print) => {
                print.innerHTML = `<h1 class="text-center">Print is not allowed. Reload the page to re-view print</h1>`;
                print.style.background = "none";
            });
        }
    });
}
if (select("[printbtn]") != null) {
    select("[printbtn]").addEventListener("click", () => {
        print();
        select("[btnback").remove();
        selectAll("[btndone]").forEach((btn) => {
            btn.classList.remove("d-none");
        });
        select("[printtools").remove();
    });
}

export const handleMove = (btn) => {
    moveables = document.querySelectorAll('[data-draggable="true"]');

    if (btn.innerText == "Move") {
        moveables.forEach((ele) => {
            makeElementDraggable(ele);
            ele.classList.add("moveable");
        });
        document.getElementById("printBtn").disabled = true;
        document.getElementById("printBtn").classList.add("disable");

        btn.innerText = "Save";
        btn.style.backgroundColor = "green";
        btn.style.color = "white";
    } else {
        moveables.forEach((ele) => {
            removeDraggable(ele);
            ele.classList.remove("moveable");
        });

        document.getElementById("printBtn").disabled = false;
        document.getElementById("printBtn").classList.remove("disable");

        btn.innerText = "Move";
        btn.style.backgroundColor = "";
        btn.style.color = "";
    }
};

export const handleEdit = () => {
    editables = document.querySelectorAll('[data-editable="true"]');
    btnMoreInfo = document.querySelector("#btnMoreInfo");

    if (btn.innerText == "Add Note") {
        editables.forEach((ele) => {
            makeElementEditable(ele);
            ele.classList.add("editable");
        });

        document.getElementById("printBtn").disabled = true;
        document.getElementById("printBtn").classList.add("disable");

        btn.innerText = "Save";
        btn.style.backgroundColor = "green";
        btn.style.color = "white";
    } else {
        editables.forEach((ele) => {
            saveEdit(ele);
            ele.classList.remove("editable");
        });

        document.getElementById("printBtn").disabled = false;
        document.getElementById("printBtn").classList.remove("disable");

        btn.innerText = "Add Note";
        btn.style.backgroundColor = "";
        btn.style.color = "";
    }
};
