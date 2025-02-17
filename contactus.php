<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $company = trim($_POST['company']);
    $phone = trim($_POST['phone']);
    $cellPhone = trim($_POST['cell_phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $zipCode = trim($_POST['zip_code']);
    $preferredContact = trim($_POST['preferred_contact']);
    $comments = trim($_POST['comments']);
    
    // Step 1: Validate the input data (basic validation)
    $errors = [];
    
    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    }
    
    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email address is required.";
    }
    
    if (empty($comments)) {
        $errors[] = "Please provide your comments or inquiry.";
    }

    // Check if captcha is filled out (if you decide to add captcha in the form later)
    // if (empty($_POST['captcha']) || $_POST['captcha'] != $_SESSION['captcha_code']) {
    //     $errors[] = "Invalid captcha.";
    // }

    // If there are errors, show them, otherwise proceed
    if (count($errors) > 0) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        // Step 2: Prepare the email
        $to = "s.v.kiruthick@gmail.com.com";  // Replace with your email
        $subject = "New Contact Us Inquiry";
        
        $message = "You have received a new inquiry from the Contact Us form:\n\n";
        $message .= "First Name: $firstName\n";
        $message .= "Last Name: $lastName\n";
        $message .= "Company: $company\n";
        $message .= "Phone: $phone\n";
        $message .= "Cell Phone: $cellPhone\n";
        $message .= "Email: $email\n";
        $message .= "Address: $address\n";
        $message .= "City: $city\n";
        $message .= "State: $state\n";
        $message .= "Zip Code: $zipCode\n";
        $message .= "Preferred Contact Method: $preferredContact\n";
        $message .= "Comments:\n$comments\n";

        // Step 3: Send the email
        $headers = "From: $email" . "\r\n" .
                   "Reply-To: $email" . "\r\n" .
                   "Content-Type: text/plain; charset=UTF-8";

        if (mail($to, $subject, $message, $headers)) {
            echo "Thank you for your inquiry! We will get back to you as soon as possible.";
        } else {
            echo "There was an error sending your message. Please try again later.";
        }
    }
}
?>
