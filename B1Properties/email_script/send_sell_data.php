<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot check
    if (!empty($_POST["website"])) {
        header('Content-Type: text/plain');
        die("bot_detected");
    }
    

    // Time check: submitted too quickly
    $form_load_time = isset($_POST["form_load_time"]) ? (int)$_POST["form_load_time"] : 0;
    $current_time = round(microtime(true) * 1000);

    if ($form_load_time === 0 || ($current_time - $form_load_time) < 3000) {
        header('Content-Type: text/plain');
        die("bot_detected");
    }

    // Sanitize inputs
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $property_type = htmlspecialchars($_POST["property_type"]);
    $contact_time = htmlspecialchars($_POST["contact_time"]);

    $user_ip = $_SERVER['REMOTE_ADDR'];
    $referring_page = $_SERVER['HTTP_REFERER'] ?? 'Unknown';

    // Email setup
    $to = "info@b1properties.ae";
    $subject = "New Property Inquiry";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $message = "
    <html>
    <body>
        <h2>New Property Sell Inquiry Received</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Property Type:</strong> $property_type</p>
        <p><strong>Preferred Contact Time:</strong> $contact_time</p>
        <p><strong>User IP Address:</strong> $user_ip</p>
        <p><strong>Referring Page:</strong> $referring_page</p>
    </body>
    </html>";

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
