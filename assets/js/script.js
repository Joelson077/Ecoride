
document.getElementById('aplicar-filtros').addEventListener('click', function() {
    // Pegando os valores dos filtros
    const onlyEco = document.getElementById('filterEco').checked; // Se o filtro ecológico estiver marcado ou não
    const maxPrice = parseFloat(document.getElementById('filterMaxPrice').value); // Preço máximo
    const maxDuration = parseFloat(document.getElementById('filterMaxDuration').value); // Duração máxima
    const minRating = parseFloat(document.getElementById('filterMinRating').value); // Nota mínima
  
    // Pegando todos os cards de motoristas (as caronas)
    const rideCards = document.querySelectorAll('.ride-card');
  
    // Para cada card de motorista
    rideCards.forEach(card => {
      const isEco = card.querySelector('.eco') !== null; // Verifica se o card é ecológico
      const priceText = card.querySelector('.price').innerText; // Pega o preço do card
      const price = parseFloat(priceText.replace('€', '').trim()); // Converte o preço para número
      const ratingText = card.querySelector('.rating').innerText; // Pega a nota do motorista
      const rating = parseFloat(ratingText.replace('⭐', '').trim()); // Converte a nota para número
  
      let show = true; // Variável que vai definir se o card será exibido ou não
  
      // Comparando se o card atende aos filtros
      if (onlyEco && !isEco) {
        show = false; // Se o filtro ecológico estiver marcado e o card não for ecológico, esconde
      }
      if (!isNaN(maxPrice) && price > maxPrice) {
        show = false; // Se o preço do card for maior que o preço máximo, esconde
      }
      if (!isNaN(minRating) && rating < minRating) {
        show = false; // Se a nota do motorista for menor que a nota mínima, esconde
      }
      if (!isNaN(maxDuration) && card.querySelector('.duration')) { // Duração máxima se fornecida
        const duration = parseFloat(card.querySelector('.duration').innerText.replace('h', '').trim());
        if (duration > maxDuration) {
          show = false; // Se a duração for maior que a máxima fornecida, esconde
        }
      }
  
      // Mostrar ou esconder o card com base na variável "show"
      if (show) {
        card.style.display = 'flex'; // Exibe o card
      } else {
        card.style.display = 'none'; // Esconde o card
      }
    });
  });
  