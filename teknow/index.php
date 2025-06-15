<?php
session_start();

$page = $_GET['page'] ?? 'home';
$category = $_GET['category'] ?? null;

$validPages = ['home', 'about', 'contact', 'sitemap', 'help'];

if (!in_array($page, $validPages)) {
    include '404.php';
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'includes/layout/head.php'; ?>
</head>
<body>
    <?php include 'includes/partials/visual_effects.php'; ?>

    <div id="app">
        <?php include 'includes/layout/header.php'; ?>

        <main class="container mx-auto px-4 py-8">
            <?php
            switch ($page) {
                case 'home':
                    include 'includes/components/banner.php';
                    include 'includes/components/featured_games.php';
                    include 'includes/components/gaming_hardware.php';
                    include 'includes/components/recent_news.php';
                    break;

                case 'forum':
                    if (isset($_SESSION['user_id'])) {
                        include 'forum.php';
                    } else {
                        echo "<p class='text-white'>Debes iniciar sesión para acceder al foro.</p>";
                    }
                    break;

                case 'about':
                    include 'about.php';
                    break;

                case 'contact':
                    include 'contact.php';
                    break;

                case 'help':
                    include 'help.php';
                    break;

                case 'sitemap':
                    include 'includes/components/sitemap.php';
                    break;
            }
            ?>
        </main>

        <?php include 'includes/layout/footer.php'; ?>
    </div>
</body>
</html>
