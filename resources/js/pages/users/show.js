const passwordInput = document.getElementById("passwordNew");
const confirmPasswordInput = document.getElementById("passwordConfirmNew");
const btnPassword = document.querySelector("[btnPassword]");

btnPassword.addEventListener("click", () => {
    document.querySelector("[btnPassword-menu]").classList.toggle("d-none");
});

confirmPasswordInput.addEventListener("input", () => {
    if (passwordInput.value !== confirmPasswordInput.value) {
        confirmPasswordInput.setCustomValidity("Passwords do not match");
    } else {
        confirmPasswordInput.setCustomValidity("");
    }
});

addEvent("change", select("#profilePicInp"), () => {
    select("#btnUpdate").classList.remove("d-none");

    if (select("#profilePicInp").files && select("#profilePicInp").files[0]) {
        select("#profilePic").src = URL.createObjectURL(
            select("#profilePicInp").files[0]
        );
    }
});

addEvent("mouseenter", select("#profile"), (e) => {
    select("#btnChangeProfile").classList.remove("d-none");
    e.target.style.opacity = "0.5";
});

addEvent("mouseleave", select("#profile"), (e) => {
    select("#btnChangeProfile").classList.add("d-none");
    e.target.style.opacity = "1";
});
