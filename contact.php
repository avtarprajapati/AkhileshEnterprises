<?php
// Google reCAPTCHA secret key
$secretKey = '6Lc_9z0rAAAAAJngI5RCeSeFCI43zquguDvjBEgq'; // Replace with your actual secret key
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

// Verify the reCAPTCHA response
$verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
$responseData = json_decode($verifyResponse);

// If reCAPTCHA passes with good score
if ($responseData->success && $responseData->score >= 0.5) {
    // Collect form data
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Email settings
    $to = 'akhileshenterprises545@gmail.com'; // ✅ Replace with your real admin email
    $subject = "New Appointment Request from $name";

    $emailBody = "
    <h2>Enquiry Request</h2>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Phone:</strong> $phone</p>
    <p><strong>Message:</strong> $message</p>
    ";

    // Email headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Enquiry Form <noreply@example.com>\r\n"; // ✅ Use your domain email

    // Send the email
    if (mail($to, $subject, $emailBody, $headers)) {
        echo "Success: Enquiry sent successfully!";
    } else {
        echo "Error: Failed to send email. Please try again.";
    }

} else {
    // Failed reCAPTCHA
    echo "reCAPTCHA verification failed. Please refresh and try again.";
}
?>
