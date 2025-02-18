<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $time = $_POST['time']; // Ensure the form sends the selected time properly
    $name = $_POST['text'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $appointment_type = $_POST['appointment_type'];

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
    ";

    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Appointment booked successfully!'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Error sending email. Please try again.'); window.history.back();</script>";
    }
}
?>