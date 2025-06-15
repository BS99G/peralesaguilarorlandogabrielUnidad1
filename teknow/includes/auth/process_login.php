<?php
declare(strict_types=1);
session_start();

require_once '../db.php';
require_once '../classes/User.php';
require_once '../classes/Auth.php';

$db = new Database();
$pdo = $db->getConnection();

$userObj = new User($pdo);
$auth = new Auth($userObj);

$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Correo y contraseña son requeridos.']);
    exit;
}

$user = $userObj->findByEmail($email);


if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
    exit;
}

if (password_verify($password, $user['password'])) {
    $auth->login($email, $password);
    // Guardamos el username en sesión para mostrar en header
    $_SESSION['username'] = $user['username'];

    echo json_encode(['success' => true, 'message' => '¡Bienvenido de nuevo, ' . htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') . '!']);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
    exit;
}
