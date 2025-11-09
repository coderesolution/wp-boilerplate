<footer class="content-info">
  @php(dynamic_sidebar('sidebar-footer'))
</footer>

{{-- Footer Block Example (Global - always loaded) --}}
<div class="c-footer-block" data-cid="footer-block-global">
  <div class="footer-block_inner">
    <div class="footer-block_content">
      <div class="footer-block_section">
        <h3 class="footer-block_title">About</h3>
        <p class="footer-block_text">
          This is an example footer block that demonstrates global block asset loading.
          The CSS and JS for this block are loaded on every page.
        </p>
      </div>
      <div class="footer-block_section">
        <h3 class="footer-block_title">Quick Links</h3>
        <div class="footer-block_links">
          <a href="{{ home_url('/') }}" class="footer-block_link">Home</a>
          <a href="{{ home_url('/about') }}" class="footer-block_link">About</a>
          <a href="{{ home_url('/contact') }}" class="footer-block_link">Contact</a>
          <a href="{{ home_url('/blog') }}" class="footer-block_link">Blog</a>
        </div>
      </div>
      <div class="footer-block_section">
        <h3 class="footer-block_title">Connect</h3>
        <div class="footer-block_links">
          <a href="#" class="footer-block_link">Twitter</a>
          <a href="#" class="footer-block_link">Facebook</a>
          <a href="#" class="footer-block_link">LinkedIn</a>
        </div>
      </div>
    </div>
    <div class="footer-block_bottom">
      <div class="footer-block_copyright">
        &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.
      </div>
      <div class="footer-block_social">
        <a href="#" class="footer-block_social-link">Twitter</a>
        <a href="#" class="footer-block_social-link">Facebook</a>
        <a href="#" class="footer-block_social-link">LinkedIn</a>
      </div>
    </div>
  </div>
</div>
