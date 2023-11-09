// PUT THE LOGIN PAGE SCRIPT HERE

const showPassword = document.querySelector("#showPassword");
const icon = showPassword.querySelector("i");

console.log(icon);

let shown = false;
showPassword.addEventListener("click", function () {
    shown = !shown;
    if (shown) {
        document.querySelector("#password").type = "text";
        icon.classList.add("bi-eye-slash-fill");
        icon.classList.remove("bi-eye-fill");
    } else {
        document.querySelector("#password").type = "password";
        icon.classList.add("bi-eye-fill");
        icon.classList.remove("bi-eye-slash-fill");
    }
});
