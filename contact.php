<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Recipient email
        $to = "samridhitandon002@gmail.com";

        // Email subject
        $email_subject = "New message from $name: $subject";

        // Email body
        $email_body = "You have received a new message from the user $name.\n\n".
                      "Here is the message:\n$message\n\n".
                      "Reply to $email";

        // Headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

        // Send email
        if (mail($to, $email_subject, $email_body, $headers)) {
            echo "<div id='sendmessage'>Your message has been sent. Thank you!</div>";
        } else {
            // Log error if mail fails
            error_log("Mail delivery failed for: $email_subject to $to", 3, 'error_log.txt');
            echo "<div id='errormessage'>Message delivery failed...</div>";
        }
    } else {
        echo "<div id='errormessage'>Please enter a valid email address.</div>";
    }
}
?>
