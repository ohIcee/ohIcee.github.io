<?php

$RECIEVER_EMAIL = "icevx1@gmail.com";
$Subject = "";

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// ERROR CHECK
if ($name == trim($name) && strpos($name, ' ') === false) {
    // NO SPACES IN BETWEEN
    echo 'ERR_invalid_name';
    return;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
    echo 'ERR_invalid_email';
    return;
}
if (strlen($message) < 20) {
    echo 'ERR_length_message';
    return;
}

$message_to_send = "Ime : " . $name . "\n" . $message;
$headers = "From: " . $email;

$sent_email = mail($RECIEVER_EMAIL, $Subject, $message, $headers);

if($sent_email)
{
    echo true;
} else {
    echo false;
}

?>
