<?php

$email=$_GET['email'];
//Email variable encription to send out the link to further change the password. The encryption uses standart and easy variables from PHP:
  $token = $email;
  $cipher_method = 'aes-128-ctr';
  $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
  $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
  $hashedemail = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
  unset($token, $cipher_method, $enc_key, $enc_iv);
//End of email encrytion


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

//Variables we create from the url


try {
    //Server settings
    $mail->SMTPDebug = 1;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  											// Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'todolistapp100@gmail.com';              // SMTP username
    $mail->Password   = '100todolistapp';                        // SMTP password
    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('todolistapp100@gmail.com');
    $mail->addAddress($email);     					// Add a recipient

    // Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Instructions to change your password';
    $url = "http://83.165.235.220:5001/to_do_list_app/app/newpwd.php?request=changepassword&hashedemail=".$hashedemail;
    $mail->Body    = 'Hi there,<br/><br/>We have received your request to change your password. Please <b>click on the link below</b> for further instructions.<br/>Thank you.<br/><br/>'.$url.'<br/><br/>In case you have never requested this action, please ignore this message.';
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


header("Location: ../forgottenpwd.php?request=sent");
exit();
