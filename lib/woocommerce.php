<?php

// Remove WooCommerce SelectWoo (WC's customized Select2)
add_action('wp_enqueue_scripts', 'remove_woocommerce_select2', 100);
function remove_woocommerce_select2() {
    wp_dequeue_style('select2');
    wp_deregister_style('select2');
    wp_dequeue_script('select2');
    wp_deregister_script('select2');
    wp_dequeue_script('selectWoo');
    wp_deregister_script('selectWoo');
    wp_dequeue_style('selectWoo');
    wp_deregister_style('selectWoo');
    wp_dequeue_style('woocommerce-general');
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-smallscreen');
    wp_dequeue_style('wc-blocks-style');

    if(is_shop() || is_product() || is_cart() || is_checkout() || is_account_page()) {
        wp_enqueue_style('woocommerce-style', get_stylesheet_directory_uri() . '/css/woocommerce.css', array(), CHILD_THEME_VERSION);
    }
}

// Remove Breadcrumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Removing Sort Dropdown
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Remoing Product Count
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// Remove related products from single product page
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// Enable WooCommerce support in Genesis and remove sidebar
add_action('after_setup_theme', 'custom_genesis_woocommerce_setup');
function custom_genesis_woocommerce_setup() {
    add_theme_support('woocommerce');

    // Force full-width layout for WooCommerce pages
    add_filter('genesis_site_layout', function ($layout) {
        if (is_singular('product') || is_post_type_archive('product') || is_tax(['product_cat', 'product_tag'])) {
            return 'full-width-content'; // Ensures Genesis uses a layout without a sidebar
        }
        return $layout;
    });

    // Remove primary and secondary sidebars from WooCommerce pages
    add_action('get_header', function () {
        if (is_singular('product') || is_post_type_archive('product') || is_tax(['product_cat', 'product_tag'])) {
            remove_action('genesis_sidebar', 'genesis_do_sidebar');
            remove_action('genesis_sidebar_alt', 'genesis_do_sidebar_alt');
        }
    });
}

// Ensure WooCommerce reviews tab is present
add_filter('woocommerce_product_tabs', 'genesis_woocommerce_enable_reviews');
function genesis_woocommerce_enable_reviews($tabs) {
    // if (!isset($tabs['reviews'])) {
    //     $tabs['reviews'] = [
    //         'title'    => __('Reviews', 'woocommerce'),
    //         'priority' => 30,
    //         'callback' => 'comments_template',
    //     ];
    // }
    // return $tabs;

    return []; // Removes all product tabs
}

// Adding header wrapper before woocommerce header
add_action( 'woocommerce_before_main_content', 'shop_banner', 35);
function shop_banner() {
    if (is_shop()) {
        $shop_page_id = get_option('woocommerce_shop_page_id');
        $shop_image_url = get_the_post_thumbnail_url($shop_page_id, 'full');
        echo '<section class="banner overlay lazy" data-bg="url(' . $shop_image_url . ')">';
        echo '<div class="banner-overlay"></div>';
        echo '<div class="inr">';
    }
}

// Adding wrapper before woocommerce content
add_action('woocommerce_before_shop_loop', 'built_woo_content_wrapper_start', 5);
function built_woo_content_wrapper_start() {
    if (is_shop()) {
        echo '</div>';
        echo '</section>';
    }
    echo '<section class="woo-content">';
    echo '<div class="inr lg">';
}

// Adding closing wrapper after woocommerce content
add_action('woocommerce_after_shop_loop', 'built_woo_content_wrapper_end', 5);
function built_woo_content_wrapper_end() {
    echo '</div>';
    echo '</section>';
}

// Adding Modules to Woocommerce Pages
add_action('woocommerce_after_main_content', 'built_content_modules_for_woo', 5);
function built_content_modules_for_woo() {
    
    if (is_shop()) {
        $shop_page_id = get_option('woocommerce_shop_page_id');

        if (have_rows('modules', $shop_page_id)) {

            while (have_rows('modules', $shop_page_id)) { the_row();

                    if(get_row_layout() == 'banner') { include('modules/banner.php'); }
                elseif(get_row_layout() == 'content') { include('modules/content.php'); }
                elseif(get_row_layout() == 'faqs') { include('modules/faqs.php'); }
                elseif(get_row_layout() == 'list') { include('modules/list.php'); }
                elseif(get_row_layout() == 'reviews') { include('modules/reviews.php'); }
                elseif(get_row_layout() == 'slider') { include('modules/slider.php'); }

            }
        }
    } else {

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
}

// Adding Custom links to product cart area after product meta
add_action('woocommerce_product_meta_end', 'add_acf_repeater_links_to_product_meta');
function add_acf_repeater_links_to_product_meta() {
    global $post;

    if (have_rows('custom_links', $post->ID)) {
        echo '<div class="custom-product-links">';

        while (have_rows('custom_links', $post->ID)) {
            the_row();
            $link = get_sub_field('link');
            $link_text = $link['title'];
            $link_url = $link['url'];
            $link_target = $link['target'];

            if ($link_text && $link_url) {
                echo '<a href="' . esc_url($link_url) . '" target="' . $link_target . '" rel="noopener noreferrer">' . esc_html($link_text) . '</a>';
            }
        }

        echo '</div>';
    }
}

// Unlinking Single Product Image
add_filter('woocommerce_single_product_image_thumbnail_html', 'remove_woocommerce_single_product_image_link', 10, 2);
function remove_woocommerce_single_product_image_link($html, $post_id) {
    global $product;

    // Get the product image
    $image_id  = $product->get_image_id();
    $image_url = wp_get_attachment_image_url($image_id, 'woocommerce_single');

    // Return image without the <a> link
    if ($image_id) {
        return '<img src="' . esc_url($image_url) . '" class="wp-post-image" alt="' . esc_attr(get_the_title($post_id)) . '">';
    }

    return $html;
}

// Add quanitity of 1 to subscription product in cart
add_action('wp_footer', 'cart_subscription_quantity');
function cart_subscription_quantity() {
    if (is_cart()) { // Only run this on the cart page
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll('.product-quantity .quantity input[type="hidden"]').forEach(function(input) {
                    let quantityValue = input.value || "1"; // Get the quantity value, default to 1 if empty
                    let span = document.createElement("span");
                    span.className = "static-quantity";
                    span.textContent = quantityValue; // Display the quantity
                    input.parentNode.replaceChild(span, input); // Replace input with span
                });
            });
        </script>
        <style>
            .static-quantity {
                font-weight: bold;
                font-size: 16px;
                display: block;
                text-align: center;
            }
        </style>
        <?php
    }
}

