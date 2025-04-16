<?php
// Only set cookie if user hasn't rejected cookies
if (!isset($_COOKIE['cookie_consent']) || $_COOKIE['cookie_consent'] !== 'false') {
    setcookie('formSubmitted', time(), time() + 5, '/'); // 5-second cookie
}
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST["phone"]);
    $country_code = htmlspecialchars($_POST["country_code"]);
    $full_phone = htmlspecialchars($_POST["full_phone"]);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $appointment_type = htmlspecialchars($_POST['appointment_type']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error";
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

    // Get the referring page (page from which the form was submitted)
    $referring_page = $_SERVER['HTTP_REFERER'] ?? 'Direct access or unknown';

    // Prepare email content
    $to = "info@b1properties.ae"; // Change this to the recipient email
    $subject = "New Book Appointment Request";
    $headers = "From: no-reply@example.com\r\n"; // Replace with a valid sender email
    $headers .= "Reply-To: $email\r\n"; // Add user's email as the reply-to address
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "
        <h2>New Tour Request</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $full_phone</p>
        <p><strong>Country Code:</strong> $country_code</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Date:</strong> $date</p>
        <p><strong>Time:</strong> $time</p>
        <p><strong>Appointment Type:</strong> $appointment_type</p>
        <p><strong>Message:</strong> $message</p>
        <p><strong>User IP Address:</strong> $user_ip</p>
        <p><strong>Referring Page:</strong> $referring_page</p>
    ";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "success"; // Return success response
    } else {
        echo "error"; // Return error response
    }
} else {
    echo "error"; // Return error response for invalid requests
}
?>