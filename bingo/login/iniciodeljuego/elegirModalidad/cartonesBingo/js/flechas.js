// Selecciona todas las celdas en las cartas de bingo
const cells = document.querySelectorAll('.cell');

// Agrega un evento de clic a cada celda
cells.forEach(cell => {
    cell.addEventListener('click', () => {
        cell.classList.toggle('marked');
    });
});

// Funcionalidad para cambiar entre los cartones
const bingoCards = document.querySelectorAll('.bingo-card');
let currentCardIndex = 0;
const nextArrow = document.getElementById('next-arrow');

// Muestra el siguiente cartón cuando se hace clic en la flecha
nextArrow.addEventListener('click', () => {
    // Oculta el cartón actual
    bingoCards[currentCardIndex].classList.remove('visible');
    
    // Incrementa el índice para pasar al siguiente cartón
    currentCardIndex = (currentCardIndex + 1) % bingoCards.length;
    
    // Muestra el siguiente cartón
    bingoCards[currentCardIndex].classList.add('visible');
});
