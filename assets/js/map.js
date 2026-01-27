const map = L.map('map', {
  zoomControl: false,
  attributionControl: false
}).setView([-1.286389, 36.817223], 7)

L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
  maxZoom: 19
}).addTo(map)

const sites = window.SITES_DATA || []

sites.forEach(site => {
  const color = site.score > 70 ? '#f43f5e' : (site.score > 40 ? '#f59e0b' : '#10b981')
  const customIcon = L.divIcon({
    className: 'custom-marker',
    html: `<div class="marker-pulse" style="background: ${color};"></div>`,
    iconSize: [20, 20]
  })

  L.marker(site.coords, { icon: customIcon })
    .addTo(map)
    .bindPopup(`
      <div class="text-white p-1 min-w-[8.75rem]">
        <h3 class="font-black text-[0.6875rem] border-b border-slate-700 pb-2 mb-2 uppercase tracking-wider">
          ${site.name}
        </h3>
        <div class="flex justify-between items-center mb-1">
          <span class="text-[0.5625rem] text-slate-400 font-bold uppercase">Fused Risk</span>
          <span class="text-xs font-black" style="color: ${color}">${site.score}</span>
        </div>
        <p class="text-[0.5625rem] text-slate-500 font-mono italic">${site.decision}</p>
      </div>
    `, {
      className: 'custom-popup',
      closeButton: false
    })
})
