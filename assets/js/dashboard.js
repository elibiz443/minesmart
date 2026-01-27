const map = L.map('map', { zoomControl: false, attributionControl: false }).setView([-1.286389, 36.817223], 6)

L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
  maxZoom: 19
}).addTo(map)

const sites = window.SITES_DATA || []

sites.forEach(site => {
  const color = site.score > 70 ? '#f43f5e' : site.score > 40 ? '#f59e0b' : '#10b981'
  const icon = L.divIcon({
    className: 'custom-marker',
    html: `<div style="width:14px;height:14px;border-radius:50%;background:${color}"></div>`,
    iconSize: [14, 14]
  })
  L.marker(site.coords, { icon }).addTo(map)
})
