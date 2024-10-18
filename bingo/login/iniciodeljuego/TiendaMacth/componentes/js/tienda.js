function mostrarCarton(idCarton) {
    // Oculta todos los cartones
    document.querySelectorAll('.carton').forEach(carton => {
        carton.classList.remove('card');
    });
    // Muestra el cartón correspondiente
    document.getElementById(idCarton).classList.add('card');
}

// Inicializar con el primer cartón visible
document.addEventListener("DOMContentLoaded", function() {
    mostrarCarton('carton1');
});