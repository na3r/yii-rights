(function($) {

	/**
	* Rights tooltip plugin.
	* @param Object options Plugin options
	* @return this
	*/
	$.fn.rightsTooltip = function(options) {

		// Default values
		var defaults = {
			title: '',
		};

		var settings = $.extend(defaults, options);

		return this.each(function() {

			var $this = $(this);
			var title = this.title;
			var $tooltip;

			// Make sure the item has a title
			if( $this.attr('title').length>0 ) {

				// Empty the title
                this.title = '';

                // Bind a hover function
                $this.hover(function(e) {

                	// Mouse over

                	// Build the tooltip and append it to the body
					$tooltip = $('<div id="rightsTooltip" />')
					.appendTo('body')
					.hide();

					// Check if we have a title
					if( settings.title.length>0 ) {

						// If so, append it to the tooltip
						$('<span class="heading" />')
						.appendTo($tooltip)
						.text(settings.title);

					}

					// Append the content to the tooltip
					$('<span class="content" />')
					.appendTo($tooltip)
					.text(title);

					// Set the tooltip position and fade it in
					$tooltip
					.css({
						top: e.pageY+10,
						left: e.pageX+20
					})
					.fadeIn(350);

                }, function() {

                	// Mouse out

                	// Remove the tooltip
                    $tooltip.remove();

                });

                // Bind a mouse move function
                $this.mousemove(function(e) {

                	// Move the tooltip relative to the mouse
	                $tooltip.css({
	                    top: e.pageY+10,
	                    left: e.pageX+20
	                });

            	});
            }
		});
	}

	/**
	* Actions to be taken when the document is loaded.
	*/
	$(document).ready(function() {

		/**
		* Hover functionality for rights' tables.
		*/
		$('.rights tbody tr').hover(function() {

			$(this).addClass('hover');

		}, function() {

			$(this).removeClass('hover');

		});

	});

})(jQuery);