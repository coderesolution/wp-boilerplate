{{-- Block: Single Hero Block <sage/single-hero-block> --}}

<section {!! $wrapper_attributes !!}>
    <div class="single-hero-block_inner">
        @if ($title)
            <h1 class="single-hero-block_title">{{ $title }}</h1>
        @endif

        <div class="single-hero-block_meta">
            @if ($post_date)
                <div class="single-hero-block_meta-item">
                    <span>{{ $post_date }}</span>
                </div>
            @endif

            @if ($post_author)
                <div class="single-hero-block_meta-item">
                    <span>By {{ $post_author }}</span>
                </div>
            @endif
        </div>

        @if ($excerpt)
            <div class="single-hero-block_excerpt">
                {!! wp_kses_post($excerpt) !!}
            </div>
        @endif

        @if ($image)
            <div class="single-hero-block_image">
                <img src="{{ esc_url($image) }}" alt="{{ esc_attr($title) }}" />
            </div>
        @endif
    </div>
</section>
