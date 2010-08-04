/**
* Anonymous function that is immediately called
* makes sure that we can use the $-shortcut for jQuery.
*/
(function($) {

	/**
	* Rights tooltip plugin.
	* @param Object options Plugin options
	* @return the jQuery element
	*/
	$.fn.rightsTooltip = function(options) {

		// Default values
		var defaults = {
			title: '',
		};

		// Merge the options with the defaults
		var settings = $.extend(defaults, options);

		// Run this for each selected element
		return this.each(function() {

			var $this = $(this);
			var title = this.title;
			var $tooltip;

			// Make sure the item has a title
			if( $this.attr('title').length>0 ) {

				// Empty the title
                this.title = '';

                // Actions to be taken when hovering
                $this.hover(function(e) {

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
					$tooltip.css({
						top: e.pageY+10,
						left: e.pageX+20
					})
					.fadeIn(350);
                }, function() {

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
	* @return the jQuery element
	*/
	$.fn.rightsSortableTable = function(options) {

		// Default settings
		var defaults = {
			handle: '',
			placeholder: 'sortablePlaceholder',
		};

		// Merge the options with the defaults
		var settings = $.extend(defaults, options);

		// Run this for each selected element
		return this.each(function() {

			var $this = $(this);
			var $tbody = $this.find('tbody');

			// Apply jui sortable on the element
			$tbody.sortable({
				axis: 'y',
				containment: 'parent',
				cursor: 'pointer',
				delay: 100,
				distance: 5,
				forceHelperSize: true,
				forcePlaceholderSize: true,
				tolerance: 'pointer',
				handle: settings.handle,
				placeholder: settings.placeholder,
				// Helper function to set correct column widths while dragging
				helper: function(e, tr) {
					var $helper = tr.clone();
					$helper.children().each(function(index) {
						$(this).width(tr.children().eq(index).width());
					});
					return $helper;
				},
				// Actions to be taken when the row is dropped
				update: function(e, ui) {
					// Run an Ajax require to save the new weights
					$.ajax({
						type: "POST",
						url: settings.url,
						data: { result:$tbody.sortable('toArray') }
					});
				},
				// Actions to be taken when sorting is stopped
				stop: function(e, ui) {
					// Update the row classes
					$tbody.children().each(function(index) {
						index%2===0 ? $(this).removeClass('even').addClass('odd') : $(this).removeClass('odd').addClass('even');
					});
				}
			})
			.disableSelection();
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
			$(this).addClass('hover'); // On mouse over
		}, function() {
			$(this).removeClass('hover'); // On mouse out
		});

		/**
		* Fade effect for flash messages.
		*/
   		$('.rights .flash').animate({ opacity: 1.0 }, { duration: 3000 })
   		.fadeOut(650);

   		/**
   		* Checkbox functionality for the generate item table.
   		*/
   		$('.rights .generateItemTable').find('td.nameColumn, td.pathColumn').toggle(function(e) {
			$(this).parent('tr').find('input[type=checkbox]').attr('checked', 'checked');
		}, function(e) {
			$(this).parent('tr').find('input[type=checkbox]').removeAttr('checked');
		})
		.disableSelection();

	});

})(jQuery);