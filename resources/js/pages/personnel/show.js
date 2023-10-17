addEvent("click", select("#btnChangeDesig"), (e) => {
    select("[textDesig]").classList.add("d-none");
    select("#designationForm").classList.remove("d-none");
    e.target.classList.add("d-none");
    select("#btnDesigConfirm").classList.remove("d-none");
});

addEvent("click", select("#btnUpdateDesig"), () => {
    select("#designationForm").submit();
});

addEvent("click", select("#btnCancelDesig"), () => {
    select("[textDesig]").classList.remove("d-none");
    select("#designationForm").classList.add("d-none");
    select("#btnChangeDesig").classList.remove("d-none");
    select("#btnDesigConfirm").classList.add("d-none");
});
