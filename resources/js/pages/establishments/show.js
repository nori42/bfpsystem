const deleteContent = select("#deleteContent");
const deleteSpinner = select("#deleteSpinner");

addEvent("click", select("#deleteBtn"), () => {
    deleteContent.classList.add("d-none");
    deleteSpinner.classList.remove("d-none");
});

addEvent("click", select("#btnInspAttachment"), () => {
    const btn = select("#btnInspAttachment");

    if (btn.getAttribute("active") != "true") {
        select("#fsicAttachment").classList.toggle("d-none");
        select("#firedrillAttachment").classList.toggle("d-none");
        btn.classList.add("btn-primary");
        btn.classList.remove("btn-outline-primary");

        select("#btnFiredrillAttachment").classList.add("btn-outline-primary");
        select("#btnFiredrillAttachment").classList.remove("btn-primary");

        btn.setAttribute("active", "true");
        select("#btnFiredrillAttachment").setAttribute("active", "false");
    }
});

addEvent("click", select("#btnFiredrillAttachment"), () => {
    const btn = select("#btnFiredrillAttachment");

    if (btn.getAttribute("active") != "true") {
        select("#firedrillAttachment").classList.toggle("d-none");
        select("#fsicAttachment").classList.toggle("d-none");
        btn.classList.add("btn-primary");
        btn.classList.remove("btn-outline-primary");

        select("#btnInspAttachment").classList.add("btn-outline-primary");
        select("#btnInspAttachment").classList.remove("btn-primary");

        btn.setAttribute("active", "true");
        select("#btnInspAttachment").setAttribute("active", "false");
    }
});
