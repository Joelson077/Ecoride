document.addEventListener("DOMContentLoaded", () => {
  const dados = JSON.parse(localStorage.getItem("detalhesViagem"));
  let usuario = JSON.parse(localStorage.getItem("usuario"));

  const participateBtn = document.getElementById("participateBtn");
  const modal = document.getElementById("confirmationModal");
  const confirmBtn = document.getElementById("confirmBtn");
  const cancelBtn = document.getElementById("cancelBtn");
  const closeBtn = document.querySelector(".close-btn");

  if (!dados || !dados.id) {
    alert("Detalhes da viagem não encontrados ou ID ausente.");
    return;
  }

  const fotoPath = dados.foto?.startsWith("uploads/")
    ? dados.foto
    : `uploads/${dados.foto ?? "default.jpg"}`;

  document.querySelector(".car-info").innerHTML = `
    <img src="${fotoPath}" alt="Foto do Motorista" class="car-image">
    <p><strong>Motorista:</strong> ${dados.motorista}</p>
    <p><strong>Avaliação:</strong> ${dados.nota}/5</p>
    <p><strong>Lugares Disponíveis:</strong> <span id="availableSeats">${dados.lugaresRestantes}</span></p>
    <p><strong>Preço:</strong> <span id="creditValue">${dados.preco}</span> Créditos</p>
  `;

  participateBtn.addEventListener("click", () => {
    if (!usuario) {
      localStorage.setItem("querParticipar", "true");
      localStorage.setItem("voltarPara", location.pathname);
      window.location.href = "login.html";
      return;
    }

    if (dados.lugaresRestantes <= 0) {
      alert("Não há mais lugares disponíveis.");
      return;
    }

    if (usuario.creditos < dados.preco) {
      alert("Você não tem créditos suficientes.");
      return;
    }

    document.getElementById("creditValue").textContent = dados.preco;
    modal.style.display = "block";
  });

  if (usuario && localStorage.getItem("querParticipar") === "true") {
    localStorage.removeItem("querParticipar");
    localStorage.removeItem("voltarPara");
    if (dados.lugaresRestantes > 0 && usuario.creditos >= dados.preco) {
      document.getElementById("creditValue").textContent = dados.preco;
      modal.style.display = "block";
    }
  }

  confirmBtn.addEventListener("click", () => {
    // DEBUG dos dados enviados
    console.log("Enviando participação:", {
      usuario_id: usuario.id,
      viagem_id: dados.id,
      creditos: dados.preco
    });

    fetch("registrar_participacao.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        usuario_id: usuario.id,
        viagem_id: dados.id,
        creditos: dados.preco
      })
    })
    .then(res => res.json())
    .then(res => {
      if (res.status === "sucesso") {
        // Atualiza localStorage
        usuario.creditos -= dados.preco;
        dados.lugaresRestantes -= 1;

        localStorage.setItem("usuario", JSON.stringify(usuario));
        localStorage.setItem("detalhesViagem", JSON.stringify(dados));
        document.getElementById("availableSeats").textContent = dados.lugaresRestantes;

        alert("Participação confirmada!");
        modal.style.display = "none";
        window.location.href = "historicoviagem.html";
      } else {
        alert("Erro: " + res.mensagem);
      }
    })
    .catch(err => {
      console.error("Erro ao registrar participação:", err);
      alert("Erro ao registrar participação.");
    });
  });

  cancelBtn.addEventListener("click", () => modal.style.display = "none");
  closeBtn.addEventListener("click", () => modal.style.display = "none");
});
