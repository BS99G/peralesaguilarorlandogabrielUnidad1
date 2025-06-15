<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../../php_errors.log');
error_reporting(E_ALL);

header('Content-Type: application/json');
ob_start();

require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../classes/User.php';

$vendorAutoload = __DIR__ . '/../../vendor/autoload.php';
if (!file_exists($vendorAutoload)) {
    error_log("autoload.php no encontrado");
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor.']);
    exit;
}
require_once $vendorAutoload;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    // Obtener datos JSON
    $data = json_decode(file_get_contents('php://input'), true);
    $email = trim($data['recoveryEmail'] ?? '');

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Correo inválido.']);
        exit;
    }

    // Crear DB, User y buscar usuario
    $db = new Database();
    $pdo = $db->getConnection();
    $user = new User($pdo);

    $userData = $user->findByEmail($email);

    if (!$userData) {
        ob_end_clean();
        echo json_encode(['success' => true, 'message' => 'Si el correo existe en nuestra base de datos, pronto recibirás instrucciones.']);
        exit;
    }

    // Generar token
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', time() + 3600);
    $user->setPasswordResetToken((int)$userData['id'], $token, $expires);

    try {
    $user->setPasswordResetToken((int)$userData['id'], $token, $expires);
    } catch (Throwable $e) {
        error_log('Error al guardar token en la base de datos: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al guardar token.']);
        exit;
    }

    // Detectar si estamos en local o en producción
    function getBaseUrl(): string {
        if (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'localhost')) {
            return 'http://localhost/teknow';
        } else {
            return 'https://nexusgaming.com';
        }
    }


    $resetLink = getBaseUrl() . "/reset_password.php?token=" . urlencode($token);

    // Configurar y enviar correo
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'nexusgamingsuppo@gmail.com';
    $mail->Password = 'konr iylh qmtm fehw';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('nexusgamingsuppo@gmail.com', 'Nexus Gaming');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Recupera tu contraseña - Nexus Gaming';
    $mail->Body = "
        <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #000000; padding: 20px; font-family: Arial, sans-serif;'>
        <tr>
            <td>
            <table width='600' align='center' cellpadding='0' cellspacing='0' style='background-color: #111111; color: #ffffff; border-radius: 8px; padding: 30px;'>
                <tr>
                <td style='text-align: center; padding-bottom: 20px;'>
                    <h1 style='color: #ff0033; margin: 0; font-size: 28px;'>🔥 Nexus Gaming 🔥</h1>
                    <p style='color: #cccccc; font-size: 16px;'>Recupera tu acceso</p>
                </td>
                </tr>
                <tr>
                <td style='font-size: 16px; color: #eeeeee;'>
                    <p>Hola <strong style='color: #ff0033;'>{$userData['username']}</strong>,</p>
                    <p>Recibimos una solicitud para restablecer tu contraseña.</p>
                    <p style='text-align: center; margin: 30px 0;'>
                    <a href='$resetLink' style='background-color: #ff0033; color: #000000; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;'>
                        🔒 Restablecer Contraseña
                    </a>
                    </p>
                    <p>Este enlace expirará en 1 hora.</p>
                    <p>Si no realizaste esta solicitud, puedes ignorar este mensaje.</p>
                </td>
                </tr>
                <tr>
                <td style='text-align: center; color: #666666; font-size: 12px; padding-top: 30px;'>
                    &copy; " . date('Y') . " Nexus Gaming. Todos los derechos reservados.
                </td>
                </tr>
            </table>
            </td>
        </tr>
        </table>
        ";


    $mail->send();
    error_log("Correo de recuperación enviado correctamente a $email");


    ob_end_clean();
    echo json_encode(['success' => true, 'message' => 'Si el correo existe en nuestra base de datos, pronto recibirás instrucciones.']);
    exit;

} catch (Throwable $e) {
    error_log('Error inesperado en recuperación: ' . $e->getMessage());
    http_response_code(500);
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor.']);
    exit;
}
