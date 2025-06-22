<?php
include 'functions.php';

session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsubscribe_email'])) {
        $email = $_POST['unsubscribe_email'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $code = generateVerificationCode();
            $_SESSION['unsubscribe_code'] = $code;
            $_SESSION['email_to_unsubscribe'] = $email;
            sendVerificationEmail($email, $code); // Re-using sendVerificationEmail for unsubscribe code
            $message = 'A verification code has been sent to your email to confirm unsubscription.';
        } else {
            $message = 'Invalid email address.';
        }
    } elseif (isset($_POST['verification_code']) && isset($_SESSION['email_to_unsubscribe'])) {
        $entered_code = $_POST['verification_code'];
        $email = $_SESSION['email_to_unsubscribe'];
        if (verifyCode($email, $entered_code) && $entered_code === $_SESSION['unsubscribe_code']) {
            unsubscribeEmail($email);
            $message = 'Email successfully unsubscribed!';
            unset($_SESSION['unsubscribe_code']);
            unset($_SESSION['email_to_unsubscribe']);
        } else {
            $message = 'Invalid verification code.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribe from XKCD Comics</title>
</head>
<body>
    <h1>Unsubscribe from XKCD Comics</h1>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <h2>Unsubscribe Email</h2>
    <form method="POST">
        <label for="unsubscribe_email">Email:</label><br>
        <input type="email" name="unsubscribe_email" id="unsubscribe_email" required>
        <button type="submit" id="submit-unsubscribe">Unsubscribe</button>
    </form>

    <h2>Confirm Unsubscription</h2>
    <form method="POST">
        <label for="verification_code">Verification Code:</label><br>
        <input type="text" name="verification_code" id="verification_code" maxlength="6" required>
        <button type="submit" id="submit-verification">Verify</button>
    </form>
</body>
</html>

