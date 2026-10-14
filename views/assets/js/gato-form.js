const formGato = document.getElementById("form-gato");

// Usa la validación nativa de HTML5 (required, min, max, maxlength) y la muestra con estilos de Bootstrap
formGato.addEventListener("submit", function (evento) {
    formGato.querySelectorAll(".form-control, .form-select").forEach(function (campo) {
        if (campo.value.trim() === "" && campo.required) {
            campo.value = "";
        }
        campo.classList.toggle("is-invalid", !campo.checkValidity());
    });

    if (!formGato.checkValidity()) {
        evento.preventDefault();
        formGato.querySelector(".is-invalid").focus();
    }
});

formGato.querySelectorAll(".form-control, .form-select").forEach(function (campo) {
    campo.addEventListener("input", function () {
        if (campo.classList.contains("is-invalid")) {
            campo.classList.toggle("is-invalid", !campo.checkValidity());
        }
    });
});
