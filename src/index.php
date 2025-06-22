<?php
include 'functions.php';

session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $code = generateVerificationCode();
            $_SESSION['verification_code'] = $code;
            $_SESSION['email_to_verify'] = $email;
            sendVerificationEmail($email, $code);
            $message = 'A verification code has been sent to your email.';
        } else {
            $message = 'Invalid email address.';
        }
    } elseif (isset($_POST['verification_code']) && isset($_SESSION['email_to_verify'])) {
        $entered_code = $_POST['verification_code'];
        $email = $_SESSION['email_to_verify'];
        if (verifyCode($email, $entered_code) && $entered_code === $_SESSION['verification_code']) {
            registerEmail($email);
            $message = 'Email successfully verified and registered!';
            unset($_SESSION['verification_code']);
            unset($_SESSION['email_to_verify']);
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
    <title>XKCD Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .nav-links {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .nav-links a {
            margin: 0 15px;
            color: #007cba;
            text-decoration: none;
            font-weight: bold;
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
        .form-section {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="email"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007cba;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #005a87;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .feature-highlight {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007cba;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Subscribe to XKCD Comics</h1>
        
        <div class="nav-links">
            <a href="archive.php">📚 Browse Archive</a>
            <a href="create_comic.php">🎨 Create Comic</a>
            <a href="rss.php">📡 RSS Feed</a>
            <a href="unsubscribe.php">❌ Unsubscribe</a>
        </div>

        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="feature-highlight">
            <h3>✨ New Features Available!</h3>
            <ul>
                <li><strong>Personalized Recommendations:</strong> Rate comics to get personalized suggestions</li>
                <li><strong>Interactive Explanations:</strong> Direct links to ExplainXKCD for every comic</li>
                <li><strong>Comic Creator Tool:</strong> Build your own XKCD-style comics</li>
                <li><strong>Archive Search:</strong> Browse and search the entire XKCD archive</li>
                <li><strong>RSS Feed:</strong> Alternative delivery method for RSS readers</li>
            </ul>
        </div>

        <div class="form-section">
            <h2>📧 Email Subscription</h2>
            <form method="POST">
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" required>
                <button type="submit" id="submit-email">Subscribe</button>
            </form>
        </div>

        <div class="form-section">
            <h2>✅ Verify Your Email</h2>
            <form method="POST">
                <label for="verification_code">Verification Code:</label>
                <input type="text" name="verification_code" id="verification_code" maxlength="6" required>
                <button type="submit" id="submit-verification">Verify</button>
            </form>
        </div>

        <div class="feature-highlight">
            <h3>📊 How It Works</h3>
            <p>1. Enter your email and receive a verification code</p>
            <p>2. Verify your email to complete subscription</p>
            <p>3. Receive daily XKCD comics with personalized recommendations</p>
            <p>4. Rate comics to improve future recommendations</p>
            <p>5. Explore additional features like comic creation and archive search</p>
        </div>
    </div>
</body>
</html>

