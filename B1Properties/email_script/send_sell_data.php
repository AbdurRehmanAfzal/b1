<?php
// Only set cookie if user hasn't rejected cookies
if (!isset($_COOKIE['cookie_consent']) || $_COOKIE['cookie_consent'] !== 'false') {
    setcookie('formSubmitted', time(), time() + 5, '/'); // 5-second cookie
}
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
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5Z492V9M');</script>
        <title>New Property Inquiry</title>
     <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        
        fbq('init', '695506769567914'); // Your Pixel ID
        fbq('track', 'PageView'); // Tracks page views
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" 
            src="https://www.facebook.com/tr?id=695506769567914&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Meta Pixel Code -->
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