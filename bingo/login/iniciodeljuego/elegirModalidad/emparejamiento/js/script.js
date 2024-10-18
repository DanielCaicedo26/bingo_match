document.addEventListener("DOMContentLoaded", () => {
    // Simulando la carga
    setTimeout(() => {
        const carga = document.getElementById('carga');
        const listaBots = document.getElementById('listaBots');

        carga.classList.add('hidden'); // Oculta la pantalla de carga
        listaBots.classList.remove('hidden'); // Muestra la lista de bots
    }, 2000); // Simula un tiempo de carga de 2 segundos
});
