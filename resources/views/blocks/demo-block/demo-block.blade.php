{{-- Block: Demo Block <sage/demo-block> --}}

<section {!! $wrapper_attributes !!}>
    <div class="demo-block_inner">
        <h2 class="demo-block_title text-lagoon">{{ $title }}</h2>
        <div class="demo-block_content bg-red-500">
            {!! wp_kses_post($content) !!}
        </div>
        {{-- Test output() helper directly in Blade --}}
        <div style="margin: 20px 0; padding: 15px; background: #d4edda; border: 1px solid #28a745; border-radius: 5px;">
            <strong>Blade output() test (direct):</strong>
            {!! output([
                'test_type' => 'Blade direct output',
                'timestamp' => current_time('mysql'),
                'acf' => $acf,
                'block_id' => $block_id,
                'is_preview' => $is_preview,
            ], true) !!}
        </div>
    </div>
</section>
