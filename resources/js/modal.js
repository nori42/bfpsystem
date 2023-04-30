

const scriptModal = (()=> {
  
// Use this for showing modal
const openModal = (modalTarget) => {

 const modal = document.getElementById(modalTarget);
  modal.style.display = "block"
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