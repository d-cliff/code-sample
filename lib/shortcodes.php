<?php 

// Phone Number
add_shortcode('phone', 'built_phone_number');
function built_phone_number() {
    ob_start(); 

    $phn = get_field('phone', 'options');
    
    if($phn) { echo '<a class="phone" href="tel:' . $phn . '"><i class="fas fa-phone-flip"></i> ' . $phn . '</a>'; } 

    return ob_get_clean();
}

// Social Media Icons
add_shortcode('social_media_icons', 'social_media_icons_shortcode');
function social_media_icons_shortcode() {
    // Get the 'social_media' field group
    $social_media = get_field('social_media', 'options');

    if ($social_media) {
        $output = '<div class="social-media-icons">';

        // Loop through each social media field and display its icon
        foreach ($social_media as $platform => $url) {
            if ($url) {
                // Choose icon based on platform
                switch ($platform) {
                    case 'facebook':
                        $icon = 'fab fa-facebook-f';
                        break;
                    case 'instagram':
                        $icon = 'fab fa-instagram';
                        break;
                    case 'youtube':
                        $icon = 'fab fa-youtube';
                        break;
                    case 'x':
                        $icon = 'fab fa-x-twitter';
                        break;
                    case 'linkedin':
                        $icon = 'fab fa-linkedin-in';
                        break;
                    default:
                        $icon = '';
                        break;
                }

                // Add the icon to the output
                $output .= '<a href="' . esc_url($url) . '" target="_blank" class="social-media-icon">';
                $output .= '<i class="' . esc_attr($icon) . '"></i>';
                $output .= '</a>';
            }
        }

        $output .= '</div>';

        return $output;
    }

    return ''; // Return empty if no social media links are set
}

// Google Reviews
add_shortcode('google_reviews', 'fetch_google_reviews');
function fetch_google_reviews($atts) {
    $atts = shortcode_atts(
        array(
            'place_id' => 'YOUR_PLACE_ID',
            'api_key' => 'YOUR_API_KEY',
        ), 
        $atts, 
        'google_reviews'
    );

    $place_id = $atts['place_id'];
    $api_key = $atts['api_key'];

    $response = wp_remote_get("https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&key={$api_key}");
    
    if (is_wp_error($response)) {
        return 'Unable to retrieve reviews.';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['error_message'])) {
        return 'Error: ' . $data['error_message'];
    }

    $reviews = $data['result']['reviews'];

    if (empty($reviews)) {
        return 'No reviews found.';
    }

    $output = '<div class="ggl-rvws">';
    foreach ($reviews as $review) {
        $output .= '<div class="rvw">';
        $output .= 'class="rvw-rtg">';
        for ($i=0; $i < $review['text']; $i++) { 
            $output .= '<i class="fas fa-star"></i>';
        }
        $output .= '</div>';
        $output .= '<div class="rvw-dte">' . esc_html(date('F j, Y', strtotime($review['time']))) . '</div>';
        $output .= '<p>' . esc_html() . '</p>';
        $output .= '<h5>' . esc_html($review['author_name']) . '</h5>';
        $output .= '<i class="fab fa-google"></i>';
        $output .= '</div>';
    }
    $output .= '</div>';

    return $output;
}

?>