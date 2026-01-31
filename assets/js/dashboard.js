const map = L.map('map', { zoomControl: false, attributionControl: false }).setView([-1.286389, 36.817223], 6)

L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
  maxZoom: 19
}).addTo(map)

const sites = window.SITES_DATA || []
const bounds = []

sites.forEach(site => {
  if(!site.coords || site.coords.length < 2) return

  const lat = parseFloat(site.coords[0])
  const lng = parseFloat(site.coords[1])

  if(!Number.isFinite(lat) || !Number.isFinite(lng)) return
  if(Math.abs(lat) > 90 || Math.abs(lng) > 180) return
  if(lat === 0 && lng === 0) return

  const score = Number.isFinite(site.score) ? site.score : 0
  const color = score > 70 ? '#f43f5e' : score > 40 ? '#f59e0b' : '#10b981'

  const icon = L.divIcon({
    className: 'custom-marker',
    html: `<div style="width:14px;height:14px;border-radius:50%;background:${color};box-shadow:0 0 0 3px rgba(15,23,42,0.85),0 0 18px rgba(0,0,0,0.35);"></div>`,
    iconSize: [14, 14],
    iconAnchor: [7, 7]
  })

  const m = L.marker([lat, lng], { icon }).addTo(map)
  bounds.push([lat, lng])

  const name = site.name || 'Site'
  const decision = site.decision || ''
  const badges = Array.isArray(site.badges) ? site.badges.filter(Boolean).slice(0, 3) : []
  const badgesHtml = badges.length ? `<div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;">${badges.map(b => `<span style="font-size:10px;letter-spacing:.1em;text-transform:uppercase;padding:4px 8px;border-radius:999px;border:1px solid rgba(148,163,184,0.25);background:rgba(15,23,42,0.45);color:rgba(226,232,240,0.9);">${b}</span>`).join('')}</div>` : ''

  m.bindPopup(`<div style="min-width:240px;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
      <div>
        <div style="font-weight:900;letter-spacing:.08em;text-transform:uppercase;font-size:12px;color:rgba(226,232,240,0.95);">${name}</div>
        <div style="margin-top:4px;font-size:11px;color:rgba(148,163,184,0.95);">${decision}</div>
      </div>
      <div style="font-weight:900;font-size:18px;color:${color};">${score.toFixed(1)}</div>
    </div>
    ${badgesHtml}
  </div>`)
})

if(bounds.length) map.fitBounds(bounds, { padding: [30, 30] })
setTimeout(function(){ map.invalidateSize(true) }, 250)
