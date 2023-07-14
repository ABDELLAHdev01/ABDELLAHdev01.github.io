<?php
// Function to sanitize and validate input
function sanitize_input($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are filled and email is valid
    if (
        empty($_POST['name']) ||
        empty($_POST['subject']) ||
        empty($_POST['message']) ||
        !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    ) {
        http_response_code(400);
        echo "Please fill in all fields correctly.";
        exit();
    }

    // Sanitize and validate form input
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $m_subject = sanitize_input($_POST['subject']);
    $message = sanitize_input($_POST['message']);

    // Set recipient and email subject
    $to = "abdellahelghoulamdev@gmail.com"; // Change this email to your own
    $subject = "$m_subject: $name";

    // Prepare the email body
    $body = "You have received a new message from your website contact form.\n\n";
    $body .= "Here are the details:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Subject: $m_subject\n";
    $body .= "Message: $message\n";

    // Set email headers
    $headers = "From: $email" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/plain; charset=utf-8" . "\r\n";

    // Send the email using a reliable email sending library like PHPMailer or SwiftMailer
    require 'path/to/your/email/library'; // Replace with the actual path to the email library

    $mail = new PHPMailer(); // Replace with the appropriate class from the email library
    $mail->isSMTP();
    // Configure your SMTP settings here
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'abdellahelghoulamdev@gmail.com';
    $mail->Password = 'qzqowmyjhbcpbbuh';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Set email details
    $mail->setFrom($email);
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body = $body;

    // Send the email
    if ($mail->send()) {
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong. Please try again later.";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>