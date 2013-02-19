(function($){

$.fn.pixaar = function(options) {


	// need black and white and blur
	var defaults = {
		mode: "pixelate",
		maxsize: 500
		}

	// merge default and user parameters
	var settings = $.extend({}, defaults, options);
	
	return this.each(function() {
		// express a single node as a jQuery object
		var $t = $(this);
		$t.wrap('<div class="pixaarFrame" />');
		var src = $t.attr('src');
		var frame = $(this).parent();
		// var mode = defaults.mode;
	// alert(mode);
		$.ajax({
			type:"POST",
			url:"js/pixaar/pixaar.php",
			data:{src:src, mode:"bwpix"},
			success:function(response){
				// should return a url of new generated image
				alert(response);
				var newImg = $("<img class='pixaarAlt'>");
				newImg.attr('src', response);
				frame.append(newImg);
				newImg.on({
					mouseenter: function()
					{
						$(this).fadeTo('slow',0);
					},
					mouseleave: function()
					{
						$(this).fadeTo('slow',1);
					}
				})
			}
		});
	});

	// allow jQuery chaining
	return this;

}

})(jQuery)


// example
// $("p").reverseText( { minlength: 0, maxlength: 100 } );