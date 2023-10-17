addEvent("click", select("#submitFile"), (event) => {
    document.querySelector("[spinner]").classList.remove("d-none");
    document.querySelector("[modal-content]").classList.add("d-none");
    // Submit the file
    select("#uploadForm").submit();
});

const disapprovalBtnUpload = selectAll("[btnUplDisapp");
const checklistBtnUpload = selectAll("[btnUplChecklist");

disapprovalBtnUpload.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        select("#evaluationId").value = e.target.getAttribute("evaluationId");
        select("#uploadForm").setAttribute(
            "action",
            "/fsec/upload/disapproval"
        );
    });
});

checklistBtnUpload.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        select("#evaluationId").value = e.target.getAttribute("evaluationId");
        select("#uploadForm").setAttribute("action", "/fsec/upload/checklist");
    });
});

fileUpload.addEventListener("change", function () {
    const fileUpload = document.querySelector("#fileUpload");
    const files = fileUpload.files;

    document.querySelector("#submitFile").classList.remove("d-none");

    if (files != null) {
        document.querySelector(".filelist-container").style.display = "block";
        document.querySelector("#submitFile").style.display = "block";

        const filelist = document.querySelector(".filelist");
        filelist.innerHTML = "";

        Array.from(files).forEach((file) => {
            const li = document.createElement("li");
            li.textContent = file.name;
            filelist.appendChild(li);
        });
    }
});
