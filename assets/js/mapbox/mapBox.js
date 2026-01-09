mapboxgl.accessToken = 'pk.eyJ1IjoiZWxpYml6NDQzIiwiYSI6ImNsenFidXEyMTEybGcybHM4ZXM1emN6NXkifQ.PBaEzWluDdJWIMM2-YOPAg';

const map = new mapboxgl.Map({
  container: 'map',
  style: 'mapbox://styles/mapbox/streets-v12',
  center: [35, -2],
  zoom: 6
});

map.on('load', () => {
  const attributionButton = document.querySelector('.mapboxgl-ctrl-attrib-button');
  if (attributionButton) {
    attributionButton.setAttribute('aria-label', 'Map attribution');
  }
  fetchLocations();
});

map.addControl(new mapboxgl.NavigationControl(), 'top-right');

async function fetchLocations() {
  try {
    const response = await fetch(`${ROOT_URL}/app/controllers/sites/api_locations.php`);
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
    const sites = await response.json();
    processLocations(sites);
  } catch (error) {
    console.error('Error fetching locations:', error);
  }
}

function processLocations(sites) {
  sites.forEach(site => {
    let coords;
    try {
      coords = JSON.parse(site.coords);
      if (!Array.isArray(coords) || coords.length !== 2) return;
    } catch (e) {
      return;
    }

    const markerElement = document.createElement('div');
    markerElement.style.backgroundImage = `url(${site.image_link ? ROOT_URL + site.image_link : ROOT_URL + '/assets/images/default.webp'})`;
    markerElement.style.backgroundSize = 'cover';
    markerElement.style.width = '32px';
    markerElement.style.height = '32px';
    markerElement.style.borderRadius = '100%';
    markerElement.style.zIndex = '30';
    markerElement.style.border = '2px solid white';
    markerElement.style.boxShadow = '0 4px 6px -1px rgb(0 0 0)';
    markerElement.style.cursor = 'pointer';

    let popupHTML = `
      <div class="relative bg-white shadow-md rounded-2xl overflow-hidden size-[20rem]">
        <img src="${site.image_link ? ROOT_URL + site.image_link : ROOT_URL + '/assets/images/default.webp'}" class="w-full h-[60%] object-cover">
        <div class="bg-gradient-to-tr from-black/20 to-black w-full h-[60%] absolute top-0">
          <div class="flex space-x-2 absolute left-2 bottom-2">
            <button onclick="location.href='${ROOT_URL}/app/views/sites/view.php?id=${site.id}'" class="cursor-pointer size-7 flex items-center justify-center text-white bg-teal-600 rounded-md hover:bg-teal-800 shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="18" height="18" fill="currentColor"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
            </button>
            <a href="${ROOT_URL}/app/controllers/sites/delete.php?id=${site.id}" onclick="return confirm('Are you sure you want to delete this site?');" class="size-7 flex items-center justify-center text-white bg-red-500 rounded-md hover:bg-red-800 shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="18" height="18" fill="currentColor"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0L284.2 0c12.1 0 23.2 6.8 28.6 17.7L320 32l96 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 96C14.3 96 0 81.7 0 64S14.3 32 32 32l96 0 7.2-14.3zM32 128l384 0 0 320c0 35.3-28.7 64-64 64L96 512c-35.3 0-64-28.7-64-64l0-320zm96 64c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16z"/></svg>
            </a>
          </div>
        </div>
        <div class="px-4 pt-4">
          <h4 class="text-sm text-teal-800 font-bold mb-1">${site.name}</h4>
          <p class="text-slate-600 text-xs">Coordinates: ${site.coords}</p>
          <p class="absolute right-3 bottom-3 text-xs text-teal-700 font-semibold">Created by: ${site.creator.name}</p>
        </div>
      </div>
    `;

    const marker = new mapboxgl.Marker({ element: markerElement })
      .setLngLat(coords)
      .setPopup(new mapboxgl.Popup().setHTML(popupHTML))
      .addTo(map);
  });
}

document.querySelectorAll('.location').forEach(item => {
  item.addEventListener('click', function () {
    const coords = JSON.parse(this.getAttribute('data-coords'));
    const zoomLevel = parseInt(this.getAttribute('data-zoom'));
    map.flyTo({ center: coords, zoom: zoomLevel });
  });
});

const dragHandle = document.getElementById('drag-handle');
const canvas = map.getCanvasContainer();
let isDragging = false;
let lastX, lastY;

dragHandle.addEventListener('mousedown', (e) => {
  isDragging = true;
  lastX = e.clientX;
  lastY = e.clientY;
  dragHandle.classList.replace('cursor-grab', 'cursor-grabbing');
  canvas.style.cursor = 'grabbing';
  const onMouseMove = (moveEvent) => {
    if (!isDragging) return;
    const dx = moveEvent.clientX - lastX;
    const dy = moveEvent.clientY - lastY;
    map.panBy([-dx, -dy]);
    lastX = moveEvent.clientX;
    lastY = moveEvent.clientY;
  };
  const onMouseUp = () => {
    isDragging = false;
    canvas.style.cursor = '';
    dragHandle.classList.replace('cursor-grabbing', 'cursor-grab');
    document.removeEventListener('mousemove', onMouseMove);
    document.removeEventListener('mouseup', onMouseUp);
  };
  document.addEventListener('mousemove', onMouseMove);
  document.addEventListener('mouseup', onMouseUp);
});