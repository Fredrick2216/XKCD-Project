<?php
include 'functions.php';

if (isset($_GET["email"]) && isset($_GET["comic_id"]) && isset($_GET["rating"])) {
    $email = $_GET["email"];
    $comic_id = $_GET["comic_id"];
    $rating = $_GET["rating"];

    recordRating($email, $comic_id, $rating);
    echo "Rating for comic $comic_id ($rating stars) recorded for $email.";
} else {
    echo "Invalid rating request.";
}
?>

