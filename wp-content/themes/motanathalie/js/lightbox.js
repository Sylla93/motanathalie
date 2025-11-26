// /js/lightbox.js

document.addEventListener("DOMContentLoaded", function () {

  /* ==========================================================
     RÉFÉRENCES DES ÉLÉMENTS DE LA LIGHTBOX
     ========================================================== */
  const overlay       = document.getElementById("lightbox-overlay");  // Fond noir + conteneur
  const lightboxImg   = document.getElementById("lightbox-img");       // Image affichée
  const lightboxTitle = document.getElementById("lightbox-title");     // Titre (alt)
  const lightboxRef   = document.getElementById("lightbox-ref");       // Référence photo
  const lightboxCat   = document.getElementById("lightbox-cat");       // Catégorie photo
  const btnClose      = document.querySelector(".lightbox-close");     // Bouton fermeture
  const btnNext       = document.querySelector(".lightbox-next");      // Bouton suivant
  const btnPrev       = document.querySelector(".lightbox-prev");      // Bouton précédent

  // Index de l'image actuellement affichée dans la lightbox
  let currentIndex = 0;


  /* ==========================================================
     RÉCUPÉRATION DYNAMIQUE DE LA LISTE DES IMAGES
     Utilisé pour supporter l’AJAX (images ajoutées après coup)
     ========================================================== */
  const getImages = () =>
    Array.from(document.querySelectorAll(".photo-thumbnail img"));



  /* ==========================================================
     OUVERTURE DE LA LIGHTBOX SUR UNE IMAGE DONNÉE
     ========================================================== */
  function openLightbox(index) {
    const images = getImages();
    const img = images[index];
    if (!img) return; // Sécurité si index invalide

    // Charge les données de l'image
    lightboxImg.src = img.src;
    lightboxImg.alt = img.alt || "";
    lightboxTitle.textContent = img.alt || "Photo";
    lightboxRef.textContent   = img.dataset.ref || "Référence inconnue";
    lightboxCat.textContent   = img.dataset.categorie || "Catégorie inconnue";

    // Mémorise l’index pour la navigation
    currentIndex = index;

    // Affiche la lightbox
    overlay.classList.remove("hidden");
  }



  /* ==========================================================
     FERMETURE DE LA LIGHTBOX
     ========================================================== */
  function closeLightbox() {
    overlay.classList.add("hidden");
  }



  /* ==========================================================
     NAVIGATION ENTRE LES IMAGES (suivant / précédent)
     ========================================================== */
  function nextImage() {
    const images = getImages();
    if (!images.length) return;

    // Passe à l’image suivante (boucle infinie)
    currentIndex = (currentIndex + 1) % images.length;
    openLightbox(currentIndex);
  }

  function prevImage() {
    const images = getImages();
    if (!images.length) return;

    // Passe à l’image précédente (boucle infinie)
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    openLightbox(currentIndex);
  }



  /* ==========================================================
     DÉLÉGATION D’ÉVÉNEMENTS
     Permet de capturer les clics même sur éléments ajoutés via AJAX
     ========================================================== */
  document.addEventListener("click", function (e) {

    // Vérifie si l’on clique sur un bouton ouvrant la lightbox
    const trigger = e.target.closest(".fullscreen-btn, .icon-top");
    if (!trigger) return;

    e.preventDefault();
    e.stopPropagation();

    // Trouve la miniature associée
    const thumb = trigger.closest(".photo-thumbnail");
    if (!thumb) return;

    const img = thumb.querySelector("img");
    if (!img) return;

    // Trouve l’index réel de cette image dans la liste dynamique
    const images = getImages();
    const idx = images.indexOf(img);
    if (idx === -1) return;

    // Ouvre la lightbox sur cet index
    openLightbox(idx);
  });



  /* ==========================================================
     ÉVÉNEMENTS DES BOUTONS DE NAVIGATION
     ========================================================== */
  if (btnNext)
    btnNext.addEventListener("click", (e) => {
      e.stopPropagation();
      nextImage();
    });

  if (btnPrev)
    btnPrev.addEventListener("click", (e) => {
      e.stopPropagation();
      prevImage();
    });



  /* ==========================================================
     FERMETURE : bouton X ou clic sur le fond
     ========================================================== */
  if (btnClose)
    btnClose.addEventListener("click", closeLightbox);

  // Fermer uniquement si on clique sur le fond, pas sur l’image
  overlay.addEventListener("click", (e) => {
    if (e.target === overlay) closeLightbox();
  });



  /* ==========================================================
     NAVIGATION CLAVIER
     ========================================================== */
  document.addEventListener("keydown", (e) => {

    // Si la lightbox est fermée → on ignore
    if (overlay.classList.contains("hidden")) return;

    if (e.key === "ArrowRight") nextImage();
    if (e.key === "ArrowLeft")  prevImage();
    if (e.key === "Escape")     closeLightbox();
  });

});
