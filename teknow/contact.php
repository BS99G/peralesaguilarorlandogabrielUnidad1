<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$name = $email = $message = '';

if (isset($_SESSION['form_data'])) {
    $name = htmlspecialchars($_SESSION['form_data']['name'] ?? '');
    $email = htmlspecialchars($_SESSION['form_data']['email'] ?? '');
    $message = htmlspecialchars($_SESSION['form_data']['message'] ?? '');
    unset($_SESSION['form_data']);
}

if (isset($_SESSION['form_error'])) {
    echo '<div class="bg-red-100 text-red-800 p-4 mb-4 rounded">' . $_SESSION['form_error'] . '</div>';
    unset($_SESSION['form_error']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'includes/layout/head.php'; ?>
</head>
<body>
    <?php include 'includes/partials/visual_effects.php'; ?>


        <main class="container mx-auto px-4 py-8">
            <?php include 'includes/auth/contact_form.php'; ?>
        </main>


</body>
</html>