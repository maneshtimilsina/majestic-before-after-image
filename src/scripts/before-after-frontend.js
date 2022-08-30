class MBAIWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				mainWrapper: '.mbai-before-after-wrap',
				container: '.mbai-before-after-container',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );
		return {
			$mainWrapper: this.$element.find( selectors.mainWrapper ),
			$container: this.$element.find( selectors.container ),
		};
	}

	bindEvents() {
		const data = this.elements.$mainWrapper.data('mbai');

		const { orientation, before_label, after_label, handler_offset, move_slider_on_hover } = data;

		this.elements.$container.twentytwenty( {
			default_offset_pct: handler_offset,
			orientation: orientation,
			before_label: before_label,
			after_label: after_label,
			move_slider_on_hover: move_slider_on_hover
		} );
	}
}

jQuery( window ).on( 'elementor/frontend/init', () => {
	const addMBAIWidgetHandler = ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( MBAIWidgetHandlerClass, {
			$element,
		} );
	};

	elementorFrontend.hooks.addAction(
		'frontend/element_ready/mbai-before-after-image.default',
		addMBAIWidgetHandler
	);
} );
