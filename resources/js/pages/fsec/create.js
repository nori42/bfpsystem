import { toggleDisplay } from "../../globalVar";
import { populateSelectOptions } from "../../selectoptions/populateselect";
import occupancies from "../../selectoptions/occupancy";

selectAll("select[select-value]").forEach((select) => {
    select.value = select.getAttribute("select-value");
});

const btns = {
    cancel: select("#cancelBtn"),
    back: select("#backBtn"),
    next: select("#nextBtn"),
    save: select("#saveBtn"),
};

function toggleBtnDisplay() {
    toggleDisplay(btns.next);
    toggleDisplay(btns.cancel);
    toggleDisplay(btns.back);
    toggleDisplay(btns.save);
}

function validateForm(form) {
    const requiredInputs = Array.from(
        form.querySelectorAll("input[required],select[required]")
    );
    const invalidInput = requiredInputs.filter((input) => input.value == "");

    if (invalidInput.length == 0) return true;
    else return false;
}

// Element Events

addEvent("click", select("#cancelBtn"), () => {
    history.back();
});

addEvent("click", btns.next, () => {
    const inputs = Array.from(
        select("#ownerDetails").querySelectorAll("input")
    );

    const requiredInputId = ["lastName", "firstName", "corporateName"];

    const requiredInputs = inputs.filter((input) => {
        return requiredInputId.includes(input.id);
    });

    // If either name or corporate is filled
    let isValid =
        (requiredInputs[0].value != "" && requiredInputs[1].value != "") ||
        requiredInputs[2].value != "";

    // Change the validation mssg to default
    select("#validateMssgOwner").textContent =
        "Fill in the name or corporate field";

    // if last name is filled and corporate is filled make it invalid
    if (
        requiredInputs[2].value != "" &&
        requiredInputs[0].value != "" &&
        requiredInputs[1].value == ""
    ) {
        isValid = false;
        select("#validateMssgOwner").textContent =
            "Fill in the first name field";
    }

    if (isValid) {
        toggleDisplay(select("#ownerDetails"));
        toggleDisplay(select("#applicantDetails"));
        toggleBtnDisplay();
        selectAll("[step-icon]")[0].classList.replace(
            "bi-circle",
            "bi-check-circle-fill"
        );
        selectAll("[step]")[1].classList.add("current-step");
    } else {
        select("#validateMssgOwner").classList.remove("d-none");
    }
});

addEvent("click", btns.back, () => {
    toggleDisplay(select("#ownerDetails"));
    toggleDisplay(select("#applicantDetails"));
    toggleBtnDisplay();
    selectAll("[step-icon]")[0].classList.replace(
        "bi-check-circle-fill",
        "bi-circle"
    );
    selectAll("[step]")[1].classList.remove("current-step");

    select("#validateMssgOwner").classList.add("d-none");

    // Change the validation mssg to default
    select("#validateMssgOwner").textContent =
        "Fill in the name or corporate field";
});

addEvent("click", btns.save, (ev) => {
    if (validateForm(select("#applicantDetails"))) {
        toggleDisplay(select("#applicantDetails"));
        selectAll("[step-icon]")[1].classList.replace(
            "bi-circle",
            "bi-check-circle-fill"
        );
        toggleDisplay(select("#loadingMssg"));
        toggleDisplay(select("#btnsForm"));
    }
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

// Initialize options select
populateSelectOptions();
