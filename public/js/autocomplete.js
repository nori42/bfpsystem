const input = document.getElementById("search");
const dataId = document.getElementById("dataId");
const list = document.getElementById("autocomplete-list");

let selectedIndex = -1;
let mouseOnList = false;

list.addEventListener("mouseenter", () => {
    selectedIndex = -1;
    mouseOnList = true;
    const items = list.querySelectorAll("li");
    items.forEach((item) => {
        item.classList.remove("highlight");
    });
});

list.addEventListener("mouseleave", () => {
    mouseOnList = false;
    selectedIndex = -1;
});

input.addEventListener("keydown", (e) => {
    if (list.style.display !== "none") {
        const items = list.querySelectorAll("li");
        switch (e.key) {
            case "ArrowUp": // up arrow
                e.preventDefault();
                if (selectedIndex > 0 && !mouseOnList) {
                    selectedIndex--;
                    highlightItem(items[selectedIndex]);
                }
                break;
            case "ArrowDown": // down arrow
                e.preventDefault();
                if (selectedIndex < items.length - 1 && !mouseOnList) {
                    selectedIndex++;
                    highlightItem(items[selectedIndex]);
                }
                break;
            case "Enter": // enter
                e.preventDefault();
                if (selectedIndex > -1) {
                    input.value = items[selectedIndex].innerText;
                    dataId.value =
                        items[selectedIndex].attributes["data-id"].value;
                    selectedIndex = -1;
                    hideAutocomplete();
                }
                break;
            case "Escape": // escape
                e.preventDefault();
                hideAutocomplete();
                break;
        }
    }
});

input.addEventListener("blur", () => {
    selectedIndex = -1;
});

document.addEventListener("click", (e) => {
    if (!input.contains(e.target) && !list.contains(e.target)) {
        hideAutocomplete();
    }
});

function newLiElem(text, index, dataId = null) {
    const li = document.createElement("li");
    li.innerText = text;
    li.setAttribute("index", index);
    li.setAttribute("data-id", dataId);
    li.addEventListener("click", (e) => {
        input.value = text;
        const searchForm = document.querySelector("#searchForm");
        document.getElementById("dataId").value =
            e.target.attributes["data-id"].value;
        searchForm.submit();
        input.focus();
        hideAutocomplete();
    });

    li.addEventListener("mouseenter", (e) => {
        selectedIndex = e.target.attributes.index.value;
    });

    return li;
}

function showAutocomplete(matches) {
    list.innerHTML = "";
    matches.forEach((match, index) => {
        list.appendChild(newLiElem(match.text, index, match.dataId));
    });

    if (matches.length != 0) list.style.display = "block";
}

function hideAutocomplete() {
    list.style.display = "none";
}

function highlightItem(item) {
    const items = list.querySelectorAll("li");
    items.forEach((item) => {
        item.classList.remove("highlight");
    });
    item.classList.add("highlight");
}
