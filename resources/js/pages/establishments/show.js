const deleteContent = select("#deleteContent");
const deleteSpinner = select("#deleteSpinner");

addEvent("click", select("#deleteBtn"), () => {
    deleteContent.classList.add("d-none");
    deleteSpinner.classList.remove("d-none");
});
