

document.addEventListener('DOMContentLoaded', () => {
  const burger = document.getElementById("burger-btn");
  const menu = document.querySelector(".header-menu-class");
  
  if (burger && menu) {
    burger.addEventListener('click', function(event) {
      event.preventDefault();
      event.stopPropagation();
      // On bascule la classe open sur le bouton burger et active sur le menu
      burger.classList.toggle("open");
      menu.classList.toggle("active");
    });
  }
});

