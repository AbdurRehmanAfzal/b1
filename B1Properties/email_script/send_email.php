<?php
// Only set cookie if user hasn't rejected cookies
if (!isset($_COOKIE['cookie_consent']) || $_COOKIE['cookie_consent'] !== 'false') {
    setcookie('formSubmitted', time(), time() + 5, '/');
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Honeypot check
    if (!empty($_POST["website"])) {
        header('Content-Type: text/plain');
        die("bot_detected");
    }
    
    // Time check: submitted too quickly
    $form_load_time = isset($_POST["form_load_time"]) ? (int)$_POST["form_load_time"] : 0;
    $current_time = round(microtime(true) * 1000);

    if ($form_load_time === 0 || ($current_time - $form_load_time) < 1500) {
        header('Content-Type: text/plain');
        die("bot_detected");
    }

    // Sanitize inputs
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $country_code = htmlspecialchars($_POST["country_code"]);
    $full_phone = htmlspecialchars($_POST["full_phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Optional: Consent check
    if (!isset($_POST["consent"])) {
        echo "Consent is required.";
        exit;
    }

    // Enhanced IP detection
    function getClientIP() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        
        // Handle multiple IPs in X_FORWARDED_FOR
        if (strpos($ipaddress, ',') !== false) {
            $ips = explode(',', $ipaddress);
            $ipaddress = trim($ips[0]);
        }
        
        return $ipaddress;
    }
    
    $user_ip = getClientIP();
    $referring_page = $_SERVER['HTTP_REFERER'] ?? 'Direct access';

    // Build email
    $to = "info@b1properties.ae";
    $subject = "New Contact Form Submission";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";

    $body = "You have received a new message from the contact form:\n\n" .
            "Name: $name\n" .
            "Phone: $full_phone\n" .
            "Country Code: $country_code\n" .
            "Email: $email\n\n" .
            "Message:\n$message\n\n" .
            "User IP: $user_ip\n" .
            "Submitted From: $referring_page";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        header('Content-Type: text/plain');
        die("success");
    } else {
        header('Content-Type: text/plain');
        die("error");
    }
} else {
    echo "Invalid request.";
}
?>