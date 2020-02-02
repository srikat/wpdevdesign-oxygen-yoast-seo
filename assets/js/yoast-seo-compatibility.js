(function($){
	YoastOxygen = function() {
		if(typeof(YoastSEO) !== 'undefined') {
			YoastSEO.app.registerPlugin( 'YoastOxygen', {status: 'ready'} );
			YoastSEO.app.registerModification( 'content', this.replaceDataWithOxygenMarkup, 'YoastOxygen', 5 );
		}
	}

	/**
	 * Adds Oxygen generated markup to WordPress content.
	 *
	 * @param data The data to modify
	 */
	YoastOxygen.prototype.replaceDataWithOxygenMarkup = function(data) {
		// The full Oxygen generated markup is already enqueued
		return data + ysco_data.oxygen_markup;
	};

	$(document).ready(function(){
		new YoastOxygen();
	});
})(jQuery);
