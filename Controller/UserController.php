<?php
// Include required files
include_once(__DIR__ . '/../Model/usermodel.php');
include_once(__DIR__ . '/../Controller/Mailer.php'); // Include Mailer class

class UserController
{
    private $db;

    public function __construct()
    {
        // Initialize the database connection
        $this->db = Database::getConnection();
    }

    // List all users
    public function listUsers()
    {
        $sql = "SELECT * FROM user";
        try {
            $users = $this->db->query($sql);
            return $users->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error fetching users: ' . $e->getMessage());
        }
    }

    // Add a new user
    public function addUser($user)
    {
        $sql = "INSERT INTO user (username, email, password, first_name, last_name, date_of_birth, role)
                VALUES (:username, :email, :password, :first_name, :last_name, :date_of_birth, :role)";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'date_of_birth' => $user->getDateOfBirth(),
                'role' => $user->getRole()
            ]);
        } catch (Exception $e) {
            die('Error adding user: ' . $e->getMessage());
        }
    }

    // Update an existing user
    public function updateUser($user, $id)
    {
        $sql = "UPDATE user SET 
                    username = :username,
                    email = :email,
                    password = :password,
                    first_name = :first_name,
                    last_name = :last_name,
                    date_of_birth = :date_of_birth,
                    role = :role
                WHERE iduser = :iduser";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([
                'iduser' => $id,
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'date_of_birth' => $user->getDateOfBirth(),
                'role' => $user->getRole()
            ]);
        } catch (Exception $e) {
            die('Error updating user: ' . $e->getMessage());
        }
    }

    // Delete a user by ID
    public function deleteUser($userId)
    {
        $sql = "DELETE FROM user WHERE iduser = :iduser";
        try {
            $query = $this->db->prepare($sql);
            $query->bindValue(':iduser', $userId, PDO::PARAM_INT);
            $query->execute();
            return true;
        } catch (Exception $e) {
            die('Error deleting user: ' . $e->getMessage());
        }
    }

    // Show a single user by ID
    public function showUser($id)
    {
        $sql = "SELECT * FROM user WHERE iduser = :iduser";
        try {
            $query = $this->db->prepare($sql);
            $query->bindValue(':iduser', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error fetching user: ' . $e->getMessage());
        }
    }

    // Get user data by username
    public function getUserDataByUsername($username)
    {
        $sql = "SELECT iduser, username, password FROM user WHERE username = :username";
        try {
            $query = $this->db->prepare($sql);
            $query->bindValue(':username', $username);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error fetching user data: ' . $e->getMessage());
        }
    }

    // **New Method: Get user data by ID**
    public function getUserData($userId)
    {
        $sql = "SELECT * FROM user WHERE iduser = :iduser";
        try {
            $query = $this->db->prepare($sql);
            $query->bindValue(':iduser', $userId, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error fetching user data by ID: ' . $e->getMessage());
        }
    }

    // Request Password Reset
    public function requestPasswordReset($email)
    {
        try {
            // Check if the user exists
            $sql = "SELECT iduser FROM user WHERE email = :email";
            $query = $this->db->prepare($sql);
            $query->execute(['email' => $email]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Generate reset token and expiration
                $resetToken = bin2hex(random_bytes(16));
                $resetTokenExpiration = (new DateTime())->modify('+1 hour')->format('Y-m-d H:i:s');

                // Save token in the database
                $updateSql = "UPDATE user SET reset_token = :reset_token, reset_token_expiration = :reset_token_expiration WHERE email = :email";
                $updateQuery = $this->db->prepare($updateSql);
                $updateQuery->execute([
                    'reset_token' => $resetToken,
                    'reset_token_expiration' => $resetTokenExpiration,
                    'email' => $email
                ]);

                // Send password reset email
                $resetLink = "http://yourwebsite.com/View/FrontOffice/auth/reset_password.php?token=" . urlencode($resetToken);
                if (Mailer::sendPasswordReset($email, $resetLink)) {
                    return "Password reset email sent successfully.";
                } else {
                    return "Failed to send password reset email.";
                }
            } else {
                return "No user found with the provided email.";
            }
        } catch (Exception $e) {
            die('Error handling password reset request: ' . $e->getMessage());
        }
    }

    // Reset Password
    public function resetPassword($token, $newPassword)
    {
        try {
            // Validate the token
            $sql = "SELECT email, reset_token_expiration FROM user WHERE reset_token = :reset_token";
            $query = $this->db->prepare($sql);
            $query->execute(['reset_token' => $token]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user && new DateTime($user['reset_token_expiration']) > new DateTime()) {
                // Update password
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $updateSql = "UPDATE user SET password = :password, reset_token = NULL, reset_token_expiration = NULL WHERE reset_token = :reset_token";
                $updateQuery = $this->db->prepare($updateSql);
                $updateQuery->execute([
                    'password' => $hashedPassword,
                    'reset_token' => $token
                ]);

                return "Password reset successful.";
            } else {
                return "Invalid or expired reset token.";
            }
        } catch (Exception $e) {
            die('Error resetting password: ' . $e->getMessage());
        }
    }
}
?>
