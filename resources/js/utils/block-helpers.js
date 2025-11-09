/**
 * Block Helpers Utility
 *
 * Provides helper methods for working with block elements.
 * These helpers scope queries to the block's light DOM.
 */

/**
 * Creates helper methods for a block element.
 *
 * @param {HTMLElement} block - The block element to add helpers to.
 * @returns {Object} Object containing helper methods.
 */
export function createBlockHelpers(block) {
	if (!block || !(block instanceof HTMLElement)) {
		throw new Error('Block element is required and must be an HTMLElement');
	}

	/**
   * Queries the block's light DOM for elements matching the selector.
   *
   * @param {string} selector - The CSS selector to match elements against.
   * @returns {NodeList} A NodeList of matching elements.
   */
	const $ = (selector) => {
		if (!selector) {
			return new NodeList();
		}
		return block.querySelectorAll(selector);
	};

	/**
   * Queries the block's light DOM for a single element matching the selector.
   *
   * @param {string} selector - The CSS selector to match elements against.
   * @returns {Element|null} A single matching element, or null if no elements are found.
   */
	const $one = (selector) => {
		if (!selector) {
			return null;
		}
		return block.querySelector(selector);
	};

	/**
   * Queries the block's light DOM for a single element with the specified data-ref attribute.
   *
   * @param {string} attr - The value of the data-ref attribute to match against.
   * @returns {Element|null} A single matching element or null if not found.
   */
	const ref = (attr) => {
		if (!attr) {
			return null;
		}
		const selector = `[data-ref="${attr}"]`;
		return block.querySelector(selector);
	};

	/**
   * Queries the block's light DOM for all elements with the specified data-ref attribute.
   *
   * @param {string} attr - The value of the data-ref attribute to match against.
   * @returns {NodeList} A NodeList of matching elements.
   */
	const refs = (attr) => {
		if (!attr) {
			return new NodeList();
		}
		const selector = `[data-ref="${attr}"]`;
		return block.querySelectorAll(selector);
	};

	/**
   * Event listeners registry for cleanup.
   */
	const _eventListeners = [];

	/**
   * Adds an event listener to elements within the block.
   *
   * @param {string} type - The event type.
   * @param {HTMLElement|NodeList|string|Window|Document} target - The element(s), selector, window, or document to attach the event listener to.
   * @param {Function} handler - The event handler function.
   * @param {Object} options - Optional event listener options.
   */
	const on = (type, target, handler, options = {}) => {
		if (!type || !handler) {
			console.error('Event type and handler are required');
			return;
		}

		let elements = [];

		// Handle window or document (special cases)
		if (target === window || target === document) {
			elements = [target];
		}
		// Handle string selector
		else if (typeof target === 'string') {
			elements = Array.from($(target));
		}
		// Handle NodeList
		else if (target instanceof NodeList) {
			elements = Array.from(target);
		}
		// Handle single element
		else if (target instanceof HTMLElement) {
			elements = [target];
		}
		// Handle array of elements
		else if (Array.isArray(target)) {
			elements = target.filter(
				(el) => el instanceof HTMLElement || el === window || el === document
			);
		} else {
			console.error('Invalid target for event listener:', target);
			return;
		}

		// Use passive listeners for scroll events to improve performance
		const listenerOptions =
      type === 'scroll' ? { passive: true, ...options } : options;

		elements.forEach((element) => {
			if (element) {
				element.addEventListener(type, handler, listenerOptions);
				_eventListeners.push({
          type,
          element,
          handler,
          options: listenerOptions,
        });
			}
		});
	};

	/**
   * Removes an event listener from elements within the block.
   *
   * @param {string} type - The event type.
   * @param {HTMLElement|NodeList|string|Window|Document} target - The element(s), selector, window, or document to remove the event listener from.
   * @param {Function} handler - The event handler function.
   */
	const off = (type, target, handler) => {
		if (!type || !handler) {
			return;
		}

		let elements = [];

		// Handle window or document (special cases)
		if (target === window || target === document) {
			elements = [target];
		}
		// Handle string selector
		else if (typeof target === 'string') {
			elements = Array.from($(target));
		}
		// Handle NodeList
		else if (target instanceof NodeList) {
			elements = Array.from(target);
		}
		// Handle single element
		else if (target instanceof HTMLElement) {
			elements = [target];
		}
		// Handle array of elements
		else if (Array.isArray(target)) {
			elements = target.filter(
				(el) => el instanceof HTMLElement || el === window || el === document
			);
		}

		elements.forEach((element) => {
			const listenerIndex = _eventListeners.findIndex(
				(listener) =>
					listener.type === type &&
          listener.element === element &&
          listener.handler === handler
			);

			if (listenerIndex !== -1) {
				const listener = _eventListeners[listenerIndex];
				element.removeEventListener(
					listener.type,
					listener.handler,
					listener.options
				);
				_eventListeners.splice(listenerIndex, 1);
			}
		});
	};

	return {
    $,
    $one,
    ref,
    refs,
    on,
    off,
  };
}
