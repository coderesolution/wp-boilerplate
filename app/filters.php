<?php

declare(strict_types=1);

/**
 * Theme filters.
 */

namespace App;

/**
 * Load Roots Allow SVG plugin.
 *
 * Enables SVG uploads with security validation.
 * @link https://github.com/roots/allow-svg
 */
if (file_exists(__DIR__ . '/../vendor/roots/allow-svg/allow-svg.php')) {
    require_once __DIR__ . '/../vendor/roots/allow-svg/allow-svg.php';
}

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});
