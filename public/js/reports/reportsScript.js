
const reportsSelect = document.querySelector('#reportsSelect');
const pageContent = document.querySelectorAll('.page-content')[0]
const btnViewReport = document.querySelector('#viewReport')

const dateFrom = document.querySelector(["#dateFrom"])
const dateTo = document.querySelector(["#dateTo"])

const loadingMssg = document.querySelector(["#loadingMssg"])
const activtiyContent = document.querySelector(["#pageContent"])

btnViewReport.addEventListener('click',() => {
    if (dateFrom.value != "" && dateTo.value != "") {
        loadingMssg.classList.remove('d-none')
        activtiyContent.classList.add('d-none')
    }
})

dateFrom.addEventListener('change', () => {
    dateTo.value = dateFrom.value
})

function initReportLink(APP_URL){
    reportsSelect.addEventListener('change', () => {
        pageContent.innerHTML = `<h2 class="text-center mt-5">Fetching Reports...</h2>`
    
        switch (reportsSelect.value) {
            case 'inspection':
                window.location.href = `${APP_URL}/reports/fsic`;
                break;
            case 'firedrill':
                window.location.href = `${APP_URL}/reports/firedrill`;
                break;
            case 'buildingplan':
                window.location.href = `${APP_URL}/reports/fsec`;
                break;
        }
    })
}
