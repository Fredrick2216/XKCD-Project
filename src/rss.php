<?php
header('Content-Type: application/rss+xml; charset=utf-8');

// Get the latest comic to determine the range
$latest_comic_data = json_decode(file_get_contents('https://xkcd.com/info.0.json'));
$latest_comic_id = $latest_comic_data->num;

// Generate RSS for the last 10 comics
$start_id = max(1, $latest_comic_id - 9);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0">
    <channel>
        <title>XKCD Daily Comics RSS Feed</title>
        <link>https://xkcd.com</link>
        <description>Latest XKCD comics delivered via RSS</description>
        <language>en-us</language>
        <lastBuildDate><?php echo date('r'); ?></lastBuildDate>

        <?php
        for ($comic_id = $latest_comic_id; $comic_id >= $start_id; $comic_id--) {
            try {
                $comic_data = json_decode(file_get_contents("https://xkcd.com/$comic_id/info.0.json"));
                if ($comic_data) {
                    echo "<item>\n";
                    echo "<title>" . htmlspecialchars($comic_data->title) . "</title>\n";
                    echo "<link>https://xkcd.com/$comic_id/</link>\n";
                    echo "<description><![CDATA[";
                    echo "<img src='" . $comic_data->img . "' alt='" . htmlspecialchars($comic_data->alt) . "' />";
                    echo "<p>" . htmlspecialchars($comic_data->alt) . "</p>";
                    echo "]]></description>\n";
                    echo "<pubDate>" . date('r', mktime(0, 0, 0, $comic_data->month, $comic_data->day, $comic_data->year)) . "</pubDate>\n";
                    echo "<guid>https://xkcd.com/$comic_id/</guid>\n";
                    echo "</item>\n";
                }
            } catch (Exception $e) {
                // Skip comics that might not exist or have errors
                continue;
            }
        }
        ?>
    </channel>
</rss>

