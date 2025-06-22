<?php

function generateVerificationCode() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function sendVerificationEmail($email, $code) {
    $subject = 'Your Verification Code';
    $message = '<p>Your verification code is: <strong>' . $code . '</strong></p>';
    $headers = 'From: no-reply@example.com' . "\r\n" .
               'MIME-Version: 1.0' . "\r\n" .
               'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    
    file_put_contents(__DIR__ . '/email_log.txt', "To: $email\nSubject: $subject\nMessage: $message\n\n", FILE_APPEND);
    return true;
}

function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    file_put_contents($file, $email . "\n", FILE_APPEND);
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $updated_emails = array_diff($emails, [$email]);
    file_put_contents($file, implode("\n", $updated_emails) . "\n");
}

function verifyCode($email, $code) {
    return preg_match('/^\d{6}$/', $code);
}

function recordRating($email, $comic_id, $rating) {
    $file = __DIR__ . '/user_ratings.txt';
    file_put_contents($file, "$email|$comic_id|$rating\n", FILE_APPEND);
}

function getExplainXKCDUrl($comic_id) {
    return 'https://www.explainxkcd.com/wiki/index.php/' . $comic_id;
}

function fetchAndFormatXKCDData($user_email = null) {
    $latest_comic_id = json_decode(file_get_contents('https://xkcd.com/info.0.json'))->num;
    $comic_id_to_fetch = rand(1, $latest_comic_id);

    // Simple recommendation logic (for demonstration)
    if ($user_email) {
        $ratings_file = __DIR__ . '/user_ratings.txt';
        if (file_exists($ratings_file)) {
            $ratings = file($ratings_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $user_ratings = [];
            foreach ($ratings as $line) {
                list($email, $comic_id, $rating) = explode('|', $line);
                if ($email === $user_email) {
                    $user_ratings[$comic_id] = (int)$rating;
                }
            }

            // This is a very basic example. In a real system, you'd have more sophisticated logic.
            // For now, if a user has rated a comic highly, we'll try to send them a similar one (not implemented fully).
            // Or, if they have rated many comics, we could try to send them one they haven't rated.
            // For simplicity, we'll just ensure we don't send them a comic they've already rated if possible.
            $attempt_count = 0;
            while (isset($user_ratings[$comic_id_to_fetch]) && $attempt_count < 10) {
                $comic_id_to_fetch = rand(1, $latest_comic_id);
                $attempt_count++;
            }
        }
    }

    $comic_data = json_decode(file_get_contents("https://xkcd.com/$comic_id_to_fetch/info.0.json"));

    $html = '<h2>XKCD Comic</h2>';
    $html .= '<img src="' . $comic_data->img . '" alt="' . $comic_data->alt . '">';
    $html .= '<p><a href="' . getExplainXKCDUrl($comic_id_to_fetch) . '" target="_blank">Explain This Comic</a></p>';
    $html .= '<p><a href="#" id="unsubscribe-button">Unsubscribe</a></p>';
    
    // Add simulated rating links
    $html .= '<p>Rate this comic: ';
    for ($i = 1; $i <= 5; $i++) {
        $html .= '<a href="/rate.php?email=' . urlencode($user_email) . '&comic_id=' . $comic_id_to_fetch . '&rating=' . $i . '">' . $i . ' Star</a> ';
    }
    $html .= '</p>';

    return $html;
}

function sendXKCDUpdatesToSubscribers() {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $subject = 'Your XKCD Comic';
    $headers = 'From: no-reply@example.com' . "\r\n" .
               'MIME-Version: 1.0' . "\r\n" .
               'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    foreach ($emails as $email) {
        $comic_html = fetchAndFormatXKCDData($email); // Pass email for potential personalization
        file_put_contents(__DIR__ . '/email_log.txt', "To: $email\nSubject: $subject\nMessage: $comic_html\n\n", FILE_APPEND);
    }
}

?>

