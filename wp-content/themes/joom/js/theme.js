/* Copyright (C) YOOtheme GmbH, http://www.gnu.org/licenses/gpl.html GNU/GPL */

jQuery(function($) {

    var config = $('html').data('config') || {};

    // Social buttons
    $('article[data-permalink]').socialButtons(config);

});


jQuery(function($){
	$(window).on('scroll', function(){
		if( $(window).scrollTop()>50 ){
			$('.tm-headerbar-bg').addClass('menu-fixed');
		} else {
			$('.tm-headerbar-bg').removeClass('menu-fixed');
		}
	});

	
	
});

 //To top scroller//////////////////////////
jQuery(document).ready(function($) {
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() === 0) {
            jQuery(".tm-totop-scroller").addClass("totop-idden");
        } else {
            jQuery(".tm-totop-scroller").removeClass("totop-hidden");
        }
    });

});