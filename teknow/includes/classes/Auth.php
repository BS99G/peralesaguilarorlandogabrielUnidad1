<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Auth {
    private User $user;

    public function __construct(User $user) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->user = $user;
    }

    public function register(string $firstName, string $lastName, string $username, string $email, string $password): array {
        if ($this->user->userExists($username, $email)) {
            return ['success' => false, 'message' => 'El nombre de usuario o correo ya está en uso.'];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($this->user->createUser($firstName, $lastName, $username, $email, $hashedPassword)) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'No se pudo registrar al usuario.'];
    }

    public function login(string $email, string $password): array {
        $user = $this->user->findByEmail($email);
        if (!$user) {
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];
        }

        if (!$this->user->verifyPassword($password, $user['password'])) {
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];
        }

        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['username'] = $user['username'];

        return ['success' => true];
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();
    }

    public function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }

    public function getUserId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }

    public function sendPasswordResetEmail(string $email): bool {
        $user = $this->user->findByEmail($email);
        if (!$user) {
            return false; // Seguridad: no revelar si el correo no existe
        }

        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->user->setPasswordResetToken((int)$user['id'], $token, $expires);

        $resetLink = "https://nexusgaming.com/reset_password.php?token=" . urlencode($token);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nexusgamingsuppo@gmail.com'; // Tu correo
            $mail->Password = 'konr iylh qmtm fehw';         // App Password de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('nexusgamingsuppo@gmail.com', 'Nexus Gaming');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña - Nexus Gaming';
            $mail->Body = "
                <h1>¿Olvidaste tu contraseña?</h1>
                <p>Hola <strong>{$user['username']}</strong>,</p>
                <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                <p><a href='$resetLink'>$resetLink</a></p>
                <p>Este enlace es válido por una hora.</p>
                <p>Si no solicitaste esto, puedes ignorar este mensaje.</p>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar correo de recuperación: " . $mail->ErrorInfo);
            return false;
        }
    }
}
