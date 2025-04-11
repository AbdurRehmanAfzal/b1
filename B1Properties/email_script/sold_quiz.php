<?php
// === Bot Protection ===

// Honeypot check
if (!empty($_POST["website"])) {
    header('Content-Type: text/plain');
    die("bot_detected");
}

// Timing check
$form_load_time = isset($_POST["form_load_time"]) ? (int)$_POST["form_load_time"] : 0;
$current_time = round(microtime(true) * 1000);

if ($form_load_time === 0 || ($current_time - $form_load_time) < 3000) {
    header('Content-Type: text/plain');
    die("bot_detected");
}

// === Input Validation & Sanitization ===
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"] ?? '');
    $phone = htmlspecialchars($_POST["phone"] ?? '');
    $email = htmlspecialchars($_POST["email"] ?? '');
    $meeting_preference = htmlspecialchars($_POST["meeting_preference"] ?? '');
    $budget = htmlspecialchars($_POST["budget"] ?? '');

    $user_ip = $_SERVER['REMOTE_ADDR'];
    $referring_page = $_SERVER['HTTP_REFERER'] ?? 'Unknown';

    // === Email Setup ===
    $to = "info@b1properties.ae";
    $subject = "New Property Inquiry";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $message = "
    <html>
    <head><title>New Property Inquiry</title></head>
    <body>
        <h2>New Inquiry Received</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Meeting Preference:</strong> $meeting_preference</p>
        <p><strong>Budget:</strong> $budget</p>
        <p><strong>User IP Address:</strong> $user_ip</p>
        <p><strong>Referring Page:</strong> $referring_page</p>
    </body>
    </html>";

    // === Send Email ===
    if (mail($to, $subject, $message, $headers)) {
        header('Content-Type: text/plain');
        die("success");
    } else {
        header('Content-Type: text/plain');
        die("error");
    }

} else {
    header('Content-Type: text/plain');
    echo "error";
}
?>
