document.getElementById("buttonContainer").addEventListener("click", function(){
    window.print();
})



function checkToggle(id) {
    element = document.getElementById(id)
    
    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden')
      } else {
        element.classList.add('hidden')
      }
  }

function showCert(){

    printable = document.getElementById('printablePage')

    if (printable.style.backgroundSize === '0%') {
        printable.style.backgroundSize = 'contain';
        } else {
            printable.style.backgroundSize = '0%';
        }
}

function makeElementEditable(element) {
    element.contentEditable = true;

    element.addEventListener('blur', () => {
        const newText = element.innerText.trim();
        // Do something with the new text
    });
}

function makeElementDraggable(element) {

    // Variables to hold the position of the draggable element
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;

    // Attach mousedown event listener to the element
    element.onmousedown = dragMouseDown;

    // Get the current mouse position
    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();

        // Get the position of the element
        pos3 = e.clientX;
        pos4 = e.clientY;

        document.onmousemove = elementDrag;
        document.onmouseup = stopElementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();

        // Calculate the new position of the element
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;

        // Set the element's new position
        element.style.top = (element.offsetTop - pos2) + "px";
        element.style.left = (element.offsetLeft - pos1) + "px";
    }

    function stopElementDrag() {
        // Remove the mousemove and mouseup event listeners
        document.onmouseup = null;
        document.onmousemove = null;
    }
}