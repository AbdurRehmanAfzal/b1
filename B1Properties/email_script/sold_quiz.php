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
    $phone = htmlspecialchars($_POST["phone"]);
    $country_code = htmlspecialchars($_POST["country_code"]);
    $full_phone = htmlspecialchars($_POST["full_phone"]);
    $email = htmlspecialchars($_POST["email"] ?? '');
    $meeting_preference = htmlspecialchars($_POST["meeting_preference"] ?? '');
    $budget = htmlspecialchars($_POST["budget"] ?? '');

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
        <p><strong>Phone:</strong> $full_phone</p>
        <p><strong>Country Code:</strong> $country_code</p>
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
