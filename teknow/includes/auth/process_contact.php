<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // Ajusta la ruta según tu estructura
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Auth.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

$db = new Database();
$pdo = $db->getConnection();
$user = new User($pdo);
$auth = new Auth($user);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

if ($auth->isLoggedIn()) {
    $userId = $auth->getUserId();
    $userData = $user->findById($userId);
    if (!$userData) {
        http_response_code(400);
        exit('Usuario no encontrado');
    }
    $name = $userData['first_name'] . ' ' . $userData['last_name'];
    $email = $userData['email'];
} else {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if (!$name || !$email) {
        http_response_code(400);
        exit('Nombre y correo son obligatorios');
    }
}

$message = trim($_POST['message'] ?? '');
if (!$message) {
    http_response_code(400);
    exit('El mensaje es obligatorio');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('Correo inválido');
}

$to = 'nexusgamingsuppo@gmail.com';
$subject = 'Nuevo mensaje de contacto';
$body = "Nombre: $name\nEmail: $email\nMensaje:\n$message";

$mail = new PHPMailer(true);

try {
    // Configuración SMTP para Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'nexusgamingsuppo@gmail.com'; 
    $mail->Password   = 'konr iylh qmtm fehw';     
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remitente y destinatario
    $mail->setFrom($email, $name);
    $mail->addAddress($to);

    // Contenido
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->isHTML(false);

    $mail->send();

    header('Location: /teknow/index.php?page=contact&success=1');
    exit;
} catch (Exception $e) {
    error_log("Error al enviar correo: {$mail->ErrorInfo}");
    header('Location: /contact.php?success=0');
    exit;
}
