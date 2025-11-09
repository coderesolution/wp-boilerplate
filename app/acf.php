<?php

declare(strict_types=1);

/**
 * ACF Configuration
 *
 * Configure Advanced Custom Fields (ACF) and ACF Extended (ACFE)
 * settings for local JSON and PHP sync.
 */

namespace App;

/**
 * Check if ACF is active.
 *
 * @return bool
 */
function is_acf_active(): bool
{
    return function_exists('acf');
}

/**
 * Check if ACF Extended is active.
 *
 * @return bool
 */
function is_acfe_active(): bool
{
    return function_exists('acfe_get_setting');
}

/**
 * Setup ACF JSON save and load paths.
 */
function setup_acf_json(): void
{
    if ( ! is_acf_active()) {
        return;
    }

    /**
     * Set ACF JSON save path.
     *
     * @param string $path Default save path.
     * @return string Custom save path
     */
    add_filter('acf/settings/save_json', function ($path) {
        $custom_path = get_template_directory() . '/app/acf-json';

        // Create directory if it doesn't exist.
        if ( ! is_dir($custom_path)) {
            wp_mkdir_p($custom_path);
        }

        return $custom_path;
    });

    /**
     * Add ACF JSON load path.
     *
     * @param array $paths Array of paths to load JSON from.
     * @return array Modified paths array
     */
    add_filter('acf/settings/load_json', function ($paths) {
        $custom_path = get_template_directory() . '/app/acf-json';

        // Remove default path (optional - comment out if you want to keep both).
        // unset($paths[0]);

        // Add custom path.
        $paths[] = $custom_path;

        return $paths;
    });
}

/**
 * Setup ACF Extended Performance Mode with Hybrid Engine.
 */
function setup_acfe_performance(): void
{
    if ( ! is_acfe_active()) {
        return;
    }

    /**
     * Enable Performance Mode with Hybrid Engine.
     *
     * @link https://www.acf-extended.com/features/modules/performance-mode/hybrid-engine
     */
    add_action('acfe/init', function () {
        acfe_update_setting('modules/performance', [
            'engine' => 'hybrid',
            'options' => true,
            'ui' => false,
            'mode' => 'production',
        ]);
    });
}

/**
 * Setup ACF Extended PHP and JSON save/load paths.
 */
function setup_acfe_sync(): void
{
    if ( ! is_acfe_active()) {
        return;
    }

    /**
     * Set ACF Extended PHP save path.
     *
     * @param string $path Default save path.
     * @param array|null $field_group Field group settings (optional).
     * @return string Custom save path.
     */
    add_filter('acfe/settings/php_save', function ($path) {
        // Handle variable arguments - ACFE may call with 1 or 2 arguments.
        $field_group = func_num_args() > 1 ? func_get_arg(1) : null;

        $custom_path = get_template_directory() . '/app/acf-php';

        // Create directory if it doesn't exist.
        if ( ! is_dir($custom_path)) {
            wp_mkdir_p($custom_path);
        }

        return $custom_path;
    });

    /**
     * Add ACF Extended PHP load path.
     *
     * @param array $paths Array of paths to load PHP from.
     * @return array Modified paths array.
     */
    add_filter('acfe/settings/php_load', function ($paths) {
        $custom_path = get_template_directory() . '/app/acf-php';

        // Add custom path.
        $paths[] = $custom_path;

        return $paths;
    });

    /**
     * Set ACF Extended JSON save path.
     *
     * @param string $path Default save path.
     * @param array|null $field_group Field group settings (optional).
     * @return string Custom save path.
     */
    add_filter('acfe/settings/json_save', function ($path) {
        // Handle variable arguments - ACFE may call with 1 or 2 arguments.
        $field_group = func_num_args() > 1 ? func_get_arg(1) : null;

        // Use the same path as ACF JSON for consistency.
        $custom_path = get_template_directory() . '/app/acf-json';

        // Create directory if it doesn't exist.
        if ( ! is_dir($custom_path)) {
            wp_mkdir_p($custom_path);
        }

        return $custom_path;
    });

    /**
     * Add ACF Extended JSON load path.
     *
     * @param array $paths Array of paths to load JSON from.
     * @return array Modified paths array.
     */
    add_filter('acfe/settings/json_load', function ($paths) {
        // Use the same path as ACF JSON for consistency.
        $custom_path = get_template_directory() . '/app/acf-json';

        // Add custom path.
        $paths[] = $custom_path;

        return $paths;
    });
}

// Initialize ACF configuration.
setup_acf_json();
setup_acfe_performance();
setup_acfe_sync();
