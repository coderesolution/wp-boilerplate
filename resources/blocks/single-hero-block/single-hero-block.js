/**
 * Single Hero Block - Frontend JavaScript
 * Conditional block - loaded on single.php template
 */

document.addEventListener('DOMContentLoaded', () => {
	const heroBlocks = document.querySelectorAll('.c-single-hero-block');

	heroBlocks.forEach((block) => {
		// Animate hero block on load
		const title = block.querySelector('.single-hero-block_title');
		const meta = block.querySelector('.single-hero-block_meta');
		const excerpt = block.querySelector('.single-hero-block_excerpt');
		const image = block.querySelector('.single-hero-block_image');

		if (window.gsap) {
			// Create timeline for hero animation
			const tl = gsap.timeline();

      // Set initial states
      gsap.set([title, meta, excerpt, image], { opacity: 0, y: 30 });

      // Animate in sequence
      tl.to(title, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        ease: 'power3.out',
      })
        .to(
          meta,
          {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: 'power3.out',
          },
          '-=0.4'
        )
        .to(
          excerpt,
          {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: 'power3.out',
          },
          '-=0.4'
        )
        .to(
          image,
          {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out',
          },
          '-=0.4'
        );

      // Parallax effect on scroll
      if (window.ScrollTrigger) {
        gsap.to(block, {
          yPercent: -50,
          ease: 'none',
          scrollTrigger: {
            trigger: block,
            start: 'top top',
            end: 'bottom top',
            scrub: true,
          },
        });
      }
		} else {
			// Fallback animation without GSAP
			[title, meta, excerpt, image].forEach((element, index) => {
				if (element) {
					setTimeout(() => {
						element.style.opacity = '1';
						element.style.transform = 'translateY(0)';
						element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
					}, index * 200);
				}
			});
		}

		console.log('Single Hero Block initialized');
	});
});

