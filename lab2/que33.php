<?php
$message = "";

if (isset($_POST['submit'])) {
    $to = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $body = trim($_POST['message']);
    
    // Validate email format
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $message = "<b>Error: Invalid email address format.</b>";
    } elseif (empty($subject) || empty($body)) {
        $message = "<b>Error: Subject and Message cannot be empty.</b>";
    } else {
        // Set headers (From address)
        // Note: On localhost, this must be a valid domain or it may be flagged as spam
        $headers = "From: no-reply@yourdomain.com\r\n";
        $headers .= "Reply-To: " . $to . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Send email
        if (mail($to, $subject, $body, $headers)) {
            $message = "<b>Email notification successfully sent to $to!</b>";
        } else {
            $message = "<b>Error: Failed to send email. Please check your local server's mail configuration.</b>";
        }
    }
}
?>

<h3>Send Email Notification</h3>

<?php if (!empty($message)) echo $message . "<br><br>"; ?>

<!-- FORM -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label>Recipient Email:</label><br>
    <input type="text" name="email" required><br><br>
    
    <label>Subject:</label><br>
    <input type="text" name="subject" required><br><br>
    
    <label>Message:</label><br>
    <textarea name="message" rows="5" cols="40" required></textarea><br><br>
    
    <input type="submit" name="submit" value="Send Email">
</form>