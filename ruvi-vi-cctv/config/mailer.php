<?php
function send_email(string $to, string $subject, string $html): bool {
    $username = getenv('SMTP_USERNAME') ?: 'aanugerahahmad27@gmail.com';
    $password = getenv('SMTP_PASSWORD') ?: 'patrphcwoiaszier';
    $fromName = getenv('SMTP_FROM_NAME') ?: 'RU VI CCTV';
    $from = $username;

    // Try PHPMailer via Composer if available
    $vendorAutoload = dirname(__DIR__) . '/vendor/autoload.php';
    if (is_file($vendorAutoload)) {
        require_once $vendorAutoload;
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom($from, $fromName);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;
            $mail->send();
            return true;
        } catch (Throwable $e) {
            // fall through to mail()
        }
    }

    // Fallback to mail()
    $headers = "MIME-Version: 1.0\r\n" .
               "Content-type: text/html; charset=UTF-8\r\n" .
               "From: {$fromName} <{$from}>\r\n";
    return @mail($to, $subject, $html, $headers);
}

