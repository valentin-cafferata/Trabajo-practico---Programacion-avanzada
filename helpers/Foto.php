<?php
// helpers/Foto.php
// Subida, validación y borrado de las fotos de las publicaciones

class Foto {

    const CARPETA = 'uploads/gatos/';
    const PLACEHOLDER = 'views/assets/img/sin-foto.svg';
    const MAX_BYTES = 3 * 1024 * 1024; // 3 MB
    const TIPOS = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    // Devuelve true si el usuario adjuntó un archivo en el campo
    public static function enviada($campo) {
        return isset($_FILES[$campo]) && $_FILES[$campo]['error'] !== UPLOAD_ERR_NO_FILE;
    }

    // Valida y guarda la foto subida. Devuelve [rutaRelativa|null, mensajeError|null]
    public static function guardar($campo) {
        $archivo = $_FILES[$campo] ?? null;

        if (!$archivo || $archivo['error'] === UPLOAD_ERR_NO_FILE) {
            return [null, null];
        }
        if ($archivo['error'] === UPLOAD_ERR_INI_SIZE || $archivo['error'] === UPLOAD_ERR_FORM_SIZE) {
            return [null, 'La foto es demasiado pesada (máximo 3 MB).'];
        }
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return [null, 'No se pudo subir la foto. Intentá de nuevo.'];
        }
        if ($archivo['size'] > self::MAX_BYTES) {
            return [null, 'La foto es demasiado pesada (máximo 3 MB).'];
        }

        // El tipo se detecta por el contenido real del archivo, no por la extensión
        $mime = mime_content_type($archivo['tmp_name']);
        if (!isset(self::TIPOS[$mime]) || getimagesize($archivo['tmp_name']) === false) {
            return [null, 'La foto debe ser una imagen JPG, PNG o WEBP.'];
        }

        $destinoDir = __DIR__ . '/../' . self::CARPETA;
        if (!is_dir($destinoDir)) {
            mkdir($destinoDir, 0775, true);
        }

        $nombre = bin2hex(random_bytes(16)) . '.' . self::TIPOS[$mime];
        if (!move_uploaded_file($archivo['tmp_name'], $destinoDir . $nombre)) {
            return [null, 'No se pudo guardar la foto en el servidor.'];
        }

        return [self::CARPETA . $nombre, null];
    }

    // Borra una foto subida por un usuario (nunca borra las imágenes de ejemplo del proyecto)
    public static function borrar($ruta) {
        if ($ruta && strpos($ruta, self::CARPETA) === 0) {
            $completa = __DIR__ . '/../' . $ruta;
            if (is_file($completa)) {
                unlink($completa);
            }
        }
    }

    // Ruta a mostrar en la vista: la foto del gato o la imagen de "sin foto"
    public static function url($ruta) {
        if ($ruta && is_file(__DIR__ . '/../' . $ruta)) {
            return $ruta;
        }
        return self::PLACEHOLDER;
    }
}
