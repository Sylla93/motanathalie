// /js/lightbox.js
document.addEventListener("DOMContentLoaded", function () {
  // --- Références lightbox
  const overlay      = document.getElementById("lightbox-overlay");
  const lightboxImg  = document.getElementById("lightbox-img");
  const lightboxTitle= document.getElementById("lightbox-title");
  const lightboxRef  = document.getElementById("lightbox-ref");
  const lightboxCat  = document.getElementById("lightbox-cat");
  const btnClose     = document.querySelector(".lightbox-close");
  const btnNext      = document.querySelector(".lightbox-next");
  const btnPrev      = document.querySelector(".lightbox-prev");

  // Index courant dans la liste d'images (calculée à la volée)
  let currentIndex = 0;

  // Récupère la liste d’images actuellement présentes dans le DOM
  const getImages = () =>
    Array.from(document.querySelectorAll(".photo-thumbnail img"));

  // Ouvre la lightbox sur un index donné
  function openLightbox(index) {
    const images = getImages();
    const img = images[index];
    if (!img) return;

    lightboxImg.src = img.src;
    lightboxImg.alt = img.alt || "";
    lightboxTitle.textContent = img.alt || "Photo";
    lightboxRef.textContent = img.dataset.ref || "Référence inconnue";
    lightboxCat.textContent = img.dataset.categorie || "Catégorie inconnue";

    currentIndex = index;
    overlay.classList.remove("hidden");
  }

  // Ferme la lightbox
  function closeLightbox() {
    overlay.classList.add("hidden");
  }

  // Navigation
  function nextImage() {
    const images = getImages();
    if (!images.length) return;
    currentIndex = (currentIndex + 1) % images.length;
    openLightbox(currentIndex);
  }
  function prevImage() {
    const images = getImages();
    if (!images.length) return;
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    openLightbox(currentIndex);
  }

  // --- DÉLÉGATION D'ÉVÉNEMENTS ---
  // Clic sur l’œil ou l’icône plein écran (même pour les éléments injectés après AJAX)
  document.addEventListener("click", function (e) {
    const trigger = e.target.closest(".fullscreen-btn, .icon-top");
    if (!trigger) return;

    e.preventDefault();
    e.stopPropagation();

    // Trouver l'image liée au bouton cliqué
    const thumb = trigger.closest(".photo-thumbnail");
    if (!thumb) return;
    const img = thumb.querySelector("img");
    if (!img) return;

    const images = getImages();
    const idx = images.indexOf(img);
    if (idx === -1) return;

    openLightbox(idx);
  });

  // Boutons de nav
  if (btnNext) btnNext.addEventListener("click", (e) => { e.stopPropagation(); nextImage(); });
  if (btnPrev) btnPrev.addEventListener("click", (e) => { e.stopPropagation(); prevImage(); });

  // Fermer
  if (btnClose) btnClose.addEventListener("click", closeLightbox);
  overlay.addEventListener("click", (e) => {
    if (e.target === overlay) closeLightbox();
  });

  // Clavier
  document.addEventListener("keydown", (e) => {
    if (overlay.classList.contains("hidden")) return;
    if (e.key === "ArrowRight") nextImage();
    if (e.key === "ArrowLeft")  prevImage();
    if (e.key === "Escape")     closeLightbox();
  });
});
