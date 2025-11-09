<?php

declare(strict_types=1);
/**
 * Block: Single Hero Block <sage/single-hero-block>
 *
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during backend preview render.
 * @var int $post_id The post ID the block is rendering content against.
 * @var array $context The context provided to the block by the post or its parent block.
 */

// Get block ID
$block_id = 'single-hero-block-' . $block['id'];
if ( ! empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Get block classes
$classes = ['c-single-hero-block'];
if ( ! empty($block['className'])) {
    $classes[] = $block['className'];
}
if ( ! empty($block['align'])) {
    $classes[] = 'align' . $block['align'];
}

// Get post data
$post_title = get_the_title();
$post_date = get_the_date();
$post_author = get_the_author();
$post_excerpt = get_the_excerpt();
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'large');

// Get ACF fields (if any)
$custom_title = get_field('title');
$custom_excerpt = get_field('excerpt');
$custom_image = get_field('image');

// Use custom fields if available, otherwise use post data
$title = $custom_title ?: $post_title;
$excerpt = $custom_excerpt ?: $post_excerpt;
$image = $custom_image ?: $featured_image;

// Build wrapper attributes
$wrapper_attributes = get_block_wrapper_attributes([
    'id' => $block_id,
    'class' => implode(' ', $classes),
]);

// Render Blade template
echo view('blocks.single-hero-block.single-hero-block', [
    'block' => $block,
    'block_id' => $block_id,
    'classes' => $classes,
    'wrapper_attributes' => $wrapper_attributes,
    'title' => $title,
    'excerpt' => $excerpt,
    'image' => $image,
    'post_date' => $post_date,
    'post_author' => $post_author,
    'is_preview' => $is_preview,
    'post_id' => $post_id,
])->render();
