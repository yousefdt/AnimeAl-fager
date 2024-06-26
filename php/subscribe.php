<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php/PHPMailer-master/src/Exception.php';
require 'php/PHPMailer-master/src/PHPMailer.php';
require 'php/PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail = new PHPMailer(true);
        try {
            // إعدادات SMTP لبريد Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '';  // عنوان بريدك الإلكتروني
            $mail->Password = '';  // كلمة المرور الخاصة ببريدك الإلكتروني
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // إعدادات البريد الإلكتروني الذي سيتم إرساله إلى المسؤول
            $mail->setFrom('', 'Anime Al-fager');
            $mail->addAddress('');
            $mail->Subject = 'New Subscription';
            $mail->Body    = '
                <div style="background-color: #0b0b0b; padding: 20px; font-family: Arial, sans-serif; color: #ffffff;">
                    <h2 style="color: #ffaa00;">Hello,</h2>
                    <p>You have a new subscriber to your newsletter:</p>
                    <p>Email: <strong>' . $email . '</strong></p>
                    <p>Best regards,<br>Anime Al-fager</p>
                </div>';
            $mail->isHTML(true);
            $mail->send();

            // إعدادات البريد الإلكتروني الذي سيتم إرساله إلى المستخدم
            $mail->clearAddresses();
            $mail->addAddress($email);
            $mail->Subject = 'Thank you for subscribing to Anime Al-fager newsletter!';
            $mail->Body    = '
                <div style="background-color: #0b0b0b; padding: 20px; font-family: Arial, sans-serif; color: #ffffff; text-align: center;">
                    <h2 style="color: #ffaa00;">Anime Al-fager</h2>
                    <img src="cid:Subscribed" alt="Subscribed" style="display:block; margin: 0 auto; max-width: 100%; height: auto; border: none;"/>
                    <h2 style="color: #ffaa00;">Hello,</h2>
                    <p>Thank you for subscribing to our newsletter! We will keep you updated with the latest news and offers.</p>
                    <p>Best regards,<br>Anime Al-fager</p>
                </div>';
            $mail->isHTML(true);
            
            // تضمين الصورة
            $mail->AddEmbeddedImage('Subscribed.png', 'Subscribed');

            $mail->send();

            echo 'Subscription successful.';
        } catch (Exception $e) {
            echo "There was a problem with the subscription. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Invalid email address.';
    }
} else {
    echo 'Invalid request.';
}
?>