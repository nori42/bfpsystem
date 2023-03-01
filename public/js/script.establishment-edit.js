var fields = [...document.getElementsByClassName("info")]
var isEditable = document.getElementById("isEditable")
var saveBtn = document.getElementById("saveBtn")
var editBtn = document.getElementById("editBtn")
var updateForm = document.getElementById("updateForm")

editBtn.addEventListener("click", function(){
    if(isEditable.value != "false"){
        isEditable.value = false
        saveBtn.style.display = "none"
        this.textContent = "Edit Details"
        this.classList.remove("bg-danger")
        this.classList.remove("text-white")
        this.classList.remove("editable")
        fields.forEach(e => {
            e.setAttribute("readonly", "readonly")
            e.classList.remove("editable")
        });
    }else{
        this.textContent = "Cancel"
        saveBtn.style.display = "block"
        this.classList += " bg-danger text-white"
        isEditable.value = true
        fields.forEach(e => {
            e.removeAttribute("readonly")
            e.classList += " editable"
        });
    }

})


saveBtn.addEventListener("click", function(){
    updateForm.submit()

    this.style.display = "none"
    editBtn.classList.remove("bg-danger")
    editBtn.classList.remove("text-white")
    editBtn.textContent = "Edit Details"

    fields.forEach(e => {
        e.setAttribute("readonly", "readonly")
        e.classList.remove("editable")
    });

    isEditable.value = false
})