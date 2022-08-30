class MBAIWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				mainWrapper: '.baice-before-after-wrap',
				container: '.baice-before-after-container',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings('selectors');
		return {
			$mainWrapper: this.$element.find(selectors.mainWrapper),
			$container: this.$element.find(selectors.container),
		};
	}

	bindEvents() {
		console.log('here');

		this.elements.$container.twentytwenty({
			default_offset_pct: 0.5,
			orientation: 'horizontal',
			before_label: 'Before',
			after_label: 'After',
			no_overlay: false,
			move_slider_on_hover: false,
			move_with_handle_only: true,
			click_to_move: false
		});

	}
}

jQuery(window).on('elementor/frontend/init', () => {
	const addMBAIWidgetHandler = ($element) => {
		elementorFrontend.elementsHandler.addHandler(MBAIWidgetHandlerClass, {
			$element,
		});
	};

	elementorFrontend.hooks.addAction(
		'frontend/element_ready/mbai-before-after.default',
		addMBAIWidgetHandler
	);
});
