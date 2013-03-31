(function($){

$.fn.pixaar = function(options) {
	
	var defaults = {
		mode: "pixelate",
		maxsize: 500
		};

	var settings = $.extend({}, defaults, options);
	
	return this.each(function() {
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
				// should return a url of new generated image or url of already
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
				});
			}
	});

	
	});
};

})(jQuery);