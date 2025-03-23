<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $meeting_preference = $_POST['meeting_preference'];
    $budget = $_POST['budget'];

    $user_ip = $_SERVER['REMOTE_ADDR'];
    $referring_page = $_SERVER['HTTP_REFERER'];

    $to = "info@b1properties.ae"; // Change this to your email
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
        <h2>New Inquiry Received</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Meeting Preference:</strong> $meeting_preference</p>
        <p><strong>Budget:</strong> $budget</p>
        <p><strong>User IP Address:</strong> $user_ip</p>
        <p><strong>Referring Page:</strong> $referring_page</p>
    </body>
    </html>
    ";

    if (mail($to, $subject, $message, $headers)) {
        echo "success"; // Return success if email is sent
    } else {
        echo "error"; // Return error if email fails
    }
} else {
    echo "error"; // Return error if the request method is not POST
}
?>