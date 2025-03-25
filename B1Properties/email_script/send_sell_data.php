<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $property_type = $_POST['property_type'];
    $contact_time = $_POST['contact_time'];

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
        <h2>New Property Sell Inquiry Received</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Property Type:</strong> $property_type</p>
        <p><strong>Preferred Contact Time:</strong> $contact_time</p>
        <p><strong>User IP Address:</strong> $user_ip</p>
        <p><strong>Referring Page:</strong> $referring_page</p>
    <script>
        document.getElementById('close-form-btn').addEventListener('click', function() {
            // Option 1: Reset form and close (if in modal)
            document.getElementById('property-form').reset();
            
            // Option 2: Redirect to homepage
            // window.location.href = 'index.html';
            
            // Option 3: Hide the form (if on same page)
            document.getElementById('modallogin').style.display = 'none';
            
            // Option 4: Close modal (if using one)
            // document.getElementById('form-modal').close();
            
            // Choose one option above based on your needs
            // For most cases, Option 1 + Option 4 (if modal) works best
        });
    </script>

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