<?php

declare(strict_types=1);
/**
 * Block: Test Block <sage/test-block>
 *
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during backend preview render.
 * @var int $post_id The post ID the block is rendering content against.
 * @var array $context The context provided to the block by the post or its parent block.
 */

// Get block ID
$block_id = 'test-block-' . $block['id'];
if ( ! empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Get block classes
$classes = ['c-test-block'];
if ( ! empty($block['className'])) {
    $classes[] = $block['className'];
}
if ( ! empty($block['align'])) {
    $classes[] = 'align' . $block['align'];
}

// Get ACF fields
$title = get_field('title') ?: 'Hello from Test Block!';
$content = get_field('text') ?: 'This is a custom ACF block created in Sage. If you can see this, ACF blocks are working!';
$background_color = get_field('background_color') ?: '#667eea';

// Note: Blade's {{ }} auto-escapes HTML, so we pass raw values
// For content that needs HTML, we use wp_kses_post in the Blade template

// Get Vite asset
use Illuminate\Support\Facades\Vite;

$asset = Vite::asset('resources/images/test.svg');

// Build wrapper attributes
$wrapper_attributes = get_block_wrapper_attributes([
    'id' => $block_id,
    'class' => implode(' ', $classes),
    'style' => 'background-color: ' . esc_attr($background_color) . ';',
]);

// Render template with InnerBlocks
// Note: JSX syntax <InnerBlocks /> must be directly in PHP template for ACF to process it
?>
<section <?php echo $wrapper_attributes; ?>>
    <div class="test-block_inner">
        <?php if ( ! empty($asset)) { ?>
            <img src="<?php echo esc_url($asset); ?>" alt="Test Image">
        <?php } ?>
        <h2 class="test-block_title"><?php echo esc_html($title); ?></h2>
        <div class="test-block_content bg-yellow-500">
            <?php echo wp_kses_post($content); ?>
        </div>
        <div class="test-block_innerblocks">
            <InnerBlocks />
        </div>
    </div>
</section>
<?php
