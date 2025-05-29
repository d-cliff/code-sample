jQuery(document).ready(function($) { 

    $('.reviews-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
        fade: true,
        adaptiveHeight: true,
        prevArrow: '<img class="prev" src="/wp-content/themes/bugsdrop/images/arrow-green.svg" />',
        nextArrow: '<img class="next" src="/wp-content/themes/bugsdrop/images/arrow-green.svg" />',
    });

});