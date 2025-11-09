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
 * Adjust speculative loading (prefetching/prerendering) for internal links.
 * May cause conflicts with View Transitions API.
 */
add_filter('wp_speculation_rules_configuration', function () {
    return [
        'mode' => 'auto',
        'eagerness' => 'moderate',
    ];
});

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});
