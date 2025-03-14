<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $appointment_type = htmlspecialchars($_POST['appointment_type']); // Ensure this is passed from the form

    // Prepare email content
    $to = "abdurrehmanafzal786@gmail.com"; // Change this to the recipient email
    $subject = "New Tour Request";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
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