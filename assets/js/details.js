document.addEventListener("DOMContentLoaded", () => {
  const dados = JSON.parse(localStorage.getItem("detalhesViagem"));
  let usuario = JSON.parse(localStorage.getItem("usuario"));

  const participateBtn = document.getElementById("participateBtn");
  const modal = document.getElementById("confirmationModal");
  const confirmBtn = document.getElementById("confirmBtn");
  const cancelBtn = document.getElementById("cancelBtn");
  const closeBtn = document.querySelector(".close-btn");

  if (!dados || !dados.id) {
    alert("Les détails du voyage n'ont pas été trouvés ou l'identifiant est manquant.");
    return;
  }

  const fotoPath = dados.foto?.startsWith("uploads/")
    ? dados.foto
    : `uploads/${dados.foto ?? "default.jpg"}`;

  document.querySelector(".car-info").innerHTML = `
    <img src="${fotoPath}" alt="Photo du conducteur" class="car-image">
    <p><strong>Conducteur :</strong> ${dados.motorista}</p>
    <p><strong>Note :</strong> ${dados.nota}/5</p>
    <p><strong>Places disponibles :</strong> <span id="availableSeats">${dados.lugaresRestantes}</span></p>
    <p><strong>Prix :</strong> <span id="creditValue">${dados.preco}</span> crédits</p>
  `;

  participateBtn.addEventListener("click", () => {
    if (!usuario) {
      localStorage.setItem("querParticipar", "true");
      localStorage.setItem("voltarPara", location.pathname);
      window.location.href = "login.html";
      return;
    }

    if (dados.lugaresRestantes <= 0) {
      alert("Il n'y a plus de places disponibles.");
      return;
    }

    if (usuario.creditos < dados.preco) {
      alert("Vous n'avez pas assez de crédits.");
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
    console.log("Envoi de la participation :", {
      utilisateur_id: usuario.id,
      voyage_id: dados.id,
      credits: dados.preco
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
        usuario.creditos -= dados.preco;
        dados.lugaresRestantes -= 1;

        localStorage.setItem("usuario", JSON.stringify(usuario));
        localStorage.setItem("detalhesViagem", JSON.stringify(dados));
        document.getElementById("availableSeats").textContent = dados.lugaresRestantes;

        alert("Participation confirmée avec succès !");
        modal.style.display = "none";
        window.location.href = "historicoviagem.html";
      } else {
        alert("Erreur : " + res.mensagem);
      }
    })
    .catch(err => {
      console.error("Erreur lors de l'enregistrement de la participation :", err);
      alert("Erreur lors de l'enregistrement de la participation.");
    });
  });

  cancelBtn.addEventListener("click", () => modal.style.display = "none");
  closeBtn.addEventListener("click", () => modal.style.display = "none");
});
