<?php
// file: controllers/SendEmail.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require dirname(__DIR__) . '/vendor/autoload.php';

function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fatihabdurahman28@gmail.com'; // Ganti dengan email Gmail Anda
        $mail->Password = 'urqv zusx dwwq fjuh'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Pengaturan email
        $mail->setFrom('fatihabdurahman28@gmail.com', 'Post Development'); // Ganti dengan nama Anda
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Kirim email
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email tidak terkirim. Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
