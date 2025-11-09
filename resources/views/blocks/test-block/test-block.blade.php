{{-- Block: Test Block <sage/test-block> --}}

<section {!! $wrapper_attributes !!}>
    <div class="test-block_inner">
        @if (!empty($asset))
            <img src="{{ $asset }}" alt="Test Image">
        @endif
        <h2 class="test-block_title">{{ $title }}</h2>
        <div class="test-block_content bg-yellow-500">
            {!! wp_kses_post($content) !!}
        </div>
        <div class="test-block_innerblocks">
            {{-- INNERBLOCKS_PLACEHOLDER --}}
        </div>
    </div>
</section>
