

const scriptModal = (()=> {
  
// Use this for showing modal
const openModal = (modalTarget, callBack = ()=>{}) => {

 const modal = document.getElementById(modalTarget);
  modal.style.display = "block"
  callBack();
}

const closeModal = (modalTarget) => {

  const modal = document.getElementById(modalTarget);
modal.style.display = "none"
}


return {
  openModal,
  closeModal
}
})();

export default scriptModal