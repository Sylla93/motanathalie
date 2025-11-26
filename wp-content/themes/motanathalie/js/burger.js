// Exécute le script une fois que tout le HTML est chargé
document.addEventListener('DOMContentLoaded', () => {

  // Récupère le bouton burger
  const burger = document.getElementById("burger-btn");

  // Récupère le menu à ouvrir/fermer
  const menu = document.querySelector(".header-menu-class");
  
  // Vérifie que les deux éléments existent dans la page
  if (burger && menu) {

    // Écoute le clic sur le bouton burger
    burger.addEventListener('click', function(event) {

      // Empêche le comportement par défaut (au cas où le bouton soit un lien)
      event.preventDefault();

      // Empêche le clic de remonter dans le DOM
      event.stopPropagation();

      // Bascule la classe "open" sur le burger (animation)
      burger.classList.toggle("open");

      // Bascule la classe "active" sur le menu (affiche/masque)
      menu.classList.toggle("active");
    });
  }
});
