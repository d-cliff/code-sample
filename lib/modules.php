<?php

add_action('genesis_header', 'built_header_modules', 5);
function built_header_modules() { 

} 

add_action('genesis_loop', 'built_content_modules', 5);
function built_content_modules() { 

    if(have_rows('modules')) {
    
        while(have_rows('modules')) { the_row();

                if(get_row_layout() == 'banner') { include('modules/banner.php'); }
            elseif(get_row_layout() == 'content') { include('modules/content.php'); }
            elseif(get_row_layout() == 'faqs') { include('modules/faqs.php'); }
            elseif(get_row_layout() == 'list') { include('modules/list.php'); }
            elseif(get_row_layout() == 'reviews') { include('modules/reviews.php'); }
            elseif(get_row_layout() == 'slider') { include('modules/slider.php'); }
        }
    }
} 

?>