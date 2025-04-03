<?php
// Only set cookie if user hasn't rejected cookies
if (!isset($_COOKIE['cookie_consent']) || $_COOKIE['cookie_consent'] !== 'false') {
    setcookie('formSubmitted', time(), time() + 5, '/'); // 5-second cookie
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $appointment_type = htmlspecialchars($_POST['appointment_type']);

    // Get user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Get the referring page (page from which the form was submitted)
    $referring_page = $_SERVER['HTTP_REFERER'];

    // Prepare email content
    $to = "info@b1properties.ae"; // Change this to the recipient email
    $subject = "New Appointment Booking";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "
        <h2>New Appointment Request</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Date:</strong> $date</p>
        <p><strong>Time:</strong> $time</p>
        <p><strong>Type:</strong> $appointment_type</p>
        <p><strong>Message:</strong> $message</p>
        <p><strong>User IP:</strong> $user_ip</p>
        <p><strong>Submitted From:</strong> $referring_page</p>
    ";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        // Redirect to thankyou.html after successful form submission
        header("Location: ../thankyou.html"); // Adjust the path if needed
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "<script>alert('Error sending email. Please try again.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>