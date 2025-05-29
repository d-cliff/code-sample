(function($) {
    $(document).ready(function() {
        // Select elements with the "layout" class
        var layoutElements = $('.acf-flexible-content .layout, .acf-field-repeater .acf-row');

        // Check if layout elements are found
        if (layoutElements.length) {
            // Loop through each layout element
            layoutElements.each(function() {
                // Add the "-collapsed" class if it's not already there
                if (!$(this).hasClass('-collapsed')) {
                    $(this).addClass('-collapsed');
                }
            });
        }
    });
})(jQuery);