document.addEventListener("DOMContentLoaded", () => {
  const ridesList = document.getElementById("ridesList");
  const filtroBtn = document.getElementById("aplicar-filtros");

  let todasViagens = [];

  // Buscar viagens do banco
  fetch("listarviagens.php")
    .then(res => res.json())
    .then(viagens => {
      todasViagens = viagens; // salvar para filtros
      renderizarViagens(viagens);
      console.log(viagens);
    });

  // Filtro ao clicar
  filtroBtn.addEventListener("click", () => {
    const eco = document.getElementById("filterEco").checked;
    const maxPreco = parseFloat(document.getElementById("filterMaxPrice").value);
    const minRating = parseFloat(document.getElementById("filterMinRating").value);

    const filtradas = todasViagens.filter(viagem => {
      const condicoes = [];
      if (!isNaN(maxPreco)) condicoes.push(viagem.preco <= maxPreco);
      if (!isNaN(minRating)) condicoes.push(viagem.nota >= minRating);
      if (eco) condicoes.push(viagem.eco);
      return condicoes.every(Boolean);
    });

    renderizarViagens(filtradas);
  });

  // Função para criar os cards dinamicamente
  function renderizarViagens(viagens) {
    ridesList.innerHTML = "";

    viagens.forEach(viagem => {
      const fotoPath = viagem.foto?.startsWith("uploads/")
  ? viagem.foto
  : `uploads/${viagem.foto ?? "default.jpg"}`;

      const card = document.createElement("div");
      card.classList.add("ride-card");
      card.innerHTML = `
  <img src="${fotoPath}" alt="Photo du conducteur" class="driver-photo">
  <div class="ride-info">
    <h3>${viagem.motorista} <span class="rating">${viagem.nota ?? 'N/A'}⭐</span></h3>
    <p class="available-seats">Places disponibles : <span class="seats">${viagem.lugares_disponiveis}</span></p>
    <p class="price">Prix : ${viagem.preco}€</p>
    <p><strong>Départ :</strong> ${viagem.partida}</p>
    <p><strong>Arrivée :</strong> ${viagem.chegada}</p>
    <p class="${viagem.eco ? 'eco' : 'non-eco'}">
      ${viagem.eco ? 'Trajet écologique 🌱' : 'Trajet non écologique ❌'}
    </p>
    <button class="detalhes-btn">Détails</button>
  </div>
`;


      // Clique no botão ou card inteiro
      card.addEventListener("click", () => {
        const detalhesViagem = {
          motorista: viagem.motorista,
          nota: viagem.nota,
          lugaresRestantes: viagem.lugares_disponiveis,
          preco: viagem.preco,
          id: viagem.id,
          foto: viagem.foto
        };
        localStorage.setItem("detalhesViagem", JSON.stringify(detalhesViagem));
        window.location.href = "details.html";
      });

      ridesList.appendChild(card);
    });
  }
});
