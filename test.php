<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'phanxuanvinh4592@gmail.com';                     //SMTP username
        $mail->Password   = 'aqts whay qrhl mxql';                                //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

        //Recipients
        $mail->setFrom('anhtai22042004@gmail.com', 'Admin');
        $mail->addAddress('anhtai22042004@gmail.com', 'Admin');     //Add a recipient

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Pass Code';
        $mail->Body    = '<b>This is your passcode</b>';

        // lấy code bất kì còn hạn
        $mail->Body    = '<b>test</b>';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>