<?php

declare(strict_types=1);

/**
 * Block Asset Enqueuing System
 *
 * Handles enqueuing CSS and JS assets for blocks based on:
 * - Global blocks (always loaded, e.g., header/footer)
 * - Conditional blocks (loaded based on template conditions)
 * - Unregistered blocks (blocks without block.json that still need assets)
 */

namespace App;

use Illuminate\Support\Facades\Vite;
use Exception;

/**
 * Get configuration for global blocks
 *
 * @return array
 */
function get_global_blocks_config()
{
    return [
        'header-block',
        'footer-block',
    ];
}

/**
 * Get configuration for conditional blocks
 *
 * @return array
 */
function get_conditional_blocks_config()
{
    return [
        'single' => ['single-hero-block'],
        // Add more template conditions as needed:
        // 'archive' => ['archive-hero-block'],
        // 'page' => ['page-hero-block'],
    ];
}

/**
 * Get all available blocks and their assets
 *
 * @return array Array of block names with their asset paths
 */
function get_block_assets()
{
    static $block_assets_cache = null;

    if ($block_assets_cache !== null) {
        return $block_assets_cache;
    }

    // Server-side block files (PHP, Blade, JSON) are in resources/views/blocks/
    $views_blocks_dir = get_template_directory() . '/resources/views/blocks';
    // Client-side assets are in resources/blocks/
    $resources_blocks_dir = get_template_directory() . '/resources/blocks';
    $block_assets_cache = [];

    // Scan resources/blocks/ for CSS/JS assets
    if ( ! is_dir($resources_blocks_dir)) {
        return $block_assets_cache;
    }

    $block_dirs = glob($resources_blocks_dir . '/*', GLOB_ONLYDIR);

    foreach ($block_dirs as $block_dir) {
        $block_name = basename($block_dir);

        // Check for block.json in resources/views/blocks/ (server-side location)
        $block_json_path = $views_blocks_dir . '/' . $block_name . '/block.json';
        $has_block_json = file_exists($block_json_path);

        $assets = [
            'css' => null,
            'js' => null,
            'has_block_json' => $has_block_json,
        ];

        // Check for CSS file in resources/blocks/ (client-side location)
        $css_file = $block_dir . '/' . $block_name . '.css';
        if (file_exists($css_file)) {
            $assets['css'] = $css_file;
        }

        // Check for JS file in resources/blocks/ (client-side location)
        $js_file = $block_dir . '/' . $block_name . '.js';
        if (file_exists($js_file)) {
            $assets['js'] = $js_file;
        }

        $block_assets_cache[$block_name] = $assets;
    }

    return $block_assets_cache;
}

/**
 * Enqueue assets for a specific block
 *
 * @param string $block_name The block name (directory name)
 * @return void
 */
function enqueue_block_assets($block_name)
{
    static $enqueued_blocks = [];

    // Prevent double enqueuing
    if (isset($enqueued_blocks[$block_name])) {
        return;
    }

    $block_assets = get_block_assets();

    if ( ! isset($block_assets[$block_name])) {
        return;
    }

    $assets = $block_assets[$block_name];
    $theme_uri = get_template_directory_uri();
    $block_path = '/resources/blocks/' . $block_name;

    // Skip CSS enqueuing - CSS is imported via blocks.css and compiled by Vite
    // Block CSS files are imported in resources/css/blocks.css which is imported in app.css
    // This ensures all block CSS goes through Vite compilation and gets processed correctly

    // Enqueue JS
    if ($assets['js']) {
        $js_handle = 'block-' . $block_name . '-script';
        $js_uri = $theme_uri . $block_path . '/' . $block_name . '.js';
        $js_version = filemtime($assets['js']);

        // Try to use Vite asset if available, otherwise use direct file
        // Note: Block JS files don't need wp-blocks on the frontend
        try {
            $vite_asset = Vite::asset('resources/blocks/' . $block_name . '/' . $block_name . '.js');
            if ($vite_asset) {
                $dependencies = [];

                // Check if app.js is enqueued (it should be via Vite)
                if (wp_script_is('sage/app.js', 'enqueued') || wp_script_is('sage/app', 'enqueued')) {
                    $dependencies[] = 'sage/app';
                }

                wp_enqueue_script(
                    $js_handle,
                    $vite_asset,
                    $dependencies,
                    null,
                    true
                );
            } else {
                throw new Exception('Vite asset not available');
            }
        } catch (Exception $e) {
            // Fallback to direct file loading
            // Add dependency on app.js so block helpers are available
            $dependencies = [];

            // Check if app.js is enqueued (it should be via Vite)
            if (wp_script_is('sage/app.js', 'enqueued') || wp_script_is('sage/app', 'enqueued')) {
                $dependencies[] = 'sage/app';
            }

            wp_enqueue_script(
                $js_handle,
                $js_uri,
                $dependencies,
                $js_version,
                true
            );
        }
    }

    $enqueued_blocks[$block_name] = true;
}

