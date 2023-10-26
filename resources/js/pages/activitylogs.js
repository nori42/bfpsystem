const dateFrom = document.querySelector(["#dateFrom"]);
const dateTo = document.querySelector(["#dateTo"]);
const activityIn = document.querySelector(["#activityIn"]);

const loadingMssg = document.querySelector(["#loadingMssg"]);
const activtiyContent = document.querySelector(["#activityContent"]);

document.querySelector("#btnViewFilter").addEventListener("click", () => {
    if (dateFrom.value != "" && dateTo.value != "") {
        select("#activityContent").classList.toggle("d-none");
        select("#loadingMssg").classList.toggle("d-none");
    }
});

// add events to checkbox
const checkboxquery = selectAll("[checkboxquery]");
if (checkboxquery.length > 0) {
    checkboxquery.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            select("#dateFrom").value = select("#dateFromCurrent").value;
            select("#dateTo").value = select("#dateToCurrent").value;

            select("#activityContent").classList.toggle("d-none");
            select("#loadingMssg").classList.toggle("d-none");
            select("#filter").submit();
        });
    });
}
