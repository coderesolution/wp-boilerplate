<header class="banner">
  <a class="brand" href="{{ home_url('/') }}">
    {!! $siteName !!}
  </a>

  @if (has_nav_menu('primary_navigation'))
    <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
    </nav>
  @endif
</header>

{{-- Header Block Example (Global - always loaded) --}}
<div class="c-header-block" data-cid="header-block-global">
  <div class="header-block_inner">
    <a href="{{ home_url('/') }}" class="header-block_logo">
      {!! $siteName !!}
    </a>
    <nav class="header-block_nav">
      <a href="{{ home_url('/') }}" class="header-block_link">Home</a>
      <a href="{{ home_url('/about') }}" class="header-block_link">About</a>
      <a href="{{ home_url('/contact') }}" class="header-block_link">Contact</a>
      <a href="{{ home_url('/blog') }}" class="header-block_cta">Blog</a>
    </nav>
  </div>
</div>
