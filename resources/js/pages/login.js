const showPassword = document.querySelector('#showPassword')

showPassword.addEventListener('change', function() {
    if (showPassword.checked) {
        document.querySelector('#password').type = "text"
    } else {
        document.querySelector('#password').type = "password"
    }
})