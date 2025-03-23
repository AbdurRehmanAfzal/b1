

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $property_ownership_status = $_POST['property_ownership_status'];
    $current_status = $_POST['current_status'];
    $investment_amount = $_POST['investment_amount'];
    $buy_timeline = $_POST['buy_timeline'];

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
        <h2>New Inquiry Details</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
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
        echo "success"; // Return success if email is sent
    } else {
        echo "error"; // Return error if email fails
    }
} else {
    echo "error"; // Return error if the request method is not POST
}
?>