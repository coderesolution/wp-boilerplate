<?php

declare(strict_types=1);
/**
 * Block: Demo Block <sage/demo-block>
 *
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during backend preview render.
 * @var int $post_id The post ID the block is rendering content against.
 * @var array $context The context provided to the block by the post or its parent block.
 */

// Get ACF fields
$acf = get_fields();

// Get block ID
$block_id = 'demo-block-' . $block['id'];
if ( ! empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Get block classes
$classes = ['c-demo-block'];
if ( ! empty($block['className'])) {
    $classes[] = $block['className'];
}
if ( ! empty($block['align'])) {
    $classes[] = 'align' . $block['align'];
}

// Get ACF fields
$title = get_field('title') ?: 'Hello from Demo Block!';
$content = get_field('text') ?: 'This is a demo ACF block created in Sage. If you can see this, the auto-import is working!';
$background_color = get_field('background_color') ?: '#f093fb';

// Build wrapper attributes
$wrapper_attributes = get_block_wrapper_attributes([
    'id' => $block_id,
    'class' => implode(' ', $classes),
    'style' => 'background-color: ' . esc_attr($background_color) . ';',
]);

// Render Blade template
echo view('blocks.demo-block.demo-block', [
    'block' => $block,
    'block_id' => $block_id,
    'classes' => $classes,
    'wrapper_attributes' => $wrapper_attributes,
    'acf' => $acf,
    'title' => $title,
    'content' => $content,
    'background_color' => $background_color,
    'is_preview' => $is_preview,
    'post_id' => $post_id,
])->render();
