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
    $meeting_preference = $_POST['meeting_preference'] ?? '';
    $budget = $_POST['budget'] ?? '';

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($meeting_preference) || empty($budget)) {
        echo "error"; // Return error if any required field is empty
        exit;
    }

    // Sanitize inputs (optional but recommended)
    $name = htmlspecialchars($name);
    $phone = htmlspecialchars($phone);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $meeting_preference = htmlspecialchars($meeting_preference);
    $budget = htmlspecialchars($budget);

    // Prepare email content (optional)
    $to = "your-email@example.com"; // Replace with your email address
    $subject = "New Luxury Property Inquiry";
    $message = "
        <h2>New Inquiry Received</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Meeting Preference:</strong> $meeting_preference</p>
        <p><strong>Budget:</strong> $budget</p>
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