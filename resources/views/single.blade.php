@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    {{-- Single Hero Block Example (Conditional - loaded on single.php template) --}}
    <div class="c-single-hero-block" data-cid="single-hero-block-conditional">
      <div class="single-hero-block_inner">
        <h1 class="single-hero-block_title">{{ get_the_title() }}</h1>
        <div class="single-hero-block_meta">
          <div class="single-hero-block_meta-item">
            <span>{{ get_the_date() }}</span>
          </div>
          <div class="single-hero-block_meta-item">
            <span>By {{ get_the_author() }}</span>
          </div>
        </div>
        @if (has_excerpt())
          <div class="single-hero-block_excerpt">
            {{ get_the_excerpt() }}
          </div>
        @endif
        @if (has_post_thumbnail())
          <div class="single-hero-block_image">
            {!! get_the_post_thumbnail(get_the_ID(), 'large') !!}
          </div>
        @endif
      </div>
    </div>

    @includeFirst(['partials.content-single-' . get_post_type(), 'partials.content-single'])
  @endwhile
@endsection
