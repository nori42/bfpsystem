// const CANCEL_BTN = document.getElementById("cancelBtn")
// const NEXT_BTN = document.getElementById("nextBtn")
// const SAVE_BTN = document.getElementById("saveBtn")
// const PAGE_INDICATOR = document.getElementById("steps-title").children

const btnCancel = document.getElementById("cancelBtn")
const btnBack = document.getElementById("backBtn")
const btnNext = document.getElementById("nextBtn")
const btnSave = document.getElementById("saveBtn")
const pageIndicator = document.querySelectorAll(".indicator")
const validateMssg1 = document.querySelector('#validateMssg1')

const ownerStep = document.querySelector('[data-step="owner"]');
const establishmentStep = document.querySelector('[data-step="establishment"]');
const ownerInputs = document.querySelectorAll('[data-owner-input]')
const establishmentInputs = document.querySelectorAll('[data-establishment-input]')

console.log(pageIndicator)

let currentIndex = 1;

turnOffAutocompeteInput();

function nextStep(){
    if(validateInputs(ownerInputs))
    {   
        currentIndex++;
        viewForm();
        
    }
    validateMssg1.style.display = 'block'
}

function prevStep(){
    currentIndex--;
    validateMssg1.style.display = 'none'
    viewForm();
}

function cancel(){
    location.href = "/establishments"
}

function viewForm(){
    if(currentIndex == 2)
    {
        establishmentStep.style.display = 'block';
        ownerStep.style.display = 'none';
        btnBack.style.display = 'block';
        btnSave.style.display = 'block'
        btnCancel.style.display = 'none';
        btnNext.style.display = 'none';
        pageIndicator[0].classList.add('finished-page')
        pageIndicator[0].classList.remove('current-page')
        pageIndicator[1].classList.add('current-page')
    }

    if(currentIndex == 1)
    {
        establishmentStep.style.display = 'none';
        ownerStep.style.display = 'block';
        btnCancel.style.display = 'block';
        btnNext.style.display = 'block';
        btnBack.style.display = 'none';
        btnSave.style.display = 'none'

        pageIndicator[0].classList.add('current-page')
        pageIndicator[0].classList.remove('finished-page')
        pageIndicator[1].classList.remove('finished-page')
        pageIndicator[1].classList.remove('current-page')
    }
}


// // CANCEL AND BACK NAVIGATION
// CANCEL_BTN.addEventListener("click" ,function(){
//     var page = document.getElementsByClassName("page")

//     // cancel and redirect to index
//     if(currentIndex == 0){
//         location.href = "/establishments"
//     }

//     // sets button values
//     if(currentIndex == 1){
//         CANCEL_BTN.value = "Cancel"
//     }else{
//         NEXT_BTN.value = "Next"
//         NEXT_BTN.style.display = "block"
//         SAVE_BTN.style.display = "none"
//     }

//     // display and hide page
//     if(currentIndex > 0){
//         //set scroll to top/0
//         document.getElementById("scrollable").scrollTop = 0;

//         currentIndex--;
//         for (let i = 2; i < page.length; i--) {
//             if(i == currentIndex){
//                 page[i].style.display = "block";
//                 console.log(currentIndex)
//                 for (let j = 2; j > 0; j--) {
//                     if(i == j){
//                         //remove finish add current
//                         PAGE_INDICATOR[j].classList.remove("finished-page")
//                         PAGE_INDICATOR[j].classList += " current-page"
//                     }else if(i + 1 == j){
//                         PAGE_INDICATOR[j].classList.remove("current-page")
//                     }
//                 }
//                 if(currentIndex == 0){
//                     PAGE_INDICATOR[0].classList.remove("finished-page")
//                     PAGE_INDICATOR[0].classList += " current-page"
//                 }
//             }else{
//                 page[i].style.display = "none";
//             }
//         }
//     }
// })

// // NEXT PAGE NAVIGATION
// NEXT_BTN.addEventListener("click" ,function(){
//     var page = document.getElementsByClassName("page")

//     //set scroll to top/0
//     document.getElementById("scrollable").scrollTop = 0;

//     // increment page and set button value
//     if(currentIndex != page.length - 1){
//         currentIndex++;
//         CANCEL_BTN.value = "Back"
//     }

//     // display and hide page
//     if(currentIndex < page.length){
//         for (let i = 0; i < page.length; i++) {
//             if(i == currentIndex){
//                 page[i].style.display = "block";
//                 for (let j = 0; j < PAGE_INDICATOR.length; j++) {
//                     if(i == j){
//                         if(!PAGE_INDICATOR[j].classList.contains("current-page")){
//                             PAGE_INDICATOR[j].classList += " current-page"
//                         }
//                     }else if(i - 1== j){
//                         PAGE_INDICATOR[j].classList += " finished-page"
//                         PAGE_INDICATOR[j].classList.remove("current-page")
//                     }
//                 }
//             }else{
//                 page[i].style.display = "none";
//             }
//         }
//     }

//     // set current value
//     if(currentIndex == 1){
//         NEXT_BTN.style.display = "none"
//         SAVE_BTN.style.display = "block"
//     }
// })

function turnOffAutocompeteInput()
{
    document.querySelectorAll("input").forEach((input) => {
        input.setAttribute("autocomplete", "off")
    })
}

function validateInputs(inputs) {
    for (var i = 0; i < inputs.length; i++) {
      if ((inputs[i].value.trim() === "" && inputs[i].id === "corporateName") || 
          (inputs[i].value.trim() === "" && inputs[i].id === "firstName") ||
          (inputs[i].value.trim() === "" && inputs[i].id === "lastName")
          ) 
      {
        return false;
      }
    }

    return true;
  }
