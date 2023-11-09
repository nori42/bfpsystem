// toggle visibility element

const scriptModule = (() => {
    const toggleShow = (id) => {
        const elem = document.getElementById(id);

        if (elem.style.display === "none") elem.style.display = "block";
        else elem.style.display = "none";
    };

    return {
        toggleShow,
    };
})();

export default scriptModule;
