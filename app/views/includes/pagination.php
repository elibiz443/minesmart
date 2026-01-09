<!-- Pagination -->
<div id="paginationComponent" class="w-[calc(100%-12rem)] ml-auto flex justify-center items-center my-6 transition-all duration-500 ease-in-out">
  <div class="bg-gray-300 inline-flex px-4 rounded-lg">
    <?php if ($current_page > 1): ?>
      <a href="?page=<?php echo $current_page - 1; ?>" class="bg-gray-300 hover:bg-teal-700 text-[#36454F] hover:text-white font-bold py-3 px-6">Previous</a>
    <?php endif; ?>

    <?php
      $startPage = max(1, $current_page - 1);
      $endPage = min($totalPages, $startPage + 2);

      // Ensure we always show 3 buttons if possible
      if (($endPage - $startPage) < 2) {
        $startPage = max(1, $endPage - 2);
      }
    ?>

    <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
      <a href="?page=<?php echo $page; ?>" class="bg-gray-300 hover:bg-teal-700 text-[#36454F] font-bold py-3 px-6 <?php echo ($page == $current_page) ? 'bg-teal-600 text-white' : 'hover:bg-teal-700 hover:text-white'; ?>">
        <?php echo $page; ?>
      </a>
    <?php endfor; ?>

    <?php if ($current_page < $totalPages): ?>
      <a href="?page=<?php echo $current_page + 1; ?>" class="bg-gray-300 hover:bg-teal-700 text-[#36454F] hover:text-white font-bold py-3 px-6">Next</a>
    <?php endif; ?>
  </div>
</div>
