<?php
// Google reCAPTCHA secret key
$secretKey = '6Lc_9z0rAAAAAJngI5RCeSeFCI43zquguDvjBEgq';
$recaptchaResponse = $_POST['g-recaptcha-response'];

// Verify the reCAPTCHA response
$verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
$responseData = json_decode($verifyResponse);

// If reCAPTCHA passes with good score
if ($responseData->success && $responseData->score >= 0.5) {
    // Collect form data
    $service = htmlspecialchars($_POST['service']);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $duration = htmlspecialchars($_POST['duration']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Email settings
    $to = 'akhileshenterprises545@gmail.com';  // 📧 Change this to your actual admin email
    $subject = "New Appointment Request from $name";

    $emailBody = "
    <h2>New Appointment Request</h2>
    <p><strong>Service:</strong> $service</p>
    <p><strong>Date:</strong> $date</p>
    <p><strong>Time:</strong> $time</p>
    <p><strong>Duration:</strong> $duration</p>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Phone:</strong> $phone</p>
    <p><strong>Message:</strong> $message</p>
    ";

    // Email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Appointment Form <akhileshenterprises545@gmail.com>" . "\r\n"; // 🛠 Replace with your domain

    // Send the email
    if (mail($to, $subject, $emailBody, $headers)) {
        echo "Success: Appointment request sent successfully!";
    } else {
        echo "Error: Failed to send email. Please try again.";
    }

} else {
    // Failed reCAPTCHA
    echo "reCAPTCHA verification failed. Please refresh and try again.";
}
?>
