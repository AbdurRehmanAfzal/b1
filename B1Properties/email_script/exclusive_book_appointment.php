<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $appointment_type = htmlspecialchars($_POST['appointment_type']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error";
        exit;
    }

    // Get user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Get the referring page (page from which the form was submitted)
    $referring_page = $_SERVER['HTTP_REFERER'] ?? 'Direct access or unknown';

    // Prepare email content
    $to = "info@b1properties.ae"; // Change this to the recipient email
    $subject = "New Book Appointment Request";
    $headers = "From: no-reply@example.com\r\n"; // Replace with a valid sender email
    $headers .= "Reply-To: $email\r\n"; // Add user's email as the reply-to address
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "
        <h2>New Tour Request</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Date:</strong> $date</p>
        <p><strong>Time:</strong> $time</p>
        <p><strong>Appointment Type:</strong> $appointment_type</p>
        <p><strong>Message:</strong> $message</p>
        <p><strong>User IP Address:</strong> $user_ip</p>
        <p><strong>Referring Page:</strong> $referring_page</p>
    ";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "success"; // Return success response
    } else {
        echo "error"; // Return error response
    }
} else {
    echo "error"; // Return error response for invalid requests
}
?>