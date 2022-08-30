"use strict";

(function ($) {
  $(document).ready(function ($) {
    $(".baice-before-after-container").twentytwenty({
    	default_offset_pct: 0.5,
    	orientation: 'horizontal',
    	before_label: 'Before',
    	after_label: 'After',
    	no_overlay: false,
    	move_slider_on_hover: false,
    	move_with_handle_only: true,
    	click_to_move: false
    });
  });
})(jQuery);
