const formGato = document.getElementById("form-gato");
const inputFoto = document.getElementById("foto");
const preview = document.getElementById("foto-preview");
const fotoError = document.getElementById("foto-error");
const TIPOS_PERMITIDOS = ["image/jpeg", "image/png", "image/webp"];

// Valida la foto elegida y muestra la vista previa antes de subirla
function validarFoto() {
    const archivo = inputFoto.files[0];

    if (!archivo) {
        // Al editar la foto es opcional; al crear es obligatoria (required)
        const faltante = inputFoto.required;
        inputFoto.classList.toggle("is-invalid", faltante);
        if (faltante) {
            fotoError.innerText = "Subí una foto del gato.";
        }
        return !faltante;
    }

    let mensaje = "";
    if (!TIPOS_PERMITIDOS.includes(archivo.type)) {
        mensaje = "La foto debe ser JPG, PNG o WEBP.";
    } else if (archivo.size > Number(inputFoto.dataset.maxBytes)) {
        mensaje = "La foto pesa " + (archivo.size / 1024 / 1024).toFixed(1) + " MB. El máximo es 3 MB.";
    }

    inputFoto.classList.toggle("is-invalid", mensaje !== "");
    if (mensaje) {
        fotoError.innerText = mensaje;
        return false;
    }

    preview.src = URL.createObjectURL(archivo);
    return true;
}

inputFoto.addEventListener("change", validarFoto);

// Usa la validación nativa de HTML5 (required, min, max, maxlength) y la muestra con estilos de Bootstrap
formGato.addEventListener("submit", function (evento) {
    formGato.querySelectorAll(".form-control:not([type=file]), .form-select").forEach(function (campo) {
        if (campo.required && campo.value.trim() === "") {
            campo.value = "";
        }
        campo.classList.toggle("is-invalid", !campo.checkValidity());
    });

    const fotoOk = validarFoto();

    if (!formGato.checkValidity() || !fotoOk) {
        evento.preventDefault();
        const primero = formGato.querySelector(".is-invalid");
        if (primero) {
            primero.focus();
        }
    }
});

formGato.querySelectorAll(".form-control:not([type=file]), .form-select").forEach(function (campo) {
    campo.addEventListener("input", function () {
        if (campo.classList.contains("is-invalid")) {
            campo.classList.toggle("is-invalid", !campo.checkValidity());
        }
    });
});
