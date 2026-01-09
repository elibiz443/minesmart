const itemsPerPage = 10;
let currentPage = 1;

function applyFilters() {
  const titleFilter = document.getElementById('filter-title').value.toLowerCase();
  const statusFilter = document.getElementById('filter-status').value;
  const dateFilter = document.getElementById('filter-date').value;

  const cards = document.querySelectorAll('.notification-card');
  const list = [...cards];

  let filtered = list.filter(card => {
    const title = card.dataset.title;
    const status = card.dataset.status;
    return (
      (!titleFilter || title.includes(titleFilter)) &&
      (!statusFilter || status === statusFilter)
    );
  });

  // Sort by date
  filtered.sort((a, b) => {
    const dateA = parseInt(a.dataset.date);
    const dateB = parseInt(b.dataset.date);
    return dateFilter === 'oldest' ? dateA - dateB : dateB - dateA;
  });

  // Hide/show with pagination
  const totalPages = Math.ceil(filtered.length / itemsPerPage);
  const start = (currentPage - 1) * itemsPerPage;
  const end = start + itemsPerPage;

  cards.forEach(c => c.style.display = 'none');
  filtered.slice(start, end).forEach(c => c.style.display = 'block');

  renderPagination(totalPages);
}

function renderPagination(totalPages) {
  const container = document.getElementById('pagination');
  container.innerHTML = '';
  for (let i = 1; i <= totalPages; i++) {
    const btn = document.createElement('button');
    btn.textContent = i;
    btn.className = `mx-1 px-3 py-1 rounded ${i === currentPage ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300'} transition`;
    btn.onclick = () => {
      currentPage = i;
      applyFilters();
    };
    container.appendChild(btn);
  }
}

document.getElementById('filter-title').addEventListener('input', () => { currentPage = 1; applyFilters(); });
document.getElementById('filter-status').addEventListener('change', () => { currentPage = 1; applyFilters(); });
document.getElementById('filter-date').addEventListener('change', () => { currentPage = 1; applyFilters(); });

window.addEventListener('DOMContentLoaded', () => {
  applyFilters();
});
