import { toggleDisplay } from "../../globalVar";
import { populateSelectOptions } from "../../selectoptions/populateselect";

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

// Next Button
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
        toggleDisplay(select("#establishmentDetails"));
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

// From Name to Estab
addEvent("click", btns.back, () => {
    toggleDisplay(select("#ownerDetails"));
    toggleDisplay(select("#establishmentDetails"));
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

// From Estab to Submit
addEvent("click", btns.save, (ev) => {
    if (validateForm(select("#establishmentDetails"))) {
        toggleDisplay(select("#establishmentDetails"));
        selectAll("[step-icon]")[1].classList.replace(
            "bi-circle",
            "bi-check-circle-fill"
        );
        toggleDisplay(select("#loadingMssg"));
        toggleDisplay(select("#btnsForm"));
    }
});

addEvent("change", select("#isCompanyName"), (ev) => {
    if (ev.target.checked) {
        select("#establishmentName").value = select("#corporateName").value;
        select("#establishmentName").readOnly = true;

        console.log();
    } else {
        select("#establishmentName").value = "";
        select("#establishmentName").readOnly = false;
    }
});

// Initialize options select
populateSelectOptions();

window.addEventListener("keypress", (e) => {
    if (e.key == "Enter") {
        const inputs = document.querySelectorAll(".form-control");
        console.log(inputs);
    }
});
