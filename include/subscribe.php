<?php

/*-------------------------------------------------
    Form Processor for Email Subscription
---------------------------------------------------*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

/*-------------------------------------------------
    Receiver's Email
---------------------------------------------------*/

$toemail = 'info@shrishyamimpex.com'; // Your Email Address

/*-------------------------------------------------
    Sender's Email
---------------------------------------------------*/

$fromemail = array(
    'email' => 'info@shrishyamimpex.com', // Company's Email Address (preferably currently used Domain Name)
    'name' => 'Shri Shyam Impex' // Shri Shyam Impex
);

/*-------------------------------------------------
    PHPMailer Initialization
---------------------------------------------------*/

$mail = new PHPMailer();

/* Add your SMTP Codes after this Line */

// End of SMTP

/*-------------------------------------------------
    Form Messages
---------------------------------------------------*/

$message = array(
    'success' => 'You have successfully subscribed to our newsletter. Thank you!',
    'error' => 'Subscription could not be processed due to an unexpected error. Please try again later.',
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['widget-subscribe-form-email']) ? $_POST['widget-subscribe-form-email'] : '';

    // Check if the email field is not empty
    if (empty($email)) {
        echo '{ "alert": "error", "message": "Email field is required." }';
        exit;
    }

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '{ "alert": "error", "message": "Invalid email address." }';
        exit;
    }

    // Set email subject and body
    $mail->Subject = 'New Email Subscription';
    $mail->SetFrom($fromemail['email'], $fromemail['name']);
    $mail->AddAddress($toemail);

    $body = "Email: $email";

    $mail->MsgHTML($body);
    $mail->CharSet = "UTF-8";

    // Send the email
    $sendEmail = $mail->Send();

    if ($sendEmail == true) {
        echo '{ "alert": "success", "message": "' . $message['success'] . '" }';
    } else {
        echo '{ "alert": "error", "message": "' . $message['error'] . '<br><br><strong>Reason:</strong><br>' . $mail->ErrorInfo . '" }';
    }
} else {
    echo '{ "alert": "error", "message": "' . $message['error'] . '" }';
}
