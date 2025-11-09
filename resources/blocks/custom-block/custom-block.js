/**
 * Custom Block - Frontend JavaScript
 * Unregistered block - no block.json, assets loaded when block is used
 */

document.addEventListener('DOMContentLoaded', () => {
	const customBlocks = document.querySelectorAll('.c-custom-block');

	customBlocks.forEach((block) => {
		// Add animation class on load
		block.classList.add('is-animated');

		// Add click handler to button
		const button = block.querySelector('.custom-block_button');

		if (button) {
			button.addEventListener('click', (e) => {
				e.preventDefault();

				// Add click animation
				if (window.gsap) {
          gsap.to(button, {
            scale: 0.95,
            duration: 0.1,
            yoyo: true,
            repeat: 1,
            ease: 'power2.inOut',
          });
				} else {
					button.style.transform = 'scale(0.95)';
					setTimeout(() => {
						button.style.transform = 'scale(1)';
					}, 200);
				}

				console.log('Custom Block button clicked!');
			});
		}

		// Intersection observer for scroll animations
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

		console.log('Custom Block initialized (unregistered block)');
	});
});

