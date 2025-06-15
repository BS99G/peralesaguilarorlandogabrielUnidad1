<?php
session_start();
require_once '../db.php';
require_once '../classes/User.php';

$input = json_decode(file_get_contents("php://input"), true);
$token = $input['token'] ?? '';
$password = $input['password'] ?? '';
$confirmPassword = $input['confirmPassword'] ?? '';

if (empty($token) || empty($password) || empty($confirmPassword)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

if ($password !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden.']);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 8 caracteres.']);
    exit;
}

$db = new Database();
$pdo = $db->getConnection();
$user = new User($pdo);

$userData = $user->findByToken($token);
if (!$userData || (strtotime($userData['reset_token_created_at']) + 3600) < time()) {
    echo json_encode(['success' => false, 'message' => 'Token inválido o expirado.']);
    exit;
}

$user->updatePassword((int)$userData['id'], $password);
$user->clearPasswordResetToken((int)$userData['id']);

// Iniciar sesión automáticamente
$_SESSION['user_id'] = $userData['id'];
$_SESSION['username'] = $userData['username'];
$_SESSION['email'] = $userData['email'];

echo json_encode(['success' => true, 'redirect' => '/teknow/index.php?page=home']);

exit;
