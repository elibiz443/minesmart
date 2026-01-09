<?php
  $siteAdmins = [];
  try {
    $stmt = $pdo->prepare("SELECT id, full_name FROM users WHERE role = 'site_admin' ORDER BY full_name ASC");
    $stmt->execute();
    $siteAdmins = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    error_log("Error fetching site admins: " . $e->getMessage());
    $siteAdmins = [];
  }
?>

<div id="form-modal" class="fixed z-[999999] text-sm inset-0 bg-black/70 flex items-center justify-center hidden">
  <div class="glass-bg-color2 p-6 lg:p-10 rounded-xl border border-gray-400 shadow-2xl shadow-gray-900 w-[96%] md:w-[88%] lg:w-[74%] text-white">
    <h2 class="text-xl font-semibold mb-4">Edit Site</h2>
    <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
      <input type="hidden" name="form_type" value="site_form">
      <input type="hidden" name="site_id" value="<?= htmlspecialchars($selected_site['id'] ?? ''); ?>">
      <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($selected_site['user_id'] ?? ''); ?>">
      <input type="hidden" name="coords" id="coords-input" value="<?php echo htmlspecialchars($selected_site['coords'] ?? ''); ?>">

      <div class="grid grid-cols-1 gap-4">
        <div class="grid grid-cols-2 gap-2">
          <div>
            <input name="name" type="text" id="site-name" value="<?php echo htmlspecialchars($selected_site['name'] ?? ''); ?>" class="w-full px-3 py-2 bg-transparent border-b border-white text-white focus:outline-none focus:border-yellow-600">
          </div>

          <div>
            <select name="admin_id" id="admin_id"
              class="w-full px-3 py-2 bg-transparent border-b border-white text-white focus:outline-none focus:border-yellow-600"
              required>
              <option value="" class="bg-gray-700 text-gray-300">Select an Admin</option>
              <?php if (!empty($siteAdmins)): ?>
                  <?php foreach ($siteAdmins as $admin): ?>
                      <option value="<?= htmlspecialchars($admin['id']) ?>" class="bg-gray-700 text-white"
                          <?= (isset($selected_site['admin_id']) && $selected_site['admin_id'] == $admin['id']) ? 'selected' : ''; ?>>
                          <?= htmlspecialchars($admin['full_name']) ?>
                      </option>
                  <?php endforeach; ?>
              <?php else: ?>
                  <option value="" disabled class="bg-gray-700 text-gray-500">No Site Admins Found</option>
              <?php endif; ?>
            </select>
          </div>
        </div>

        <div>
          <label class="block mb-1 text-white">Current Site Image</label>
          <div class="flex space-x-4 items-center">
            <img src="<?php echo htmlspecialchars(ROOT_URL . ($selected_site['image_link'] ?? '/assets/images/default.webp')); ?>" id="preview-img"
              class="size-[4rem] object-cover border-2 border-gray-400 rounded-md cursor-pointer hover:scale-110 shadow-md shadow-slate-800 transition-all duration-500 ease-in-out" onclick="openImageModal('<?php echo htmlspecialchars(ROOT_URL . ($selected_site['image_link'] ?? '/assets/images/default.webp')); ?>')">

            <button type="button" onclick="document.getElementById('file-input').click()" class="bg-yellow-600 hover:bg-yellow-800 text-white px-3 py-2 rounded">
              Change Image
            </button>
            <input type="file" id="file-input" name="image_link" class="hidden" accept="image/*" onchange="previewSelectedImage(event)">
          </div>
        </div>

        <div>
          <label class="block mb-1 text-white">Update Location on Map</label>
          <div id="site-map" class="rounded-lg border border-white h-64"></div>
          <p class="mt-2 text-sm text-gray-300" id="coord-display">
            Selected Coords: <span class="font-medium text-yellow-400" id="coord-values"><?php echo htmlspecialchars($selected_site['coords'] ?? 'None'); ?></span>
          </p>
        </div>
      </div>

      <div class="flex justify-end mt-6">
        <button type="button" onclick="closeModal()" class="px-4 py-2 cursor-pointer mr-2 bg-gray-300 hover:bg-gray-700 text-neutral-900 hover:text-white rounded transition-all">Cancel</button>
        <button type="submit" name="update" class="px-4 py-2 cursor-pointer bg-yellow-600 hover:bg-yellow-800 text-white rounded transition-all">Update Site</button>
      </div>
    </form>
  </div>
</div>