/**
 * Enqueue global blocks (always loaded)
 *
 * @return void
 */
function enqueue_global_blocks()
{
    $global_blocks = get_global_blocks_config();

    foreach ($global_blocks as $block_name) {
        enqueue_block_assets($block_name);
    }
}

/**
 * Enqueue conditional blocks based on current template
 *
 * @return void
 */
function enqueue_conditional_blocks()
{
    $conditional_blocks = get_conditional_blocks_config();

    // Get current template
    $template = '';

    if (is_single()) {
        $template = 'single';
    } elseif (is_page()) {
        $template = 'page';
    } elseif (is_archive()) {
        $template = 'archive';
    } elseif (is_front_page()) {
        $template = 'front-page';
    } elseif (is_home()) {
        $template = 'home';
    } elseif (is_search()) {
        $template = 'search';
    } elseif (is_404()) {
        $template = '404';
    }

    if (empty($template) || ! isset($conditional_blocks[$template])) {
        return;
    }

    foreach ($conditional_blocks[$template] as $block_name) {
        enqueue_block_assets($block_name);
    }
}

/**
 * Detect and enqueue assets for blocks used in content
 * Handles both registered blocks (with block.json) and unregistered blocks
 *
 * @return void
 */
function enqueue_unregistered_blocks()
{
    $block_assets = get_block_assets();
    $used_blocks = [];

    // Get blocks from current post content
    if (is_singular() && have_posts()) {
        the_post();
        $content = get_the_content();
        rewind_posts();

        if ( ! empty($content)) {
            $parsed_blocks = parse_blocks($content);
            foreach ($parsed_blocks as $block) {
                if ( ! empty($block['blockName'])) {
                    // Extract block name from blockName (e.g., "sage/test-block" -> "test-block")
                    $block_name_parts = explode('/', $block['blockName']);
                    $block_name = end($block_name_parts);

                    // Enqueue assets for ALL blocks that exist in our blocks directory
                    // This includes both registered (with block.json) and unregistered blocks
                    if (isset($block_assets[$block_name])) {
                        $used_blocks[$block_name] = true;
                    }
                }

                // Recursively check inner blocks
                if ( ! empty($block['innerBlocks'])) {
                    foreach ($block['innerBlocks'] as $inner_block) {
                        if ( ! empty($inner_block['blockName'])) {
                            $block_name_parts = explode('/', $inner_block['blockName']);
                            $block_name = end($block_name_parts);

                            if (isset($block_assets[$block_name])) {
                                $used_blocks[$block_name] = true;
                            }
                        }
                    }
                }
            }
        }
    }

    // Also check blocks from template parts (header/footer)
    // This handles blocks that might be added via template parts
    $template_parts = [
        get_template_directory() . '/resources/views/sections/header.blade.php',
        get_template_directory() . '/resources/views/sections/footer.blade.php',
    ];

    foreach ($template_parts as $template_part) {
        if (file_exists($template_part)) {
            $content = file_get_contents($template_part);
            // Simple pattern matching for block usage in templates
            // This is a basic implementation - you might want to enhance this
            foreach (array_keys($block_assets) as $block_name) {
                if (strpos($content, $block_name) !== false && ! $block_assets[$block_name]['has_block_json']) {
                    $used_blocks[$block_name] = true;
                }
            }
        }
    }

    // Enqueue assets for detected unregistered blocks
    foreach (array_keys($used_blocks) as $block_name) {
        enqueue_block_assets($block_name);
    }
}

/**
 * Main function to enqueue all block assets
 *
 * @return void
 */
function enqueue_all_block_assets()
{
    enqueue_global_blocks();
    enqueue_conditional_blocks();
    enqueue_unregistered_blocks();
}

// Hook into wp_enqueue_scripts to load block assets
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_all_block_assets', 20);
