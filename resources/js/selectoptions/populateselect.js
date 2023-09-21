import occupancies from "../selectoptions/occupancy";
import substation from "../selectoptions/substations";
import buildingType from "../selectoptions/buldingstructure";
import barangay from "../selectoptions/barangays";

export const populateEstabSelectOptions = () => {
    const selects = selectAll("select");
    const occupancy = Object.keys(occupancies);

    // Add new array Options here
    const selectOptions = {
        occupancy,
        substation,
        buildingType,
        barangay,
    };

    selects.forEach((select) => {
        const options = selectOptions[select.id];

        //Move to next select if options is null
        if (options == undefined) return;

        options.forEach((option) => {
            const optionEl = document.createElement("option");
            optionEl.setAttribute("value", option);
            optionEl.innerHTML = option;
            select.appendChild(optionEl);
        });
    });

    addEvent("change", select("#occupancy"), () => {
        const options = occupancies[select("#occupancy").value].subtype;
        select("#subType").innerHTML = "";
        options.forEach((option) => {
            const optionEl = document.createElement("option");
            optionEl.setAttribute("value", option);
            optionEl.innerHTML = option;
            select("#subType").appendChild(optionEl);
        });

        select("#subType").selectedIndex = 0;
    });
};
