<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
// printo nje vektor
function printData($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

// dergo email
function sendEmail($text){

//Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'noreplyweb24@gmail.com';                     //SMTP username
        $mail->Password = 'ejbv bqbf rujq tfsk';                               //SMTP password
        $mail->SMTPSecure = 'tsl';            //Enable implicit TLS encryption
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('noreplyweb24@gmail.com', 'Ecommerce');
        $mail->addAddress('eduart.torba@fti.edu.al', 'Eduart Torba');     //Add a recipient
        $mail->addAddress('eduart.torba@gmal.com');               //Name is optional
        $mail->addReplyTo('programimw@gmail.com', 'Admin');
        $mail->addCC('programimw@gmail.com');
        $mail->addBCC('florida.dedenikaj@fti.edu.al');

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body = $text;

        $result = $mail->send();
        return true;
    } catch (Exception $e) {
//        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }

}


function getUserIp()
{
    if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]) && isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }

    return $ip;
}