<!-- Header -->
<?php
  // Count unread alerts
  $unreadStmt = $pdo->prepare("SELECT COUNT(*) FROM alerts WHERE user_id = :user_id AND is_read = 0");
  $unreadStmt->execute([':user_id' => $currentUser['id']]);
  $unreadCount = (int) $unreadStmt->fetchColumn();
?>

<header id="headerContent" class="fixed z-[9999] w-[calc(100%-12rem)] ml-auto glass-bg-color border-b border-slate-600 py-1.5 px-5 flex justify-between items-center text-white transition-all duration-500 ease-in-out transform translate-y-0 opacity-100">
  <div id="welcomeMessage" class="text-sm md:text-md leading-tight pl-2">
    Welcome, <span class="font-semibold text-teal-300"><?php echo htmlspecialchars($currentUser['full_name'] ?? 'Guest'); ?></span>
  </div>
  
  <div class="flex text-center items-center gap-x-4">
    <div class="flex gap-5 md:gap-10">
      <button onclick="location.href='<?php echo ROOT_URL; ?>/alerts'" class="hover:scale-[125%] relative cursor-pointer flex items-center justify-center transition-all duration-500 ease-in-out">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="20" height="20" fill="currentColor">
          <path d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416l384 0c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8l0-18.8c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/>
        </svg>
        <?php if ($unreadCount > 0): ?>
          <div class="absolute -top-1 -right-1 size-[1.1rem] border border-white bg-red-500 rounded-full shadow text-white text-[0.6rem] flex items-center justify-center">
            <?= $unreadCount ?>
          </div>
        <?php endif; ?>
      </button>
    </div>

    <div class="relative">
      <!-- Avatar Button -->
      <div id="avatarButton" class="cursor-pointer relative bg-neutral-300 size-[2.5rem] shadow-lg shadow-neutral-900 border-2 border-white rounded-full hover:scale-[115%] transition-all duration-500 ease-in-out">
        <img src="<?php echo !empty($currentUser['prof_pic']) ? ROOT_URL . htmlspecialchars($currentUser['prof_pic']) : ROOT_URL . '/assets/images/user.webp'; ?>" alt="Profile Picture" class="size-full rounded-full object-cover border-2 border-cyan-500">
        <span class="absolute -bottom-1 -right-1 inline-flex size-[0.8rem] animate-ping rounded-full bg-teal-400 opacity-75"></span>
        <span class="absolute -bottom-1 -right-1 inline-flex size-3 rounded-full bg-teal-500"></span>
      </div>

      <!-- Dropdown Menu -->
      <div id="dropdownMenu" class="absolute -right-2 -mt-1 w-40 bg-white rounded-md opacity-0 scale-95 transform origin-top-right shadow-lg shadow-neutral-900 overflow-hidden border-t-4 border-x border-gray-200 transition-all duration-700 ease-in-out hidden">
        <ul class="text-neutral-700 text-sm divide-y divide-neutral-300">
          <li>
            <p class="py-2 text-white font-semibold bg-gradient-to-r from-sky-600 via-sky-800 to-slate-900">
              <?php echo htmlspecialchars($currentUser['full_name']); ?>
            </p>
          </li>

          <li>
            <a href="#" class="block py-2 hover:bg-neutral-300 transition-all duration-300 ease-in-out">
              👤&emsp;View Profile
            </a>
          </li>

          <li>
            <a href="#" class="block py-2 hover:bg-neutral-300 transition-all duration-300 ease-in-out">
              🛠️&emsp;Account Settings
            </a>
          </li>

          <li>
            <button onclick="location.href='<?php echo ROOT_URL; ?>/app/controllers/auth/logout.php'" class="group w-full cursor-pointer block py-2 flex items-center justify-center hover:bg-neutral-300 transition-all duration-300 ease-in-out">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="14" height="14" fill="currentColor" class="group-hover:translate-x-[4.2rem] transition-all duration-500 ease-in-out">
                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
              </svg>
              <span class="group-hover:-translate-x-8 transition-all duration-500 ease-in-out">&emsp;Logout</span>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>

<!-- Show Sidebar, Button -->
<button id="showBtn" class="hidden fixed z-[9999] left-5 top-[0.8rem] glass-bg-color shadow-md shadow-slate-800 p-1.5 rounded-md hover:scale-110 text-white hover:text-teal-200 cursor-pointer transition-all duration-500 ease-in-out">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="17" height="17" fill="currentColor">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
</button>

<!-- Toggle Header, Button -->
<button id="toggle-header" class="cursor-pointer fixed z-[9999] top-[1.8rem] right-[8rem] size-8 bg-cyan-100 text-slate-800 shadow-md shadow-slate-800 rounded-full flex items-center justify-center hover:scale-110 hover:bg-cyan-200 hover:shadow-lg transition-all duration-500 ease-in-out">
  <svg xmlns="http://www.w3.org/2000/svg" id="angle-up-svg" viewBox="0 0 320 512" width="14" height="14" fill="currentColor" class="transition-transform duration-500 ease-in-out">
    <path d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8l256 0c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/>
  </svg>
</button>
