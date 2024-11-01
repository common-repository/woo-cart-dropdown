(function($) {

	$(document).ready(function(){
		// position dropdown based on anchor height
		var cartOuterHeight = $('.cart-contents').outerHeight();
		$('.dropdown-cart-wrapper').css('top', cartOuterHeight);
	});

})( jQuery );