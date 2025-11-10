// (function() {
//   const catSelect = document.querySelector('.choisir .categorie');
//   const formatSelect = document.querySelector('.choisir .format');
//   const trierSelect = document.querySelector('.choisir .trier');
//   const grid = document.getElementById('photos-grid');
//   const loadMoreBtn = document.getElementById('load-more');

//   if (!catSelect || !formatSelect || !trierSelect || !grid) return;

//   let currentPage = 1;
//   let totalPages = 1;
//   let loading = false;

//   // Charger dynamiquement les taxonomies
//   async function loadTaxonomies() {
//     const [cats, formats] = await Promise.all([
//       fetch(`${wpData.root}wp/v2/${wpData.tax.categorie}?per_page=100`, {
//         headers: { 'X-WP-Nonce': wpData.nonce },
//       }).then(r => r.json()),
//       fetch(`${wpData.root}wp/v2/${wpData.tax.format}?per_page=100`, {
//         headers: { 'X-WP-Nonce': wpData.nonce },
//       }).then(r => r.json()),
//     ]);

//     if (Array.isArray(cats)) {
//   cats.forEach(term => {
//     const opt = document.createElement('option');
//     opt.value = term.slug;
//     opt.textContent = term.name;
//     catSelect.appendChild(opt);
//   });
// } else {
//   console.warn('⚠️ Aucune donnée catégorie reçue :', cats);
// }


//    if (Array.isArray(formats)) {
//   formats.forEach(term => {
//     const opt = document.createElement('option');
//     opt.value = term.slug;
//     opt.textContent = term.name;
//     formatSelect.appendChild(opt);
//   });
// } else {
//   console.warn('⚠️ Aucune donnée format reçue :', formats);
// }


//     // Options du tri
//     trierSelect.innerHTML = `
//       <option value="">Trier par</option>
//       <option value="date_desc">Plus récentes</option>
//       <option value="date_asc">Plus anciennes</option>
//       <option value="argentique">Argentique</option>
//       <option value="numerique">Numérique</option>
//     `;
//   }

//   // Charger les photos via REST API
//   async function loadPhotos({append = false} = {}) {
//     if (loading) return;
//     loading = true;

//     const category = catSelect.value;
//     const format = formatSelect.value;
//     const sort = trierSelect.value || 'date_desc';

//     const url = new URL(`${wpData.root}wp/v2/${wpData.cpt}`);
//     url.searchParams.set('per_page', 9);
//     url.searchParams.set('page', currentPage);

//     if (category) url.searchParams.set('categorie', category);
//     if (format) url.searchParams.set('format', format);

//     // Gestion du tri / filtre selon le champ personnalisé type_photo
//     if (sort === 'argentique' || sort === 'numerique') {
//       url.searchParams.set('meta_key', 'type_photo');
//       url.searchParams.set('meta_value', sort === 'argentique' ? 'Argentique' : 'Numérique');
//     } else if (sort.includes('date')) {
//       url.searchParams.set('orderby', 'date');
//       url.searchParams.set('order', sort.endsWith('asc') ? 'asc' : 'desc');
//     }

//     const res = await fetch(url, { headers: { 'X-WP-Nonce': wpData.nonce } });
//     const photos = await res.json();
//     totalPages = parseInt(res.headers.get('X-WP-TotalPages')) || 1;

//     renderPhotos(photos, {append});
//     loadMoreBtn.hidden = currentPage >= totalPages;
//     loading = false;
//   }

//   // Afficher les photos
//   function renderPhotos(photos, {append = false} = {}) {
//     if (!append) grid.innerHTML = '';

//     if (!photos.length) {
//       grid.innerHTML = '<p>Aucune photo trouvée.</p>';
//       return;
//     }

//     const fragment = document.createDocumentFragment();
//     photos.forEach(photo => {
//       const div = document.createElement('div');
//       div.className = 'photo-item';
//       div.innerHTML = `
//         <a href="${photo.link}">
//           <img src="${photo.featured_media_url || ''}" alt="${photo.title.rendered}">
//           <p>${photo.title.rendered}</p>
//         </a>
//       `;
//       fragment.appendChild(div);
//     });
//     grid.appendChild(fragment);
//   }

//   // Réagir aux changements
//   function onFilterChange() {
//     currentPage = 1;
//     loadPhotos();
//   }

//   loadMoreBtn.addEventListener('click', () => {
//     if (currentPage < totalPages) {
//       currentPage++;
//       loadPhotos({append: true});
//     }
//   });

//   catSelect.addEventListener('change', onFilterChange);
//   formatSelect.addEventListener('change', onFilterChange);
//   trierSelect.addEventListener('change', onFilterChange);

//   // Initialisation
//   (async () => {
//     await loadTaxonomies();
//     await loadPhotos();
//   })();
// })();
