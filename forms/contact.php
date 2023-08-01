<?php
$name = $_POST['name'];
$email  = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

 //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

// Requiring Config File
require './config.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();    //Send using SMTP
    $mail->Host = SMTP_HOST;    //Set the SMTP server to send through
    $mail->SMTPAuth =  true;    //Enable SMTP authentication
    $mail->Username   = SMTP_USERNAME;      //SMTP username
    $mail->Password   = SMTP_PASSWORD;      //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    //Enable implicit TLS encryption
    $mail->Port = 465;      //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom(SMTP_USERNAME, $name);
    $mail->addAddress(SMTP_ADDRESS, SMTP_NAME);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
    // header("Location: $url");

		$output['status']['code'] = "200";
		$output['status']['name'] = "ok";
		$output['status']['description'] = "success";




		echo json_encode($output);
} catch (Exception $e) {


		$output['status']['code'] = "500";
		$output['status']['name'] = "error";
		$output['status']['description'] = "something went wrong";
        echo json_encode($output);
}
?>
