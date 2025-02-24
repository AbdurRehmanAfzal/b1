<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $time = $_POST['time']; // Ensure the form sends the selected time properly
    $message = htmlspecialchars($_POST["message"]);

    $to = "info@b1properties.ae";
    $subject = "New Contact Form Submission";
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "Content-Type: text/plain; charset=UTF-8";

    $body = "You have received a new message from the contact form:\n\n" .
            "Name: $name\n" .
            "Phone: $phone\n" .
            "Email: $email\n\n" .
            "Time: $time\n\n" .
            "Message:\n$message";

    if (mail($to, $subject, $body, $headers)) {
        echo "Message sent successfully!";
    } else {
        echo "Message failed to send.";
    }
} else {
    echo "Invalid request.";
}
?>
