const dateFrom = document.querySelector(["#dateFrom"]);
const dateTo = document.querySelector(["#dateTo"]);

const loadingMssg = document.querySelector(["#loadingMssg"]);
const activtiyContent = document.querySelector(["#activityContent"]);

// document.querySelector("#btnViewActivity").addEventListener("click", () => {
//     if (dateFrom.value != "" && dateTo.value != "") {
//         loadingMssg.classList.remove("d-none");
//         activtiyContent.classList.add("d-none");
//     }
// });

// dateFrom.addEventListener("change", () => {
//     dateTo.value = dateFrom.value;
// });

// add events to checkbox
const checkboxquery = selectAll("[checkboxquery]");
if (checkboxquery.length > 0) {
    checkboxquery.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            select("#dateFrom").value = select("#dateFromCurrent").value;
            select("#dateTo").value = select("#dateToCurrent").value;
            select("#filter").submit();
        });
    });
}
