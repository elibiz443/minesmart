<!-- Notification List -->
<div id="notification-list" class="grid grid-cols-1 gap-2">
  <?php foreach ($alerts as $note): ?>
    <div
      class="notification-card cursor-pointer w-full px-2 md:px-6 py-2 rounded-md shadow-md shadow-slate-800 border-4 border-slate-300 hover:bg-slate-200 hover:shadow-none hover:border-yellow-400 transition-all duration-700 ease-in-out <?= $note['is_read'] ? 'bg-white' : 'bg-teal-100' ?>"
      data-title="<?= strtolower($note['title']) ?>"
      data-status="<?= $note['is_read'] ? 'read' : 'unread' ?>"
      data-date="<?= strtotime($note['created_at']) ?>"
    >
      <div class="flex items-center gap-4">
        <input type="checkbox" name="selected_ids[]" value="<?= $note['id'] ?>" class="checkbox appearance-none h-5 w-5 border border-slate-500 rounded-md cursor-pointer checked:bg-teal-600 checked:border-teal-600 checked:ring-2 checked:ring-teal-600 checked:ring-offset-2 checked:shadow-lg checked:shadow-teal-500/50 transition-all duration-300 ease-in-out">

        <div class="flex-grow" onclick="openNotificationModal('<?= htmlspecialchars($note['title']) ?>', `<?= nl2br(htmlspecialchars($note['content'])) ?>`, <?= $note['id'] ?>, `<?= date('jS M Y, g:i a', strtotime($note['created_at'])) ?>`, `<?= nl2br(htmlspecialchars($note['mail_from'])) ?>`)">
          <div class="flex justify-between items-center mb-1">
            <h3 class="text-sm sm:text-base font-semibold text-teal-800 break-words">
              <?= htmlspecialchars($note['title']) ?>
            </h3>
            <span class="text-xs text-yellow-800 italic"><?= date('jS M Y, g:i a', strtotime($note['created_at'])) ?></span>
          </div>
          <div class="flex justify-between items-start gap-2 text-xs">
            <p class="flex-1"><?= substr($note['content'], 0, 80) . (strlen($note['content']) > 80 ? '...' : '') ?></p>
            <p class="flex items-center gap-1">
              <?php if ($note['is_read']): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="10" height="10" fill="currentColor" class="text-sky-800">
                  <path d="M64 208.1L256 65.9 448 208.1l0 47.4L289.5 373c-9.7 7.2-21.4 11-33.5 11s-23.8-3.9-33.5-11L64 255.5l0-47.4zM256 0c-12.1 0-23.8 3.9-33.5 11L25.9 156.7C9.6 168.8 0 187.8 0 208.1L0 448c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-239.9c0-20.3-9.6-39.4-25.9-51.4L289.5 11C279.8 3.9 268.1 0 256 0z"/>
                </svg>
                <span class="text-sky-800 font-semibold">Read</span>
              <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="10" height="10" fill="currentColor" class="text-teal-800">
                  <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/>
                </svg>
                <span class="text-teal-800 font-semibold">Unread</span>
              <?php endif; ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
