
const reportsSelect = document.querySelector('#reportsSelect')

reportsSelect.addEventListener('change', () => {
    console.log(reportsSelect.value)

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