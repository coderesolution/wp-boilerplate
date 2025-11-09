<?php

declare(strict_types=1);

/**
 * Auto-register all blocks from block.json files.
 *
 * Scans the resources/views/blocks directory and automatically registers
 * all blocks that have a block.json file using register_block_type_from_metadata().
 *
 * Works for both ACF blocks and regular WordPress blocks.
 *
 * @return void
 */
add_action('acf/init', function () {
    $blocks_dir = get_template_directory() . '/resources/views/blocks';

    if ( ! is_dir($blocks_dir)) {
        return;
    }

    // Scan for all block directories.
    $block_dirs = glob($blocks_dir . '/*', GLOB_ONLYDIR);

    foreach ($block_dirs as $block_dir) {
        $block_json = $block_dir . '/block.json';

        // Only register blocks that have a block.json file.
        if (file_exists($block_json)) {
            // Use register_block_type() which internally uses register_block_type_from_metadata()
            // when given a path to a folder containing block.json.
            register_block_type($block_dir);
        }
    }
});
