// PUT THE INSPECTIONS PAGE SCRIPT HERE

selectAll("select[select-value]").forEach((el) => {
    el.value = el.getAttribute("select-value");
});
