
// toggle visibility element

const scriptModule = (()=>{
    
const toggleShow = (id) =>
{
    const elem = document.getElementById(id)
    
    if(elem.style.display === 'none')
        elem.style.display = 'block';
    else
        elem.style.display ='none';

}

return {
    toggleShow
}
})();

export default scriptModule


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