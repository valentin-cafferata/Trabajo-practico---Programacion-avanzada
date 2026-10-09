document.addEventListener("DOMContentLoaded", function() {
    const mensaje = document.getElementById("captcha-error");
    
    if (mensaje) {
        const url = new URL(window.location.href);
        if (url.searchParams.has("captcha_error")) {
            url.searchParams.delete("captcha_error");
            window.history.replaceState({}, document.title, url.pathname);
        }
    }
});