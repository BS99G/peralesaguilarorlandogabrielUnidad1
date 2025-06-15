<?php
declare(strict_types=1);

require_once 'includes/db.php';
require_once 'includes/classes/User.php';

$db = new Database();
$pdo = $db->getConnection();

$userObj = new User($pdo);

$token = $_GET['token'] ?? '';

if (!$token) {
    echo "Token no proporcionado.";
    exit;
}

// Buscar usuario por token
$user = $userObj->findByActivationToken($token);

if (!$user) {
    echo "Token inválido o cuenta ya activada.";
    exit;
}

// Activar usuario
if ($userObj->activateUser((int)$user['id'])) {
    echo "Cuenta activada correctamente. Ya puedes iniciar sesión.";
} else {
    echo "Error al activar la cuenta. Intenta más tarde.";
}
