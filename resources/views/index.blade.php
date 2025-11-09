@extends('layouts.app')

@section('content')
    {{-- Tailwind Test Banner - Remove after verifying Tailwind is working --}}
    <div
        class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white p-6 rounded-lg shadow-2xl mb-8 mx-4 text-center">
        <h2 class="text-3xl font-bold mb-2">🎨 Tailwind CSS is Working!</h2>
        <p class="text-lg opacity-90">If you see this styled banner, Tailwind is successfully compiled and working.</p>
        <div class="mt-4 flex justify-center gap-4">
            <span class="bg-white text-purple-600 px-4 py-2 rounded-full font-semibold">Gradient</span>
            <span class="bg-white text-pink-600 px-4 py-2 rounded-full font-semibold">Rounded</span>
            <span class="bg-white text-red-600 px-4 py-2 rounded-full font-semibold">Shadow</span>
        </div>
    </div>

    {!! do_shortcode('[contact-form-7 id="c32263b" title="Contact form 1"]') !!}

    @include('partials.page-header')

    @if (!have_posts())
        <x-alert type="warning">
            {!! __('Sorry, no results were found.', 'sage') !!}
        </x-alert>

        {!! get_search_form(false) !!}
    @endif

    @while (have_posts())
        @php(the_post())
        @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
    @endwhile

    {!! get_the_posts_navigation() !!}
@endsection

@section('sidebar')
    @include('sections.sidebar')
@endsection
