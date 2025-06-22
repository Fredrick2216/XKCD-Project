#!/bin/bash

# Get the absolute path to the cron.php file
CRON_PHP_PATH="$(dirname "$0")"/cron.php

# Get the current user's crontab
(crontab -l 2>/dev/null; echo "0 0 * * * php $CRON_PHP_PATH") | crontab -

echo "CRON job for XKCD comic updates has been set up to run daily at midnight."

