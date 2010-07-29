/**
* Anonymous function that is immediately called
* makes sure that we can use the $-shortcut for jQuery.
*/
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
	* Rights sortable table plugin that uses of jui-sortable.
	* @param Object options Plugin options
	* @return this
	*/
	$.fn.rightsSortableTable = function(options) {

		var defaults = {
			handle: ''
		};

		var settings = $.extend(defaults, options);

		return this.each(function() {

			var $this = $(this);
			var $tbody = $this.find('tbody');

			$tbody.sortable({
				// Set the handle
				handle: settings.handle,
				// Helper function to correct row width while dragging
				helper: function(e, tr) {
					var $helper = tr.clone();
					var $children = tr.children();
					$helper.children().each(function(index) {
						$(this).width($children.eq(index).width())
					});
					return $helper;
				},
				// Actions to be taken when the row is dropped
				update: function(e, ui) {
					$.ajax({ type:"POST", url:settings.url, data:{ result:$tbody.sortable('toArray') } });
					$tbody.find('tr:odd').removeClass('odd').addClass('even');
					$tbody.find('tr:even').removeClass('even').addClass('odd');
				}
			})
			.disableSelection();
		});

		return this;
	}

	/**
	* Actions to be taken when the document is loaded.
	*/
	$(document).ready(function() {

		/**
		* Hover functionality for rights' tables.
		*/
		$('.rights tbody tr').hover(function() {

			$(this).addClass('hover'); // On mouse over

		}, function() {

			$(this).removeClass('hover'); // On mouse out

		});

		/**
		* Fade effect for flash messages.
		*/
   		$('.rights .flash').animate({
   			opacity: 1.0
   		}, {
   			duration: 3000
   		})
		.fadeOut(650);

	});

})(jQuery);