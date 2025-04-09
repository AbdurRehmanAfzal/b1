<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot trap
    if (!empty($_POST["website"])) {
        header('Content-Type: text/plain');
        die("bot_detected");
    }

    // Timing trap
    $form_load_time = isset($_POST["form_load_time"]) ? (int)$_POST["form_load_time"] : 0;
    $current_time = round(microtime(true) * 1000);
    if ($form_load_time === 0 || ($current_time - $form_load_time) < 3000) {
        header('Content-Type: text/plain');
        die("bot_detected");
    }

    // Sanitize inputs
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $appointment_type = htmlspecialchars($_POST['appointment_type']);
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $referring_page = $_SERVER['HTTP_REFERER'] ?? 'Direct access';

    // Prepare email
    $to = "info@b1properties.ae";
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

    if (mail($to, $subject, $body, $headers)) {
        header('Content-Type: text/plain');
        echo "success";
    } else {
        header('Content-Type: text/plain');
        echo "error";
    }
} else {
    header('Content-Type: text/plain');
    echo "error";
}
?>
