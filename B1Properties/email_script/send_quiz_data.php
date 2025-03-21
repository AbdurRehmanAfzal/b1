<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $property_ownership_status = $_POST['property_ownership_status'] ?? '';
    $current_status = $_POST['current_status'] ?? '';
    $investment_amount = $_POST['investment_amount'] ?? '';
    $buy_timeline = $_POST['buy_timeline'] ?? '';

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($property_ownership_status) || empty($current_status) || empty($investment_amount) || empty($interest)) {
        echo "error"; // Return error if any required field is empty
        exit;
    }

    // Sanitize inputs (optional but recommended)
    $name = htmlspecialchars($name);
    $phone = htmlspecialchars($phone);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $property_ownership_status = htmlspecialchars($property_ownership_status);
    $current_status = htmlspecialchars($current_status);
    $investment_amount = htmlspecialchars($investment_amount);
    $interest = htmlspecialchars($interest);

    // Prepare email content (optional)
    $to = "abdurrehmanafzal786@gmail.com"; // Replace with your email address
    $subject = "New Luxury Property Inquiry";
    $message = "
        <h2>New Inquiry Received</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Property Ownership Status:</strong> $property_ownership_status</p>
        <p><strong>Current Status:</strong> $current_status</p>
        <p><strong>Investment Amount:</strong> $investment_amount</p>
        <p><strong>Buy_timeline:</strong> $buy_timeline</p>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@example.com" . "\r\n"; // Replace with a valid sender email

    // Send email (optional)
    if (mail($to, $subject, $message, $headers)) {
        echo "success"; // Return success if email is sent
    } else {
        echo "error"; // Return error if email fails
    }
} else {
    echo "error"; // Return error if the request method is not POST
}
?>