<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="relative bg-opacity-80 bg-[#050505] border-b border-[#ff0033] shadow-lg shadow-[#ff0033]/20 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center mb-4 md:mb-0">
                <a href="index.php?page=home" class="flex items-center">
                    <div class="mr-3 logo-pulse">
                        <!-- SVG del logo -->
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 5L5 12.5V27.5L20 35L35 27.5V12.5L20 5Z" stroke="#ff0033" stroke-width="2" fill="none"/>
                            <path d="M20 5V20M20 20V35M20 20H35M20 20H5" stroke="#ff0033" stroke-width="2"/>
                            <circle cx="20" cy="20" r="5" fill="#ff0033" fill-opacity="0.5"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold glitch neon-text-red">NEXUS<span class="text-white">GAMING</span></h1>
                        <p class="text-xs text-gray-400">Tu portal gaming definitivo</p>
                    </div>
                </a>
            </div>

            <!-- Barra de búsqueda -->
            <div class="relative w-full md:w-1/3 mb-4 md:mb-0">
                <div class="relative">
                    <input type="text" placeholder="Buscar juegos, hardware, noticias..." class="cyber-input w-full pr-10" id="searchInput">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-[#ff0033]">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="search-results p-2" id="searchResults"></div>
            </div>

            <!-- Botones de acción o usuario -->
            <div class="flex items-center space-x-4 text-white">
                <?php if (isset($_SESSION['user_id'], $_SESSION['username'])): ?>
                    <span class="font-bold neon-text-red">
                        <i class="fas fa-user mr-1"></i>
                        <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <a href="logout.php" class="cyber-btn text-sm">
                        <i class="fas fa-sign-out-alt mr-1"></i> Cerrar sesión
                    </a>
                <?php else: ?>
                    <a href="login.php" class="cyber-btn text-sm">
                        <i class="fas fa-user mr-1"></i> Acceder
                    </a>
                    <a href="register.php" class="cyber-btn text-sm">
                        <i class="fas fa-user-plus mr-1"></i> Registrar
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Menú de navegación -->
        <nav class="mt-4">
            <ul class="flex flex-wrap justify-center md:justify-start space-x-1 md:space-x-4">
                <li><a href="index.php?page=home" class="px-3 py-2 menu-item text-white hover:text-[#ff0033]">Inicio</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="index.php?page=forum" class="px-3 py-2 menu-item text-white hover:text-[#ff0033]">Foro</a></li>
                <?php endif; ?>
                <li><a href="index.php?page=about" class="px-3 py-2 menu-item text-white hover:text-[#ff0033]">Nosotros</a></li>
                <li><a href="index.php?page=contact" class="px-3 py-2 menu-item text-white hover:text-[#ff0033]">Contacto</a></li>
                <li><a href="index.php?page=help" class="px-3 py-2 menu-item text-white hover:text-[#ff0033]">Ayuda</a></li>
                <li><a href="index.php?page=sitemap" class="px-3 py-2 menu-item text-white hover:text-[#ff0033]">Mapa del sitio</a></li>
            </ul>
        </nav>
    </div>
</header>
