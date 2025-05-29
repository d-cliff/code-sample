jQuery(document).ready(function ($) {

    $(".faq-question").click(function () {
        var $faq = $(this).parent();
        var $answer = $faq.find(".faq-answer");
        
        if ($answer.is(":visible")) {
            $answer.slideUp(300);
            $faq.removeClass("active");
        } else {
            $answer.slideDown(300);
            $faq.addClass("active");
        }
    });

});