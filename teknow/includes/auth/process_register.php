<?php
declare(strict_types=1);
ini_set('display_errors', '1');
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Auth.php';

// Obtener datos del cuerpo JSON
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
    exit;
}

// Validación reCAPTCHA
$recaptchaToken = $data['recaptchaToken'] ?? '';

$secretKey = '';

// Verificar el token con Google
$verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
$response = file_get_contents($verifyUrl . '?secret=' . $secretKey . '&response=' . $recaptchaToken);
$responseData = json_decode($response);

if (!$responseData->success || $responseData->score < 0.5) {
    // No pasa validación reCAPTCHA
    echo json_encode(['success' => false, 'message' => 'reCAPTCHA no válido. Intenta de nuevo.']);
    exit;
}


// Continuar con validaciones normales
$firstName = trim($data['firstName'] ?? '');
$lastName = trim($data['lastName'] ?? '');
$username = trim($data['username'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$confirmPassword = $data['confirmPassword'] ?? '';

// Validaciones del servidor
if (!$firstName || !$lastName || !$username || !$email || !$password || !$confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Correo electrónico inválido.']);
    exit;
}
if ($password !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden.']);
    exit;
}
if (
    strlen($password) < 8 ||
    !preg_match('/[A-Z]/', $password) ||
    !preg_match('/[a-z]/', $password) ||
    !preg_match('/[0-9]/', $password) ||
    !preg_match('/[!@#$%^&*]/', $password)
) {
    echo json_encode(['success' => false, 'message' => 'La contraseña no cumple los requisitos.']);
    exit;
}

// Instancias
$db = new Database();
$pdo = $db->getConnection();
$user = new User($pdo);
$auth = new Auth($user);

// Registrar usuario
$result = $auth->register($firstName, $lastName, $username, $email, $password);

if ($result['success']) {
    echo json_encode(['success' => true, 'message' => 'Registro exitoso. Ya puedes iniciar sesión.']);
} else {
    echo json_encode(['success' => false, 'message' => $result['message'] ?? 'Error inesperado.']);
}
