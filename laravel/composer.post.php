#!/usr/bin/env php
<?php
/**
 * Run Laravel post-installation steps.
 *
 * 1. Generate an app key, if one doesn't already exist
 * 2. Clear Laravel config cache and regenerate
 */
if (0 === preg_match('/APP_KEY=[A-Za-z0-9:=]+/', file_get_contents('.env'))) {
    `php artisan key:generate`;
    `php artisan config:clear`;
    `php artisan config:cache`;
}
?>
