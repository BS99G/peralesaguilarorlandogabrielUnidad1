<?php
declare(strict_types=1);
require_once 'includes/db.php';
require_once 'includes/classes/User.php';

$token = $_GET['token'] ?? '';
$token = trim($token);
$error = '';
$validToken = false;

$db = new Database();
$pdo = $db->getConnection();
$user = new User($pdo);

if (!$token) {
    $error = 'Token no proporcionado.';
} else {
    $userData = $user->findByToken($token);
    if (!$userData) {
        $error = 'El enlace de recuperación ha expirado o no es válido.';
    } else {
        $tokenCreated = strtotime($userData['reset_token_created_at']);
        if (($tokenCreated + 3600) < time()) {
            $error = 'El enlace de recuperación ha expirado o no es válido.';
        } else {
            $validToken = true;
        }
    }
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
                    <h2 class="text-3xl md:text-4xl font-bold neon-text-red">RESTABLECER CONTRASEÑA</h2>
                    <div class="w-24 h-1 bg-[#ff0033] mx-auto mt-4"></div>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error text-center mb-6">
                        ⚠️ <?= htmlspecialchars($error) ?>
                    </div>
                <?php elseif ($validToken): ?>
                    <?php include 'includes/auth/reset_password_form.php'; ?>
                <?php endif; ?>
            </div>
        </main>

        <?php include 'includes/layout/footer.php'; ?>
    </div>

    <script src="assets/js/reset_password.js"></script>
</body>
</html>
