document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("menu-container");

  if (container) {
    fetch("menu.html")
      .then(res => res.text())
      .then(data => {
        container.innerHTML = data;

        // Agora que o menu foi carregado, buscamos os elementos corretamente
        const hamburger = document.querySelector(".hamburger");
        const nav = document.querySelector(".nav");

        if (hamburger && nav) {
          hamburger.addEventListener("click", () => {
            nav.classList.toggle("nav-active");
          });
        }
      })
      .catch(error => console.error("Erro ao carregar o menu:", error));
  }
});
