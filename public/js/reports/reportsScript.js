
const reportsSelect = document.querySelector('#reportsSelect');
const pageContent = document.querySelectorAll('.page-content')[0];

console.log(pageContent)

reportsSelect.addEventListener('change', () => {
    pageContent.innerHTML = `<h2 class="text-center mt-5">Fetching Reports...</h2>`

    switch (reportsSelect.value) {
        case 'inspection':
            window.location.href = 'http://127.0.0.1:8000/reports/fsic';
            break;
        case 'firedrill':
            window.location.href = 'http://127.0.0.1:8000/reports/firedrill';
            break;
        case 'buildingplan':
            window.location.href = 'http://127.0.0.1:8000/establishments';
            break;
    }
})

