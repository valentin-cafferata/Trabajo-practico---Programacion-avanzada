const formRegistro = document.getElementById("form-registro");
const pass1 = document.getElementById("password");
const pass2 = document.getElementById("password2");
const pass2Error = document.getElementById("password2-error");

function validarCoincidencia() {
    const coinciden = pass1.value === pass2.value;
    // setCustomValidity hace que checkValidity() falle si no coinciden
    pass2.setCustomValidity(coinciden ? "" : "Las contraseñas no coinciden.");
    if (!coinciden) {
        pass2Error.innerText = "Las contraseñas no coinciden.";
    }
    return coinciden;
}

function mostrarErrorCaptcha() {
    if (document.getElementById("captcha-error-js")) {
        return;
    }
    const alerta = document.createElement("div");
    alerta.id = "captcha-error-js";
    alerta.className = "alert alert-danger mb-3";
    alerta.innerText = "Debes completar el captcha.";
    formRegistro.parentNode.insertBefore(alerta, formRegistro);
}

formRegistro.addEventListener("submit", function (evento) {
    validarCoincidencia();

    formRegistro.querySelectorAll(".form-control").forEach(function (campo) {
        campo.classList.toggle("is-invalid", !campo.checkValidity());
    });

    const captchaOk = typeof grecaptcha !== "undefined" && grecaptcha.getResponse().length > 0;
    if (!captchaOk) {
        mostrarErrorCaptcha();
    } else {
        const alerta = document.getElementById("captcha-error-js");
        if (alerta) {
            alerta.remove();
        }
    }

    if (!formRegistro.checkValidity() || !captchaOk) {
        evento.preventDefault();
        const primero = formRegistro.querySelector(".is-invalid");
        if (primero) {
            primero.focus();
        }
    }
});

formRegistro.querySelectorAll(".form-control").forEach(function (campo) {
    campo.addEventListener("input", function () {
        if (campo === pass1 || campo === pass2) {
            validarCoincidencia();
        }
        if (campo.classList.contains("is-invalid")) {
            campo.classList.toggle("is-invalid", !campo.checkValidity());
        }
    });
});
