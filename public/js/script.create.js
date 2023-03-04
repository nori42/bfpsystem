const CANCEL_BTN = document.getElementById("cancelBtn")
const NEXT_BTN = document.getElementById("nextBtn")
const SAVE_BTN = document.getElementById("saveBtn")
const PAGE_INDICATOR = document.getElementById("page-container").children

var currentIndex = 0;

// CANCEL AND BACK NAVIGATION
CANCEL_BTN.addEventListener("click" ,function(){
    var page = document.getElementsByClassName("page")

    // cancel and redirect to index
    if(currentIndex == 0){
        location.href = "/establishments"
    }

    // sets button values
    if(currentIndex == 1){
        CANCEL_BTN.value = "Cancel"
    }else{
        NEXT_BTN.value = "Next"
        NEXT_BTN.style.display = "block"
        SAVE_BTN.style.display = "none"
    }

    // display and hide page
    if(currentIndex > 0){
        //set scroll to top/0
        document.getElementById("scrollable").scrollTop = 0;

        currentIndex--;
        for (let i = 2; i < page.length; i--) {
            if(i == currentIndex){
                page[i].style.display = "block";
                console.log(currentIndex)
                for (let j = 2; j > 0; j--) {
                    if(i == j){
                        //remove finish add current
                        PAGE_INDICATOR[j].classList.remove("finished-page")
                        PAGE_INDICATOR[j].classList += " current-page"
                    }else if(i + 1 == j){
                        PAGE_INDICATOR[j].classList.remove("current-page")
                    }
                }
                if(currentIndex == 0){
                    PAGE_INDICATOR[0].classList.remove("finished-page")
                    PAGE_INDICATOR[0].classList += " current-page"
                }
            }else{
                page[i].style.display = "none";
            }
        }
    }
})

// NEXT PAGE NAVIGATION
NEXT_BTN.addEventListener("click" ,function(){
    var page = document.getElementsByClassName("page")

    //set scroll to top/0
    document.getElementById("scrollable").scrollTop = 0;

    // increment page and set button value
    if(currentIndex != page.length - 1){
        currentIndex++;
        CANCEL_BTN.value = "Back"
    }

    // display and hide page
    if(currentIndex < page.length){
        for (let i = 0; i < page.length; i++) {
            if(i == currentIndex){
                page[i].style.display = "block";
                for (let j = 0; j < PAGE_INDICATOR.length; j++) {
                    if(i == j){
                        if(!PAGE_INDICATOR[j].classList.contains("current-page")){
                            PAGE_INDICATOR[j].classList += " current-page"
                        }
                    }else if(i - 1== j){
                        PAGE_INDICATOR[j].classList += " finished-page"
                        PAGE_INDICATOR[j].classList.remove("current-page")
                    }
                }
            }else{
                page[i].style.display = "none";
            }
        }
    }

    // set current value
    if(currentIndex == 2){
        NEXT_BTN.style.display = "none"
        SAVE_BTN.style.display = "block"
    }
})