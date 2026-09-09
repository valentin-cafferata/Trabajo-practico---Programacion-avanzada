const userInput = document.getElementById("usuario");
const passwordInput = document.getElementById("password");
const submitBtn = document.getElementById("submit-btn");

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