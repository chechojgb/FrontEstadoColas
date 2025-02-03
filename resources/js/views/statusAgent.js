
document.addEventListener("DOMContentLoaded", function () {
    function animacion() {
        let elementos = document.querySelectorAll('.activeStatus'); // Selecciona TODOS los spans con la clase activeStatus
        elementos.forEach((elemento) => {
            elemento.classList.toggle('fade'); // Aplica la animación a cada uno
        });
    }

    setInterval(animacion, 500);
});
