<?php
// Incluir conexiones, clases, sesiones...
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../classes/User.php';

$db = new Database();
$pdo = $db->getConnection();
$userClass = new User($pdo);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicializar variables
$name = '';
$email = '';
$message = '';
$errorMessage = '';

// Cargar datos guardados en sesión (en caso de error al enviar)
if (isset($_SESSION['form_data'])) {
    $formData = $_SESSION['form_data'];
    $name = htmlspecialchars($formData['name'] ?? '');
    $email = htmlspecialchars($formData['email'] ?? '');
    $message = htmlspecialchars($formData['message'] ?? '');
    unset($_SESSION['form_data']); // Limpiar datos guardados

    if (isset($_SESSION['form_error'])) {
        $errorMessage = $_SESSION['form_error'];
        unset($_SESSION['form_error']);
    }
} 
// Si no hay datos en sesión y usuario está logueado, cargar datos de usuario
else if (isset($_SESSION['user_id'])) {
    $user = $userClass->findById((int)$_SESSION['user_id']);
    if ($user) {
        $name = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
        $email = htmlspecialchars($user['email']);
    }
}
?>

<!-- Mostrar mensaje de éxito -->
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="bg-green-100 text-green-800 p-4 mb-4 rounded">
        ✅ ¡Gracias por tu mensaje! Te responderemos pronto.
    </div>
<?php elseif (isset($_GET['success']) && $_GET['success'] == 0): ?>
    <div class="bg-red-100 text-red-800 p-4 mb-4 rounded">
        ❌ Ocurrió un error al enviar el mensaje. Por favor, inténtalo de nuevo.
    </div>
<?php endif; ?>

<!-- Mostrar mensaje de error de validación -->
<?php if ($errorMessage): ?>
    <div class="bg-red-100 text-red-800 p-4 mb-4 rounded">
        ⚠️ <?= $errorMessage ?>
    </div>
<?php endif; ?>

<form method="POST" action="includes/auth/process_contact.php" id="contactForm" class="login-form glow-border max-w-md mx-auto w-full">

    <div class="form-group mt-6">
        <label for="name" class="block mb-2">Nombre</label>
        <div class="relative">
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="cyber-input w-full pl-10" 
                required
                value="<?= $name ?>"
            >
            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>

    <!-- Correo -->
    <div class="form-group mt-4">
        <label for="email" class="block mb-2">Correo Electrónico</label>
        <div class="relative">
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="cyber-input w-full pl-10" 
                required
                value="<?= $email ?>"
            >
            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <i class="fas fa-envelope"></i>
            </span>
        </div>
    </div>

    <!-- Mensaje -->
    <div class="form-group mt-4">
        <label for="message" class="block mb-2">Mensaje</label>
        <div class="relative">
            <textarea 
                id="message" 
                name="message" 
                class="cyber-input w-full pl-10 pr-4 py-2" 
                rows="4" 
                required
            ><?= $message ?></textarea>
            <span class="absolute left-3 top-3 text-gray-400">
                <i class="fas fa-comment-alt"></i>
            </span>
        </div>
    </div>

    <!-- Botón de envío -->
    <button type="submit" class="cyber-btn w-full pulse-btn mt-6" id="contactButton">
        <i class="fas fa-paper-plane mr-2"></i> Enviar Mensaje
    </button>
</form>
