const userInput = document.getElementById("usuario");
const passwordInput = document.getElementById("password");
const submitBtn = document.getElementById("submit-btn");
const miForm = document.getElementById("miForm"); // Seleccionamos el formulario

function verificarCampos() {
    const usuario = userInput.value.trim();
    const password = passwordInput.value.trim();
    
    if (usuario !== "" && password !== "") {
        submitBtn.disabled = false;
    } else {
        submitBtn.disabled = true;
    }
}

userInput.addEventListener("input", verificarCampos);
passwordInput.addEventListener("input", verificarCampos);

// Validar el captcha antes de enviar el formulario
miForm.addEventListener("submit", function(evento) {
    // grecaptcha.getResponse() devuelve un string vacío si no se completó
    const respuestaCaptcha = grecaptcha.getResponse();

    if (respuestaCaptcha.length === 0) {
        // Frena el envío al backend, evitando que la página recargue
        evento.preventDefault();

        // Evitamos duplicar el cartel si el usuario hace clic varias veces
        let alertaExistente = document.getElementById("captcha-error-js");
        
        if (!alertaExistente) {
            // Creamos el div de alerta dinámicamente
            const alerta = document.createElement("div");
            alerta.id = "captcha-error-js";
            alerta.className = "alert alert-danger mb-3";
            alerta.innerText = "Debes completar el captcha.";
            
            // Lo insertamos justo antes del formulario
            miForm.parentNode.insertBefore(alerta, miForm);
        }
    }
});