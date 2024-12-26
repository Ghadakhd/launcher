<?php
class Mailer {
    public static function sendPasswordReset($email, $resetLink) {
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n\n" . $resetLink;
        $headers = "From: no-reply@yourwebsite.com";

        return mail($email, $subject, $message, $headers);
    }
}
?>
