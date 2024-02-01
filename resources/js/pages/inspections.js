// PUT THE INSPECTIONS PAGE SCRIPT HERE

selectAll("select[select-value]").forEach((el) => {
    el.value = el.getAttribute("select-value");
});

const registrationStatus = document.querySelector("#registrationStatus");
const natureOfPayment = document.querySelector("#natureOfPayment");
const issuedFor = document.querySelector("#issued_For");

const issuedForOpt = {
    NEW: ["THE PURPOSE OF SECURING BUSINESS PERMIT", "NEW BUSINESS PERMIT"],
    RENEWAL: ["RENEWAL OF BUSINESS PERMIT"],
    ACCREDITATION: [
        "RENEWAL OF BUSINESS PERMIT/TESDA ACCREDITATION",
        "RENEWAL OF BUSINESS PERMIT/DOT ACCREDITATION",
    ],
    OTHER: [
        "RENEWAL OF BUSINESS PERMIT/TESDA ACCREDITATION",
        "RENEWAL OF BUSINESS PERMIT/DOT ACCREDITATION",
        "ANNUAL INSPECTION OF PEZA CERTIFICATE",
    ],
    OCCUPANCY: ["PEZA OCCUPANCY PERMIT", "OCCUPANCY PERMIT"],
};

function appendOption(selectElem, option) {
    const optionEl = document.createElement("option");
    optionEl.setAttribute("value", option);
    optionEl.innerHTML = option;
    selectElem.appendChild(optionEl);
}

registrationStatus.addEventListener("change", () => {
    const btnPrintOccupancy = document.querySelector("#btnPrintOccupancy");

    issuedFor.innerHTML = "";
    switch (registrationStatus.value) {
        case "NEW":
            {
                natureOfPayment.value =
                    "FSIF(NBP) - FIRE SAFETY INSPECTION FEE - BFP-06";
                issuedForOpt.NEW.forEach((option) => {
                    appendOption(issuedFor, option);
                });
            }
            break;
        case "RENEWAL":
            {
                natureOfPayment.value =
                    "FSIF(RBP) - FIRE SAFETY INSPECTION FEE - BFP-06";
                issuedForOpt.RENEWAL.forEach((option) => {
                    appendOption(issuedFor, option);
                });
            }
            break;
        case "OCCUPANCY":
            {
                natureOfPayment.value =
                    "FSIF(OCC) - FIRE SAFETY INSPECTION FEE - BFP-06";
                issuedForOpt.OCCUPANCY.forEach((option) => {
                    appendOption(issuedFor, option);
                });
            }
            break;
        case "ACCREDITATION":
            {
                natureOfPayment.value =
                    "FSIF(ACCREDITATION) - FIRE SAFETY INSPECTION FEE - BFP-06";
                issuedForOpt.ACCREDITATION.forEach((option) => {
                    appendOption(issuedFor, option);
                });
            }
            break;
        case "OTHER":
            {
                issuedForOpt.OTHER.forEach((option) => {
                    appendOption(issuedFor, option);
                });
            }
            break;
    }

    if (registrationStatus.value == "OCCUPANCY") {
        btnPrintOccupancy.classList.remove("d-none");
    } else {
        btnPrintOccupancy.classList.add("d-none");
    }
});
