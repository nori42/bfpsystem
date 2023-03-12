
// toggle visibility element
function toggleShow(id)
{
    var elem = document.getElementById(id)

    if(elem.style.display == 'none')
    elem.style.display = 'block';
    else
    elem.style.display ='none'
}

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




