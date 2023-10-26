import exportTableToXLSX from "../util/exportToXLSX";
import addTableSort from "../util/tableSort";

if (select("#reportsTable") != null) {
    const filename = select("#reportsTable").getAttribute("tablename");
    //exportBtn Event
    addEvent("click", select("#btnExport"), () =>
        exportTableToXLSX("reportsTable", filename)
    );
    addTableSort(select("#reportsTable"));
}

// addLink events to route to its corresponding route
const reportLinks = selectAll("[route]");
reportLinks.forEach((link) => {
    link.addEventListener("click", () => {
        window.location.href = `${link.getAttribute("route")}`;
    });
});

//btnViewFilter
addEvent("click", select("#btnViewFilter"), () => {
    if (select("#dateFrom").value && select("#dateFrom").value) {
        select("#reportContent").classList.add("d-none");
        select("#loadingMssg").classList.remove("d-none");
    }
});

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
