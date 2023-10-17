addEvent("click", select("#deleteBtn"), () => {
    select("#modalDeleteCont").classList.add("d-none");
    select("#deleteSpinner").classList.remove("d-none");
});

if (selectAll("[btnKey]")[0]) {
    selectAll("[btnKey]").forEach((btn) => {
        addEvent("click", btn, (e) => {
            select("#deletionId").value = e.target.getAttribute("btnKey");
        });
    });
}
