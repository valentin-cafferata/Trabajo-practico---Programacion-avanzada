const userInput = document.getElementById("usuario");
const passwordInput = document.getElementById("password");
const submitBtn = document.getElementById("submit-btn");
const miForm = document.getElementById("miForm");

const REGEX_USUARIO = /^[A-Za-z0-9._-]+$/;

function verificarCampos() {
    const usuario = userInput.value.trim();
    const password = passwordInput.value.trim();

    submitBtn.disabled = usuario === "" || password === "";
}

function marcarCampo(input, mensaje) {
    const feedback = document.getElementById(input.id + "-error");

    if (mensaje) {
        input.classList.add("is-invalid");
        feedback.innerText = mensaje;
        return false;
    }

    input.classList.remove("is-invalid");
    feedback.innerText = "";
    return true;
}

function validarUsuario() {
    const usuario = userInput.value.trim();

    if (usuario.length < 3) {
        return marcarCampo(userInput, "El usuario debe tener al menos 3 caracteres.");
    }
    if (!REGEX_USUARIO.test(usuario)) {
        return marcarCampo(userInput, "El usuario solo puede tener letras, números, punto, guion o guion bajo.");
    }
    return marcarCampo(userInput, "");
}

function validarPassword() {
    if (passwordInput.value.length < 6) {
        return marcarCampo(passwordInput, "La contraseña debe tener al menos 6 caracteres.");
    }
    return marcarCampo(passwordInput, "");
}

function mostrarErrorCaptcha() {
    // Evitamos duplicar el cartel si el usuario hace clic varias veces
    if (document.getElementById("captcha-error-js")) {
        return;
    }

    const alerta = document.createElement("div");
    alerta.id = "captcha-error-js";
    alerta.className = "alert alert-danger mb-3";
    alerta.innerText = "Debes completar el captcha.";

    miForm.parentNode.insertBefore(alerta, miForm);
}

function quitarErrorCaptcha() {
    const alerta = document.getElementById("captcha-error-js");
    if (alerta) {
        alerta.remove();
    }
}

userInput.addEventListener("input", function () {
    verificarCampos();
    if (userInput.classList.contains("is-invalid")) {
        validarUsuario();
    }
});

passwordInput.addEventListener("input", function () {
    verificarCampos();
    if (passwordInput.classList.contains("is-invalid")) {
        validarPassword();
    }
});

userInput.addEventListener("blur", function () {
    if (userInput.value.trim() !== "") {
        validarUsuario();
    }
});

// Validar todo antes de enviar, sin recargar la página si hay errores
miForm.addEventListener("submit", function (evento) {
    const usuarioOk = validarUsuario();
    const passwordOk = validarPassword();

    // grecaptcha.getResponse() devuelve un string vacío si no se completó
    const captchaOk = typeof grecaptcha !== "undefined" && grecaptcha.getResponse().length > 0;

    if (captchaOk) {
        quitarErrorCaptcha();
    } else {
        mostrarErrorCaptcha();
    }

    if (!usuarioOk || !passwordOk || !captchaOk) {
        evento.preventDefault();
    }
});

verificarCampos();
