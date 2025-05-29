jQuery(document).ready(function($) {

	$(document).ready(function ($) {
		function updateBannerMargin() {
			var $header = $('.site-header');
			var $firstSection = $('main').children().first();
	
			if ($firstSection.hasClass('banner overlay')) {
				var headerHeight = $header.outerHeight();
	
				// Apply negative margin dynamically
				$firstSection.css('margin-top', -headerHeight + 'px');
	
				// Ensure the header class is added
				$header.addClass('has-banner-overlay');

				$('.icon-cart').attr('src', '/wp-content/themes/bugsdrop/images/cart-icon-2.svg');
				$('.icon-user').attr('src', '/wp-content/themes/bugsdrop/images/user-icon-2.svg');
			}
		}
	
		// Run on page load
		updateBannerMargin();
	
		// Recalculate on window resize
		$(window).on('resize', function () {
			updateBannerMargin();
		});
	});
	
	$('.tp-br .nav-primary .menu-item-has-children > a span').each(function() {
		$(this).append('<i class="fa fa-angle-down"></i>'); 
    });
    
	var myLazyLoad = new LazyLoad({
	    elements_selector: ".lazy"
	});	  

	$('.mbl-mnu-trg-open').click(function() {		
		$('.mbl-mnu').addClass('open');
	});

	$('.mbl-mnu-trg-close').click(function() {		
		$('.mbl-mnu').removeClass('open');
	});

	$('a.btn[href^="tel:"]').prepend('<i class="fas fa-phone-flip"></i> ');
	
	$('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
		if(location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
		
			if(target.length) {
				event.preventDefault();
				$('html, body').animate({scrollTop: target.offset().top}, 1000, function() {
					var $target = $(target);
					$target.focus();

					if($target.is(":focus")) {
						return false;
					} else {
						$target.attr('tabindex','-1');
						$target.focus();
					};
				});
			}
		}
	});
});