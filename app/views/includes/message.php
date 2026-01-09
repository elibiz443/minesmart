<?php if ($message): ?>
  <div id="messageModal" class="p-4 text-sm <?php echo $message['type'] === 'success' ? 'text-green-800 bg-green-100 border-l border-y border-green-800' : 'text-red-800 border-l border-y border-red-800 bg-red-100'; ?> rounded-l-xl fixed top-20 right-0 z-[99999] transition-all duration-500 ease-in-out" role="alert">
    <?php echo htmlspecialchars($message['text'], ENT_QUOTES, 'UTF-8'); ?>
  </div>
<?php endif; ?>
