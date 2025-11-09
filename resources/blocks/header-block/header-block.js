/**
 * Header Block - Frontend JavaScript
 * Global block - loaded on all pages
 *
 * Example usage of block helpers utility ($, $one, on, off, etc.)
 * Block helpers are available globally via window.createBlockHelpers
 */

document.addEventListener('DOMContentLoaded', () => {
	const headerBlocks = document.querySelectorAll('.c-header-block');

	headerBlocks.forEach((block) => {
		// Create block helpers - this gives us $, $one, ref, refs, on, off, etc.
		// Block helpers are available globally from app.js
		const { $, $one, on, off } = window.createBlockHelpers(block);

		// Example: Using $one to get a single element
		const logo = $one('.header-block_logo');
		const nav = $one('.header-block_nav');

		// Example: Using $ to get multiple elements
		const navLinks = $('.header-block_link');
		const ctaButton = $one('.header-block_cta');

		console.log(logo, nav, navLinks, ctaButton);

		// Add scroll effect to header
		let lastScroll = 0;
		let ticking = false;

		function handleScroll() {
			const currentScroll = window.scrollY;

			if (currentScroll > 100) {
				block.classList.add('is-scrolled');
			} else {
				block.classList.remove('is-scrolled');
			}

			// Hide/show header on scroll
			if (currentScroll > lastScroll && currentScroll > 200) {
				block.classList.add('is-hidden');
			} else {
				block.classList.remove('is-hidden');
			}

			lastScroll = currentScroll;
			ticking = false;
		}

		// Example: Using on() helper for event listeners
		on('scroll', window, () => {
			if (!ticking) {
				window.requestAnimationFrame(handleScroll);
				ticking = true;
			}
		});

		// Example: Adding hover effect to CTA button
		if (ctaButton) {
			on('mouseenter', ctaButton, () => {
				ctaButton.style.transform = 'scale(1.05)';
			});

			on('mouseleave', ctaButton, () => {
				ctaButton.style.transform = 'scale(1)';
			});
		}

		// Example: Using ref() helper if you have data-ref attributes
		// const menuButton = ref('menu-toggle');
		// const mobileNav = ref('mobile-nav');

		console.log('Header Block initialized with block helpers');
	});
});
