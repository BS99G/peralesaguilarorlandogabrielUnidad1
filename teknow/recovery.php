<?php
$page = $_GET['page'] ?? 'recovery';
$validPages = ['recovery'];

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

    <div class="min-h-screen flex flex-col">
        <?php include 'includes/layout/header.php'; ?>

        <main class="flex-grow py-12">
            <div class="container mx-auto px-4">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold neon-text-red">RECUPERAR CONTRASEÑA</h2>
                    <div class="w-24 h-1 bg-[#ff0033] mx-auto mt-4"></div>
                </div>

                <!-- Formulario modularizado -->
                <?php include 'includes/auth/recovery_form.php'; ?>
            </div>
        </main>

        <?php include 'includes/layout/footer.php'; ?>
    </div>
</body>
</html>