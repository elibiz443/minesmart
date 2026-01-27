const toggleBtn = document.getElementById('toggleSites')
const sitesPanel = document.getElementById('sitesPanel')
const mapContainer = document.getElementById('mapContainer')

let hidden = window.innerWidth < 768

function applyState() {
  if (hidden) {
    sitesPanel.style.width = '0'
    sitesPanel.style.opacity = '0'
    sitesPanel.style.pointerEvents = 'none'
    toggleBtn.textContent = 'Show Panel'
  } else {
    sitesPanel.style.width = window.innerWidth >= 768 ? '20rem' : '14rem'
    sitesPanel.style.opacity = '1'
    sitesPanel.style.pointerEvents = 'auto'
    toggleBtn.textContent = 'Hide Panel'
  }
  setTimeout(() => {
    map.invalidateSize()
  }, 520)
}

applyState()

window.addEventListener('resize', () => {
  if (window.innerWidth < 768) {
    hidden = true
  }
  applyState()
})

toggleBtn.addEventListener('click', () => {
  hidden = !hidden
  applyState()
})
