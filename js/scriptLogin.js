// script para ocultar o mostrar contraseña
function togglePasswordVisibility() {
    var passwordInput = document.getElementById('password');
    var toggleButton = document.getElementById('toggle-password');
    var isPasswordVisible = toggleButton.getAttribute('data-visible') === 'true';

    if (isPasswordVisible) {
        // ocultar contraseña
        passwordInput.type = 'password';
        toggleButton.setAttribute('data-visible', 'false');
        toggleButton.querySelector('img').src = './images/eye-slash.svg';  // cambia el icono a 'ojo cerrado'
    } else {
        // mostrar contraseña
        passwordInput.type = 'text';
        toggleButton.setAttribute('data-visible', 'true');
        toggleButton.querySelector('img').src = './images/eye.svg';  // cambia el icono a 'ojo abierto'
    }
}
