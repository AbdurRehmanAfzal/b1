<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $time = htmlspecialchars($_POST['time']); // Ensure the form sends the selected time properly
    $message = htmlspecialchars($_POST["message"]);

    // Get user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Get the referring page (page from which the form was submitted)
    $referring_page = $_SERVER['HTTP_REFERER'];

    // Prepare email content
    $to = "info@b1properties.ae";
    $subject = "New Contact Form Submission";
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "Content-Type: text/plain; charset=UTF-8";

    $body = "You have received a new message from the contact form:\n\n" .
            "Name: $name\n" .
            "Phone: $phone\n" .
            "Email: $email\n" .
            "Time: $time\n\n" .
            "Message:\n$message\n\n" .
            "User IP: $user_ip\n" .
            "Submitted From: $referring_page";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        // Redirect to thankyou.html after successful form submission
        header("Location: ../thankyou.html"); // Adjust the path if needed
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Message failed to send.";
    }
} else {
    echo "Invalid request.";
}
?>