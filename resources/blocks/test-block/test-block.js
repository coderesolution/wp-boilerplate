/**
 * Test Block - Frontend JavaScript
 *
 * This script runs on the frontend when the block is rendered.
 */

document.addEventListener('DOMContentLoaded', () => {
	// Find all test blocks on the page
	const testBlocks = document.querySelectorAll('.c-test-block');

	testBlocks.forEach((block) => {
		console.log(block);
		// Add a click handler to demonstrate interactivity
		block.addEventListener('click', () => {
			// Toggle a class to show it's working
			block.classList.toggle('is-clicked');

			// Add a visual indicator
			const indicator = document.createElement('div');
			indicator.className = 'test-block_js-indicator';
			indicator.textContent = '✅ JS Working!';
			indicator.style.cssText = `
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        z-index: 10;
        pointer-events: none;
      `;

			// Remove any existing indicator
			const existing = block.querySelector('.test-block_js-indicator');
			if (existing) {
				existing.remove();
			}

			// Add new indicator
			block.style.position = 'relative';
			block.appendChild(indicator);

			// Remove indicator after 2 seconds
			setTimeout(() => {
				indicator.style.transition = 'opacity 0.3s';
				indicator.style.opacity = '0';
				setTimeout(() => indicator.remove(), 300);
			}, 2000);

			console.log('Test Block clicked! JavaScript is working.');
		});

		// Add hover effect
		block.addEventListener('mouseenter', () => {
      gsap.to(block, {
        scale: 1.02,
        duration: 0.2,
        ease: 'power2.inOut',
      });
			// block.style.transform = 'scale(1.02)';
			// block.style.transition = 'transform 0.2s ease';
		});

		block.addEventListener('mouseleave', () => {
      gsap.to(block, {
        scale: 1,
        duration: 0.2,
        ease: 'power2.inOut',
      });
			// block.style.transform = 'scale(1)';
		});

		console.log('Test Block JavaScript initialized');
	});
});
