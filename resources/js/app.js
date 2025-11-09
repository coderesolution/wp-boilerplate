/**
 * Main App
 * Handles all global functionality.
 */

// Import images and fonts
import.meta.glob(['../images/**', '../fonts/**']);

/*############ Section: Imports ############*/

// Import GSAP and plugins
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';
import { Observer } from 'gsap/Observer';

// Import Lenis smooth scroll
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

/*############ Section: Utilities Definition ############*/

// Import block helpers utility
import { createBlockHelpers } from './utils/block-helpers';

// Define Utilities Globally
window.utils = window.utils || {};

// Make block helpers available globally for block JS files
window.createBlockHelpers = createBlockHelpers;

// Check if the page has been reloaded
const isPageReload =
  performance.navigation.type === 1 ||
  performance.getEntriesByType('navigation')[0]?.type === 'reload';

const hasVisited = sessionStorage.getItem('hasVisited');
window.utils.hasVisited = hasVisited === 'true' && !isPageReload;

/*############ Section: GSAP ############*/

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.SplitText = SplitText;
window.Observer = Observer;

gsap.registerPlugin(SplitText, ScrollTrigger, Observer);

/*############ Section: Lenis Smooth Scroll ############*/

// Initialize Lenis smooth scroll
const lenis = new Lenis();

// Synchronize Lenis scrolling with GSAP's ScrollTrigger plugin
lenis.on('scroll', ScrollTrigger.update);

// Add Lenis's requestAnimationFrame (raf) method to GSAP's ticker
// This ensures Lenis's smooth scroll animation updates on each GSAP tick
gsap.ticker.add((time) => {
	lenis.raf(time * 1000); // Convert time from seconds to milliseconds
});

// Disable lag smoothing in GSAP to prevent any delay in scroll animations
gsap.ticker.lagSmoothing(0);

// Make Lenis available globally for blocks
window.lenis = lenis;

/*############ Section: Page Initialisation ############*/

// Test JavaScript - Remove after verifying Vite is working
console.log('🚀 Vite is working! JavaScript loaded successfully.');
console.log('🎬 GSAP version:', gsap.version);
console.log('📜 Lenis initialized');

// Track if page has been initialized to prevent double initialization
let pageInitialized = false;

// Function to initialize page (works for both fresh loads and prerendered pages)
function initPage() {
	// Prevent double initialization
	if (pageInitialized) {
		return;
	}
	pageInitialized = true;

	document.documentElement.classList.remove('is-loading');
	document.documentElement.classList.add('has-loaded');

	if (!window.utils.hasVisited) {
		console.log('🔄 Page has not been visited before');
	} else {
		console.log('🔄 Page has been visited before');
	}

	if (isPageReload) {
		console.log('🔄 Page has been reloaded');
	} else {
		console.log('🔄 Page has not been reloaded');
	}

	/*############ Section: Tests ############*/

	// Create GSAP test element
	const gsapTest = document.createElement('div');
	gsapTest.id = 'gsap-test';
	gsapTest.style.cssText = `
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px 50px;
    border-radius: 15px;
    font-weight: bold;
    font-size: 24px;
    z-index: 9999;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    cursor: pointer;
    text-align: center;
  `;
	gsapTest.innerHTML = `
    <div style="font-size: 48px; margin-bottom: 10px;">🎬</div>
    <div>GSAP is Working!</div>
    <div style="font-size: 14px; margin-top: 10px; opacity: 0.9;">Click to animate</div>
  `;
	document.body.appendChild(gsapTest);

  // Set initial state (scaled down and rotated)
  gsap.set(gsapTest, {
    scale: 0,
    rotation: -180,
    opacity: 0,
  });

  // Animate in
  gsap.to(gsapTest, {
    scale: 1,
    rotation: 0,
    opacity: 1,
    duration: 1,
    ease: 'back.out(1.7)',
  });

  // Click handler for interactive animation
  gsapTest.addEventListener('click', () => {
    gsap.to(gsapTest, {
      scale: 1.2,
      rotation: 360,
      duration: 0.5,
      ease: 'power2.out',
      yoyo: true,
      repeat: 1,
    });
  });

  // Continuous subtle animation
  gsap.to(gsapTest, {
    y: -10,
    duration: 2,
    ease: 'power1.inOut',
    yoyo: true,
    repeat: -1,
  });

  // Remove after 8 seconds
  setTimeout(() => {
    gsap.to(gsapTest, {
      scale: 0,
      opacity: 0,
      rotation: 180,
      duration: 0.5,
      ease: 'back.in(1.7)',
      onComplete: () => gsapTest.remove(),
    });
  }, 8000);

  console.log('✅ GSAP test animation started');

  // Set visited flag for future visits
  if (!window.utils.hasVisited) {
  	sessionStorage.setItem('hasVisited', 'true');
  }
}

if (document.readyState === 'complete') {
	initPage();
} else {
	document.addEventListener('DOMContentLoaded', () => {
		initPage();
	});
}
