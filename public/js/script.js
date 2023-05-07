
// toggle visibility element
function toggleShow(id)
{
    const elem = document.getElementById(id)

    if(elem.style.display === 'none')
        elem.style.display = 'block';
    else
        elem.style.display ='none';

}
// window.addEventListener("click",(event)=>{
//         const dropdowns = document.querySelectorAll('[data-dropdown-menu]')

//         const currentMenu = event.target.parentNode.nextElementSibling || event.target.parentNode.children[1] ;

//         const currentMenuClicked = event.target.closest('[data-dropdown-menu]')

//         dropdowns.forEach(dropdown => {
//             if(dropdown != currentMenu )
//             {
//                 if(dropdown.style.display == "block")
//                 {
//                     dropdown.style.display = "none";
//                 }
//             }
//     });

// })

function handleFsicActions (e){
    console.log(e);
    var btnPayment = document.getElementById('btnPayment');
    var payment = document.getElementById('payment');
    var btnInspection = document.getElementById('btnInspection');
    var inspection = document.getElementById('inspection');
    var btnAttachments = document.getElementById('btnAttachments');
    var attachments = document.getElementById('attachments');

    switch(e.target.id)
    {
        case 'btnPayment':
        {
            btnPayment.classList.add('active');
            payment.style.display = 'block';
            btnInspection.classList.remove('active');
            inspection.style.display = 'none';
            btnAttachments.classList.remove('active');
            attachments.style.display = 'none';
        } break;

        case 'btnInspection':
        {
            btnPayment.classList.remove('active');
            payment.style.display = 'none';
            btnInspection.classList.add('active');
            inspection.style.display = 'block';
            btnAttachments.classList.remove('active');
            attachments.style.display = 'none';
        } break;

        case 'btnAttachments':
        {
            btnPayment.classList.remove('active');
            payment.style.display = 'none';
            btnInspection.classList.remove('active');
            inspection.style.display = 'none';
            btnAttachments.classList.add('active');
            attachments.style.display = 'block';
        } break;

        default:
    }
}


// //Upload Script
// function uploadFile(){
//     const modalContent = document.querySelector('#addAttachmentModal').children[0]
//     Array.from(modalContent.children).forEach(element => {
//         element.style.opacity = '0%';
//         element.style.pointerEvents = 'none';
//     });
//     // Add the loading screen
//     modalContent.insertAdjacentHTML('afterbegin','<div><div class="fw-bold fs-5" id="loading-message">Uploading...</div><div id="loading-bar-spinner" class="spinner"><div class="spinner-icon"></div></div></div>') 
    
//     // Submit the file
//     document.querySelector('#fileForm').submit();
// }

// fileUpload.addEventListener('change', function(){
//     const fileUpload = document.querySelector('#fileUpload')
//     const files = fileUpload.files

//     if(files != null)
//     {
//         document.querySelector('.filelist-container').style.display = "block"
//         document.querySelector('#submitFile').style.display = "block"
        
//         const filelist = document.querySelector('.filelist')
//         filelist.innerHTML = ""

//         Array.from(files).forEach(file => {
//             const li = document.createElement('li');
//             li.textContent = file.name
//             filelist.appendChild(li)
//         });
//     }
// })
