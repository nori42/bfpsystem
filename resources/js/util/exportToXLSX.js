import {write,utils} from 'xlsx';

const exportTableToXLSX = function (tableID, filename) {
    var wb = utils.table_to_book(document.getElementById(tableID), {
        sheet: 'SheetJS'
    });

    var wbout = write(wb, {
        bookType: 'xlsx',
        type: 'binary'
    });

    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xff;
        return buf;
    }

    var link = document.createElement('a');
    link.href = URL.createObjectURL(new Blob([s2ab(wbout)], {
        type: 'application/octet-stream'
    }));
    link.download = filename+'.xlsx';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

}

export default exportTableToXLSX