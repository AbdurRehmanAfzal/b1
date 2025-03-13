<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $property_status = htmlspecialchars($_POST["property_status"]);
    $invested_in_dubai = htmlspecialchars($_POST["invested_in_dubai"]);
    $interest = htmlspecialchars($_POST["interest"]);

    // Get user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Get the referring page (page from which the form was submitted)
    $referring_page = $_SERVER['HTTP_REFERER'];

    // Prepare email content
    $to = "abdurrehmanafzal786@gmail.com"; // Change this to your email
    $subject = "New Property Inquiry";
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $message = "
    <html>
    <head>
        <title>New Property Inquiry</title>
    </head>
    <body>
        <h2>New Inquiry Details</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Property Status:</strong> $property_status</p>
        <p><strong>Invested in Dubai:</strong> $invested_in_dubai</p>
        <p><strong>Interest:</strong> $interest</p>
        <p><strong>User IP:</strong> $user_ip</p>
        <p><strong>Submitted From:</strong> $referring_page</p>
    </body>
    </html>
    ";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        // Redirect to thankyou.html after successful email submission
        header("Location: ../thankyou.html"); // Adjust the path if needed
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Email sending failed.";
    }
} else {
    echo "Invalid request.";
}
?>