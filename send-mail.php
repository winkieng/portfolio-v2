<?php
header('Content-Type: application/json');

// Your email address
$to = 'ng.winkie@yahoo.com';

// Get form data
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
$subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : '';
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

// Validate required fields
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

// Email headers
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Email body
$emailBody = "
<html>
<head>
    <style>
        body { font-family: 'IBM Plex Mono', monospace; }
        .container { padding: 20px; }
        .label { font-weight: bold; color: #666; }
        .value { margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class='container'>
        <h2>New Contact Form Submission</h2>
        <p class='label'>Name:</p>
        <p class='value'>$name</p>
        <p class='label'>Email:</p>
        <p class='value'>$email</p>
        <p class='label'>Subject:</p>
        <p class='value'>$subject</p>
        <p class='label'>Message:</p>
        <p class='value'>$message</p>
    </div>
</body>
</html>
";

// Send email
$mailSubject = "Portfolio Contact: $subject";

if (mail($to, $mailSubject, $emailBody, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Thank you for your message! I will get back to you soon.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Sorry, there was an error sending your message. Please try again later.']);
}
?>
