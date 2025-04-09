<?php
// Only set cookie if user hasn't rejected cookies
if (!isset($_COOKIE['cookie_consent']) || $_COOKIE['cookie_consent'] !== 'false') {
    setcookie('formSubmitted', time(), time() + 5, '/');
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Honeypot check
    if (!empty($_POST["website"])) {
        header("Location: bot-detected.html"); // Optional: Create this page
        exit;
    }

    // Time-based bot protection
    $form_load_time = isset($_POST["form_load_time"]) ? (int)$_POST["form_load_time"] : 0;
    $current_time = round(microtime(true) * 1000);
    if ($form_load_time === 0 || ($current_time - $form_load_time) < 3000) {
        header("Location: bot-detected.html");
        exit;
    }

    // Sanitize inputs
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Optional: Consent check
    if (!isset($_POST["consent"])) {
        echo "Consent is required.";
        exit;
    }

    $user_ip = $_SERVER['REMOTE_ADDR'];
    $referring_page = $_SERVER['HTTP_REFERER'] ?? 'Direct access';

    // Build email
    $to = "info@b1properties.ae";
    $subject = "New Contact Form Submission";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";

    $body = "You have received a new message from the contact form:\n\n" .
            "Name: $name\n" .
            "Phone: $phone\n" .
            "Email: $email\n\n" .
            "Message:\n$message\n\n" .
            "User IP: $user_ip\n" .
            "Submitted From: $referring_page";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        header("Location: ../thankyou.html"); // Adjust path as needed
        exit;
    } else {
        echo "Message failed to send.";
    }
} else {
    echo "Invalid request.";
}
?>
