jQuery(document).ready(function($) { 

    $('.slider').slick({
        centerMode: true,
        centerPadding: '0px',
        slidesToShow: 3,
        autoplay: false,
        autoplaySpeed: 7000,
        arrows: true,
        prevArrow: '<img class="prev" src="/wp-content/themes/bugsdrop/images/arrow-green.svg" />',
        nextArrow: '<img class="next" src="/wp-content/themes/bugsdrop/images/arrow-green.svg" />',
        infinite: true,
        responsive: [
            {
                breakpoint: 1100,
                settings: {
                    centerMode: false,
                    slidesToShow: 1
                }
            }
        ]
    });
     
});