const fsecInput = document.querySelector("#fsec");
const fsecNoInput = document.querySelector("#fsec_no");

const printBtn = document.querySelector("[printbtn]");
printBtn.setAttribute("disabled", "");

fsecInput.addEventListener("input", () => {
    if (fsecInput.value.length > 0) {
        printBtn.removeAttribute("disabled");
        console.log(fsecInput.value.length);
        fsecNoInput.value = fsecInput.value;
    } else {
        printBtn.setAttribute("disabled", "");
    }
});
