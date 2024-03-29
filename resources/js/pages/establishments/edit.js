import { populateSelectOptions } from "../../selectoptions/populateselect";
import occupancies from "../../selectoptions/occupancy";

// Initialize options select
populateSelectOptions();

//Initiate select value
selectAll("select[select-value]").forEach((select) => {
    select.value = select.getAttribute("select-value");
});

// subtypes
const options = occupancies[select("#occupancy").value].subtype;
select("#subType").innerHTML = "";

// Append Placeholder first
const optionEl = document.createElement("option");
optionEl.setAttribute("value", "");
optionEl.innerHTML = "--Select Sub Type--";
select("#subType").appendChild(optionEl);

options.forEach((option) => {
    const optionEl = document.createElement("option");
    optionEl.setAttribute("value", option);
    optionEl.innerHTML = option;
    select("#subType").appendChild(optionEl);
});

select("#subType").value = select("#subType").getAttribute("select-value");
