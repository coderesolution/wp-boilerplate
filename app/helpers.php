<?php

declare(strict_types=1);

/**
 * Helper Functions Loader.
 *
 * This file loads all helper functions from the Helpers directory.
 * Helper files are organized by category (e.g., validation, array, string, etc.).
 */

if ( ! defined('ABSPATH')) {
    exit(); // Exit if accessed directly.
}

// Load all helper files from the Helpers directory.
$helpers_dir = __DIR__ . '/Helpers';

if (is_dir($helpers_dir)) {
    $helper_files = glob($helpers_dir . '/*.php');

    foreach ($helper_files as $helper_file) {
        if (file_exists($helper_file)) {
            require_once $helper_file;
        }
    }
}
