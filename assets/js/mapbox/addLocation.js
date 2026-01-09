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

  siteMap.on('click', (e) => {
    const lngLat = e.lngLat;
    const coordsArray = [parseFloat(lngLat.lng.toFixed(6)), parseFloat(lngLat.lat.toFixed(6))];
    const coordsJSON = JSON.stringify(coordsArray); // This will be valid JSON for DB

    // Place or move marker
    if (!marker) {
      marker = new mapboxgl.Marker({ color: '#facc15' }) // Yellow marker
        .setLngLat(lngLat)
        .addTo(siteMap);
    } else {
      marker.setLngLat(lngLat);
    }

    // Set JSON string as input value
    document.getElementById('coords-input').value = coordsJSON;
    // Optional: display raw coords nicely
    document.getElementById('coord-values').textContent = `Lat: ${coordsArray[1]}, Lng: ${coordsArray[0]}`;
  });
}

// Optional: auto-init when modal opens
const observer = new MutationObserver(() => {
  const modal = document.getElementById('form-modal');
  if (!modal.classList.contains('hidden')) {
    setTimeout(initSiteMap, 300); // small delay to ensure visibility
  }
});

observer.observe(document.body, { attributes: true, childList: true, subtree: true });
