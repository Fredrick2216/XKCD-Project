<?php
header('Content-Type: text/plain');

// Create directory for saved comics if it doesn't exist
$save_dir = __DIR__ . '/saved_comics/';
if (!is_dir($save_dir)) {
    mkdir($save_dir, 0755, true);
}

// Get the JSON data from the request
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['imageData'])) {
    $imageData = $input['imageData'];
    
    // Remove the data URL prefix
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $data = base64_decode($imageData);
    
    // Generate a unique filename
    $filename = 'comic_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.png';
    $filepath = $save_dir . $filename;
    
    // Save the image
    if (file_put_contents($filepath, $data)) {
        echo "Comic saved successfully as: $filename";
    } else {
        echo "Error saving comic.";
    }
} else {
    echo "No image data received.";
}
?>

