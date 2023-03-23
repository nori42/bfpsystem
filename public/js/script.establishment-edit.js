const saveBtn = document.getElementById("btnSave")
const editBtn = document.getElementById("btnEdit")
const cancelBtn = document.getElementById("btnCancel")
const selects = document.querySelectorAll('[data-select-edit]')
const inputs = document.querySelectorAll('[data-input-edit]')
const inputsValues = [];
const selectValues = [];

inputs.forEach(input => {
    inputsValues.push(input.value)
});
    
selects.forEach((select) => {
    selectValues.push(select.value)
});

console.log(selectValues)

editBtn.addEventListener("click",() =>{
    editButtons = document.querySelectorAll('[data-btn-edit]')
    editBtn.style.display = "none"

    editButtons.forEach(btn => {
        btn.classList.remove("d-none")
    });

    inputs.forEach(input => {
        input.readOnly = false
        input.classList.add('editable')
    });

    selects.forEach(select => {
        select.disabled = false
        select.classList.add('editable')
    });
    
})

cancelBtn.addEventListener("click",()=>{
    editBtn.style.display = "block"
    editButtons = document.querySelectorAll('[data-btn-edit]')
    editButtons.forEach(btn => {
        btn.classList.add("d-none")
    });


    inputs.forEach(input => {
        input.readOnly = true
        input.classList.remove('editable')
    });

    selects.forEach(select => {
        select.disabled = true
        select.classList.remove('editable')
    });

    inputs.forEach((input,index) => {
        input.value = inputsValues[index];
    });

    selects.forEach((select,index) => {
        select.value = selectValues[index];
    });
})

// editBtn.addEventListener("click", function(){
//     if(isEditable.value != "false"){
//         isEditable.value = false
//         saveBtn.style.display = "none"
//         this.innerHTML = 'Edit Details'
//         this.classList.remove("bg-danger")
//         this.classList.remove("text-white")
//         this.classList.remove("editable")
//         fields.forEach(e => {
            
//             if(e.tagName == 'SELECT')
//             {
//              e.setAttribute("disabled", "disabled")
//             }
//             else
//             {
//             e.setAttribute("readonly", "readonly")   
//             }
//             e.classList.remove("editable")
            
//         });
//     }else{
//         this.textContent = "Cancel"
//         saveBtn.style.display = "block"
//         this.classList += " bg-danger text-white"
//         isEditable.value = true
//         fields.forEach(e => {
//             if(e.tagName = 'SELECT')
//             {
//              e.removeAttribute("disabled")
//             }
//             else
//             {
//             e.removeAttribute("readonly")
//             }
//             e.classList += " editable"
//         });
//     }

// })


// saveBtn.addEventListener("click", function(){
//     updateForm.submit()

//     this.style.display = "none"
//     editBtn.classList.remove("bg-danger")
//     editBtn.classList.remove("text-white")
//     editBtn.textContent = "Edit Details"

//     fields.forEach(e => {
//         e.setAttribute("readonly", "readonly")
//         e.classList.remove("editable")
//     });

//     isEditable.value = false
// })