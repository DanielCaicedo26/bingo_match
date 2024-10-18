


function toggleForm() {

    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    if (loginForm.style.display === 'none') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
    } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    }
}

function togglePasswordVisibility(inputId, button) {
    const passwordInput = document.getElementById(inputId);
    const icon = button.querySelector('i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Alternar entre formularios de inicio de sesión y registro
function toggleForm() {
    var loginForm = document.getElementById('login-form');
    var registerForm = document.getElementById('register-form');

    // Alternar clases en lugar de cambiar display directamente
    if (loginForm.classList.contains('hidden')) {
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');
    } else {
        loginForm.classList.add('hidden');
        registerForm.classList.remove('hidden');
    }
}


function togglePasswordVisibility(id, element) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        element.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
        input.type = "password";
        element.innerHTML = '<i class="fas fa-eye"></i>';
    }
}




