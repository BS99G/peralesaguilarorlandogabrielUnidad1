<?php
declare(strict_types=1);

class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function userExists(string $username, string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        return (bool) $stmt->fetchColumn();
    }

    public function createUser(string $firstName, string $lastName, string $username, string $email, string $hashedPassword): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (first_name, last_name, username, email, password, created_at)
            VALUES (:first_name, :last_name, :username, :email, :password, NOW())
        ");
        return $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function findByToken(string $token): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE reset_token = :token LIMIT 1");
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function setPasswordResetToken(int $userId, string $token, string $expiresAt): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET reset_token = :token, reset_token_created_at = :created_at 
            WHERE id = :id
        ");
        return $stmt->execute([
            'token' => $token,
            'created_at' => $expiresAt,
            'id' => $userId
        ]);
    }

    public function updatePassword(int $userId, string $newPassword): bool
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        return $stmt->execute(['password' => $hashed, 'id' => $userId]);
    }

    public function clearPasswordResetToken(int $userId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET reset_token = NULL, reset_token_created_at = NULL WHERE id = :id");
        return $stmt->execute(['id' => $userId]);
    }

    public function verifyPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
    public function findByActivationToken(string $token): ?array
{
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE activation_token = :token LIMIT 1");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
}

public function activateUser(int $userId): bool
{
    $stmt = $this->pdo->prepare("
        UPDATE users 
        SET is_active = 1, activation_token = NULL 
        WHERE id = :id
    ");
    return $stmt->execute(['id' => $userId]);
}
public function findById(int $id): ?array
{
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
}

}
