<?php
require_once __DIR__ . '/../Config.php';

class User {
    private ?int $iduser;
    private ?string $username;
    private ?string $email;
    private ?string $password;
    private ?string $first_name;
    private ?string $last_name;
    private ?string $date_of_birth;
    private ?string $role;
    private ?string $reset_token;
    private ?string $reset_token_expiration;

    public function __construct(
        ?int $iduser = null,
        ?string $username = null,
        ?string $email = null,
        ?string $password = null,
        ?string $first_name = null,
        ?string $last_name = null,
        ?string $date_of_birth = null,
        ?string $role = 'user',
        ?string $reset_token = null,
        ?string $reset_token_expiration = null
    ) {
        $this->iduser = $iduser;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->date_of_birth = $date_of_birth;
        $this->role = $role;
        $this->reset_token = $reset_token;
        $this->reset_token_expiration = $reset_token_expiration;
    }

    // Getters and Setters
    public function getIdUser(): ?int { return $this->iduser; }
    public function setIdUser(?int $iduser): void { $this->iduser = $iduser; }

    public function getUsername(): ?string { return $this->username; }
    public function setUsername(?string $username): void { $this->username = $username; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): void { $this->email = $email; }

    public function getPassword(): ?string { return $this->password; }
    public function setPassword(?string $password): void { $this->password = $password; }

    public function getFirstName(): ?string { return $this->first_name; }
    public function setFirstName(?string $first_name): void { $this->first_name = $first_name; }

    public function getLastName(): ?string { return $this->last_name; }
    public function setLastName(?string $last_name): void { $this->last_name = $last_name; }

    public function getDateOfBirth(): ?string { return $this->date_of_birth; }
    public function setDateOfBirth(?string $date_of_birth): void { $this->date_of_birth = $date_of_birth; }

    public function getRole(): ?string { return $this->role; }
    public function setRole(?string $role): void { $this->role = $role; }

    public function getResetToken(): ?string { return $this->reset_token; }
    public function setResetToken(?string $reset_token): void { $this->reset_token = $reset_token; }

    public function getResetTokenExpiration(): ?string { return $this->reset_token_expiration; }
    public function setResetTokenExpiration(?string $reset_token_expiration): void { $this->reset_token_expiration = $reset_token_expiration; }
}

class UserModel {
    private $db;

    public function __construct() {
        try {
            $this->db = Database::getConnection();
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Fetch user by username.
     */
    public function getUserByUsername(string $username): ?User {
        try {
            $query = $this->db->prepare("SELECT * FROM user WHERE username = :username LIMIT 1");
            $query->execute([':username' => $username]);
            $data = $query->fetch(PDO::FETCH_ASSOC);

            return $data ? new User(...array_values($data)) : null;
        } catch (PDOException $e) {
            error_log("Error fetching user by username: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch user by email.
     */
    public function getUserByEmail(string $email): ?array {
        try {
            // Prepare the query
            $query = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $query->execute([':email' => $email]);

            // Fetch the user data
            $data = $query->fetch(PDO::FETCH_ASSOC);

            // Return associative array or null if not found
            return $data ?: null;
        } catch (PDOException $e) {
            // Log the error
            error_log("Error fetching user by email: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Save reset token and expiration.
     */
    public function saveResetToken(string $email, string $token, string $expiration): bool {
        try {
            $query = $this->db->prepare(
                "UPDATE user SET reset_token = :token, reset_token_expiration = :expiration WHERE email = :email"
            );
            return $query->execute([
                ':token' => $token,
                ':expiration' => $expiration,
                ':email' => $email,
            ]);
        } catch (PDOException $e) {
            error_log("Error saving reset token: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Fetch user by reset token.
     */
    public function getUserByResetToken(string $token): ?User {
        try {
            $query = $this->db->prepare(
                "SELECT * FROM user WHERE reset_token = :token AND reset_token_expiration > NOW() LIMIT 1"
            );
            $query->execute([':token' => $token]);
            $data = $query->fetch(PDO::FETCH_ASSOC);

            return $data ? new User(...array_values($data)) : null;
        } catch (PDOException $e) {
            error_log("Error fetching user by reset token: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Clear reset token.
     */
    public function clearResetToken(int $iduser): bool {
        try {
            $query = $this->db->prepare(
                "UPDATE user SET reset_token = NULL, reset_token_expiration = NULL WHERE iduser = :iduser"
            );
            return $query->execute([':iduser' => $iduser]);
        } catch (PDOException $e) {
            error_log("Error clearing reset token: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update user password.
     */
    public function updatePassword(int $iduser, string $newPassword): bool {
        try {
            $query = $this->db->prepare("UPDATE user SET password = :password WHERE iduser = :iduser");
            return $query->execute([
                ':password' => password_hash($newPassword, PASSWORD_DEFAULT),
                ':iduser' => $iduser,
            ]);
        } catch (PDOException $e) {
            error_log("Error updating password: " . $e->getMessage());
            return false;
        }
    }
}
