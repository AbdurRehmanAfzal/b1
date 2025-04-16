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

    if ($form_load_time === 0 || ($current_time - $form_load_time) < 1500) {
        header('Content-Type: text/plain');
        die("bot_detected");
    }
    
    // Sanitize and assign variables
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $country_code = htmlspecialchars($_POST["country_code"]);
    $full_phone = htmlspecialchars($_POST["full_phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $property_ownership_status = $_POST['property_ownership_status'];
    $current_status = $_POST['current_status'];
    $investment_amount = $_POST['investment_amount'];
    $buy_timeline = $_POST['buy_timeline'];
    
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

    $to = "info@b1properties.ae";
    $subject = "New Property Inquiry";
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $message = "
    <html>
    <head><title>New Property Inquiry</title></head>
    <body>
        <h2>New Inquiry Details</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $full_phone</p>
        <p><strong>Country Code:</strong> $country_code</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Property Ownership Status:</strong> $property_ownership_status</p>
        <p><strong>Current Status:</strong> $current_status</p>
        <p><strong>Investment Amount:</strong> $investment_amount</p>
        <p><strong>Buy Timeline:</strong> $buy_timeline</p>
        <p><strong>User IP Address:</strong> $user_ip</p>
        <p><strong>Referring Page:</strong> $referring_page</p>
    </body>
    </html>
    ";

    if (mail($to, $subject, $message, $headers)) {
        header('Content-Type: text/plain');
        die("success");
    } else {
        header('Content-Type: text/plain');
        die("error");
    }
} else {
    echo "error";
}
?>