/**
 * Footer Block - Frontend JavaScript
 * Global block - loaded on all pages
 */

document.addEventListener('DOMContentLoaded', () => {
	const footerBlocks = document.querySelectorAll('.c-footer-block');

	footerBlocks.forEach((block) => {
		// Smooth scroll to top functionality
		const scrollToTopBtn = block.querySelector('.footer-block_scroll-top');

		if (scrollToTopBtn) {
			scrollToTopBtn.addEventListener('click', (e) => {
				e.preventDefault();
				window.scrollTo({
          top: 0,
          behavior: 'smooth',
        });
			});

			// Show/hide scroll to top button based on scroll position
			let ticking = false;

			function handleScroll() {
				if (window.scrollY > 300) {
					scrollToTopBtn.classList.add('is-visible');
				} else {
					scrollToTopBtn.classList.remove('is-visible');
				}
				ticking = false;
			}

			window.addEventListener('scroll', () => {
				if (!ticking) {
					window.requestAnimationFrame(handleScroll);
					ticking = true;
				}
			});
		}

		// Animate footer on scroll into view
		const observer = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-visible');
					}
				});
			},
      {
        threshold: 0.1,
      }
		);

		observer.observe(block);

		console.log('Footer Block initialized');
	});
});
