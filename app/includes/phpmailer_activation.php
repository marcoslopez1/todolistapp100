<?php

//url we receive from singup.inc.php
//phpmailer_activation.php?action=sendemailtoactivate&email=".$email."&username=".$username

//url we send to users:
//http://83.165.235.220:5001/to_do_list_app/app/includes/activation.inc.php?activation=useractivation&username=marcos

$email=$_GET['email'];
$username=$_GET['username'];

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
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
    $mail->addBCC('brave1citizen@gmail.com'); //Copia oculta


    // Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Activate your user';
    $url = "http://83.165.235.220:5001/to_do_list_app/app/includes/activation.inc.php?activation=useractivation&username=".$username;
    $mail->Body    = 'Hi '.$username.',<br/><br/>We have received your request to create a new user.<br/>Please, <b>click on the next link to activate your account</b>.<br/>Thank you.<br/><br/>'.$url.'<br/><br/>In case you have never requested this action, please ignore this message.';
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

//now we redirect to the signup page showing a sucess message to the user, let him/her know we have created successfully the account
header("Location: ../signup.php?signup=success");
exit();
