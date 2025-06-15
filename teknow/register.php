<?php
declare(strict_types=1);
session_start();

// Si se envía el formulario (POST), procesar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/auth/process_register.php';
}

// Si no es POST o después de procesar, mostrar el formulario con diseño
$successMessage = $_SESSION['register_success'] ?? '';
$errorMessage = $_SESSION['register_error'] ?? '';
unset($_SESSION['register_success'], $_SESSION['register_error']);
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
                    <h2 class="text-3xl md:text-4xl font-bold neon-text-red">CREAR CUENTA</h2>
                    <div class="w-24 h-1 bg-[#ff0033] mx-auto mt-4"></div>
                </div>

                <?php include 'includes/helpers/flash_messages.php'; ?>
                <?php include 'includes/auth/register_form.php'; ?>
            </div>
        </main>

        <?php include 'includes/layout/footer.php'; ?>
    </div>

    <script src="assets/js/register.js"></script>
</body>
</html>
