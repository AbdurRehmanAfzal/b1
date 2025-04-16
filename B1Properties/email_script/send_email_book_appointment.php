<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot trap
    if (!empty($_POST["website"])) {
        header('Content-Type: text/plain');
        die("bot_detected");
    }

    error_log("Form load time difference: " . ($current_time - $form_load_time));

    // Sanitize inputs
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $name = htmlspecialchars($_POST['name']);
    $country_code = htmlspecialchars($_POST["country_code"]);
    $full_phone = htmlspecialchars($_POST["full_phone"]);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $appointment_type = htmlspecialchars($_POST['appointment_type']);
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

    // Prepare email
    $to = "info@b1properties.ae";
    $subject = "New Appointment Booking";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "
        <h2>New Appointment Request</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $full_phone</p>
        <p><strong>Country Code:</strong> $country_code</p>
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
