mapboxgl.accessToken = 'pk.eyJ1IjoiZWxpYml6NDQzIiwiYSI6ImNsenFidXEyMTEybGcybHM4ZXM1emN6NXkifQ.PBaEzWluDdJWIMM2-YOPAg';

let siteMap;
let marker;

function initSiteMap() {
  if (siteMap) return;

  siteMap = new mapboxgl.Map({
    container: 'site-map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [36.8219, -1.2921], // Default: Nairobi
    zoom: 6
  });

  // If coordinates exist in the hidden input, show the marker
  const coordsInput = document.getElementById('coords-input');
  const coordDisplay = document.getElementById('coord-values');
  try {
    const coords = JSON.parse(coordsInput.value || null);
    if (Array.isArray(coords) && coords.length === 2) {
      marker = new mapboxgl.Marker({ color: '#facc15' })
        .setLngLat(coords)
        .addTo(siteMap);
      siteMap.setCenter(coords);
      siteMap.setZoom(6); // Zoom in to the marker
      coordDisplay.textContent = `Lat: ${coords[1]}, Lng: ${coords[0]}`;
    }
  } catch (err) {
    console.warn('Invalid saved coordinates:', err);
  }

  siteMap.on('click', (e) => {
    const lngLat = e.lngLat;
    const coordsArray = [parseFloat(lngLat.lng.toFixed(6)), parseFloat(lngLat.lat.toFixed(6))];
    const coordsJSON = JSON.stringify(coordsArray);

    if (!marker) {
      marker = new mapboxgl.Marker({ color: '#facc15' })
        .setLngLat(lngLat)
        .addTo(siteMap);
    } else {
      marker.setLngLat(lngLat);
    }

    coordsInput.value = coordsJSON;
    coordDisplay.textContent = `Lat: ${coordsArray[1]}, Lng: ${coordsArray[0]}`;
  });
}

// Optional: auto-init when modal opens
const observer = new MutationObserver(() => {
  const modal = document.getElementById('form-modal');
  if (!modal.classList.contains('hidden')) {
    setTimeout(initSiteMap, 200); // small delay to ensure visibility
  }
});

observer.observe(document.body, { attributes: true, childList: true, subtree: true });