// Remove Downloads from My Account
add_filter('woocommerce_account_menu_items', function( $items ) {
    unset( $items['downloads'] ); // Remove Downloads tab
    return $items;
});

add_action('template_redirect', function() {
    if ( is_wc_endpoint_url( 'downloads' ) ) {
        wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) ); // Redirect to My Account main page
        exit;
    }
});

// Square Footage Upcharge Functionality
add_action('woocommerce_add_cart_item_data', 'add_square_footage_to_cart_item', 10, 3);
function add_square_footage_to_cart_item($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['square_footage_upcharge']) && isset($_POST['square_footage_range'])) {
        $cart_item_data['square_footage_upcharge'] = floatval($_POST['square_footage_upcharge']);
        $cart_item_data['square_footage_range'] = sanitize_text_field($_POST['square_footage_range']);
        $cart_item_data['unique_key'] = md5(microtime() . rand());
    }
    return $cart_item_data;
}

add_action('woocommerce_before_calculate_totals', 'add_square_footage_upcharge', 10, 1);
function add_square_footage_upcharge($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['square_footage_upcharge'])) {
            $base_price = $cart_item['data']->get_regular_price();
            $cart_item['data']->set_price($base_price + $cart_item['square_footage_upcharge']);
        }
    }
}

add_filter('woocommerce_get_item_data', 'display_square_footage_in_cart', 10, 2);
function display_square_footage_in_cart($item_data, $cart_item) {
    // Remove the square footage display from here since we're showing it in the product name
    return $item_data;
}

add_action('woocommerce_checkout_create_order_line_item', 'add_square_footage_to_order_items', 10, 4);
function add_square_footage_to_order_items($item, $cart_item_key, $values, $order) {
    if (isset($values['square_footage_range'])) {
        $item->add_meta_data('Square Footage', $values['square_footage_range']);
    }
    if (isset($values['square_footage_upcharge']) && $values['square_footage_upcharge'] > 0) {
        $item->add_meta_data('Square Footage Upcharge', wc_price($values['square_footage_upcharge']));
    }
}

// Add admin column for Square Footage in orders
add_action('woocommerce_admin_order_item_headers', function () {
    echo '<th>Square Footage</th>';
});

add_action('woocommerce_admin_order_item_values', function ($product, $item, $item_id) {
    $square_footage = $item->get_meta('Square Footage', true);
    $upcharge = $item->get_meta('Square Footage Upcharge', true);
    echo '<td>' . (!empty($square_footage) ? esc_html($square_footage) : '-') . '<br>' . 
         (!empty($upcharge) ? esc_html($upcharge) : '') . '</td>';
}, 10, 3);

do_action('woocommerce_after_add_to_cart_form');

// Display Square Footage in Cart Form
add_filter('woocommerce_cart_item_name', 'add_square_footage_to_cart_item_name', 10, 3);
function add_square_footage_to_cart_item_name($name, $cart_item, $cart_item_key) {
    if (isset($cart_item['square_footage_range'])) {
        $name .= '<div class="square-footage-info">';
        $name .= '<small>' . esc_html($cart_item['square_footage_range']) . '</small>';
        if (isset($cart_item['square_footage_upcharge']) && $cart_item['square_footage_upcharge'] > 0) {
            $name .= '<small class="upcharge">' . wc_price($cart_item['square_footage_upcharge']) . ' upcharge</small>';
        }
        $name .= '</div>';
    }
    return $name;
}

// Add some CSS for the cart form display
add_action('wp_head', 'add_square_footage_cart_css');
function add_square_footage_cart_css() {
    if (is_cart()) {
        ?>
        <style>
            .square-footage-info {
                margin-top: 5px;
                line-height: 1.4;
            }
            .square-footage-info small {
                display: block;
                color: #666;
            }
            .square-footage-info .upcharge {
                color: #e2401c;
            }
        </style>
        <?php
    }
}
