<?php

// Removed Genesis Actions
remove_action('genesis_site_title', 'genesis_seo_site_title');
remove_action('genesis_site_description', 'genesis_seo_site_description');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);
remove_action('genesis_header', 'genesis_header_markup_open', 5);
remove_action('genesis_header', 'genesis_do_header');
remove_action('genesis_header', 'genesis_header_markup_close', 15);
remove_action('genesis_after_header', 'genesis_do_nav');
remove_action('genesis_after_header', 'genesis_do_subnav');
remove_action('genesis_entry_footer', 'genesis_post_meta');
remove_action('genesis_entry_header', 'genesis_post_info', 12 );
remove_action('genesis_entry_content', 'genesis_do_post_content', 10);

// Theme Scripts & Styles
add_action('wp_enqueue_scripts', 'built_theme_enqueue_styles');
function built_theme_enqueue_styles() {
	wp_enqueue_style('fontawesome-style', get_stylesheet_directory_uri() . '/css/fontawesome.min.css', array(), CHILD_THEME_VERSION);
	wp_enqueue_style('brands-style', get_stylesheet_directory_uri() . '/css/brands.min.css', array(), CHILD_THEME_VERSION);
	wp_enqueue_style('solid-style', get_stylesheet_directory_uri() . '/css/solid.min.css', array(), CHILD_THEME_VERSION);
	wp_enqueue_style('slick-style', get_stylesheet_directory_uri() . '/css/slick.css', array(), CHILD_THEME_VERSION);
	wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/slick-theme.css', array(), CHILD_THEME_VERSION);
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/css/style.css', array(), CHILD_THEME_VERSION);
	wp_enqueue_script('cookie', get_stylesheet_directory_uri() . '/js/cookie.js', array('jquery'), CHILD_THEME_VERSION, true);
    wp_enqueue_script('lazy', get_stylesheet_directory_uri() . '/js/lazyload.min.js', array('jquery'), CHILD_THEME_VERSION, true);
	wp_enqueue_script('slick', get_stylesheet_directory_uri() . '/js/slick.min.js', array('jquery'), CHILD_THEME_VERSION, true);
    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery', 'lazy', 'slick', 'cookie'), CHILD_THEME_VERSION, true);
}

// Widgets
function custom_widgets_init() {

    genesis_register_sidebar( array(
        'id'            => 'footer-1',
        'name'          => 'Footer 1', 
        'description'   => 'Footer Column 1',
    ) );

    genesis_register_sidebar( array(
        'id'            => 'footer-2',
        'name'          => 'Footer 2', 
        'description'   => 'Footer Column 2',
    ) );

}
add_action( 'widgets_init', 'custom_widgets_init' );

function remove_sidebars() {
    unregister_sidebar( 'sidebar' );
    unregister_sidebar( 'sidebar-alt' );
    unregister_sidebar( 'header-right' );
}
add_action( 'widgets_init', 'remove_sidebars', 11 );


// Flexible Content Admin Script
add_action('admin_enqueue_scripts', 'enqueue_acf_admin_script');
function enqueue_acf_admin_script() {
    if (is_admin()) {
        wp_enqueue_script('acf-admin-script', get_stylesheet_directory_uri() . '/js/flexible-content.js', array('jquery'), CHILD_THEME_VERSION, true);
    }
}

// Fonts
add_action('wp_head', 'built_webfont');
function built_webfont() {
    wp_enqueue_style('typekit-fonts', 'https://use.typekit.net/byv1udx.css', array(), null);
}

// Page Modules
add_action('genesis_before', 'built_remove_entry_content');
function built_remove_entry_content() {
	if(is_singular('page')) { 
		remove_action('genesis_loop', 'genesis_do_loop');
		include('modules.php');
	}
}

// Move Featured Image to Header
add_action('genesis_before_entry', 'built_relocate_featured_image');
function built_relocate_featured_image() {
    remove_action('genesis_entry_content', 'genesis_do_post_image', 8);
    add_action('genesis_entry_header', 'genesis_do_post_image', 3);
}

// Adding banner to blog pages
add_action( 'genesis_before_loop', 'blog_banner' );
function blog_banner() { ?>
    <?php if (is_blog() || is_singular('post')) {
        $blog_page_id = get_option('page_for_posts');
        $blog_page_title = get_the_title($blog_page_id);
        $featured_image = get_the_post_thumbnail_url($blog_page_id, 'full'); ?>
        <section class="banner overlay lazy" data-bg="url(<?php echo $featured_image; ?>)">
            <div class="banner-overlay"></div>
			<div class="inr">
                <h1><?php echo esc_html($blog_page_title); ?></h1>
            </div>
        </section>
    <?php } ?>
<?php }

// Adding wrappers when needed - Start
add_action( 'genesis_before_loop', 'adding_inner_start' );
function adding_inner_start() { ?>
    <?php if (is_404() || is_blog() || is_search() || is_singular('post')) { ?>
        <section class="interior-content">
            <div class="inr">
    <?php } ?>
<?php }

// Adding wrappers when needed - End
add_action( 'genesis_after_loop', 'adding_inner_end' );
function adding_inner_end() { ?>
    <?php if (is_404() || is_blog() || is_search() || is_singular('post')) { ?>
            </div>
        </section>
    <?php } ?>
<?php }

// Add Read More Button to Blog Articles
add_action('genesis_entry_footer', 'blog_article_read_more');
function blog_article_read_more() { ?>
    <?php if ( is_blog() || is_search() ) { ?>
        <a class="btn" href="<?php the_permalink(); ?>">Read More <i class="fa fa-arrow-right"></i></a>
    <?php } ?>
<?php }

// Add the custom function to display excerpt or Yoast meta description for search results
add_action('genesis_entry_content', 'custom_search_excerpt_or_yoast_description', 10);
function custom_search_excerpt_or_yoast_description() {
    if (is_search() || is_blog()) {
        global $post;

        // Get the excerpt
        $excerpt = get_the_excerpt();

        // Check if Yoast SEO is active
        if (defined('WPSEO_VERSION')) {
            // Get the Yoast SEO meta description
            $yoast_meta_description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
        }

        // Display the yoast meta description if it exists
        if (!empty($yoast_meta_description)) {
            echo '<p>' . esc_html($yoast_meta_description) . '</p>';
        } elseif ($excerpt) {
            echo '<p>' . esc_html($excerpt) . '</p>';
        }
    }
}

// Adding Category/Tag Titles to Respective Templates
add_action('genesis_before_loop', 'show_archive_title');
function show_archive_title() {
    if (is_category()) {
        echo '<h2 class="archive-title">Category: ' . single_cat_title('', false) . '</h2>';
        if (category_description()) {
            echo '<div class="archive-description">' . category_description() . '</div>';
        }
    } elseif (is_tag()) {
        echo '<h2 class="archive-title">Tag: ' . single_tag_title('', false) . '</h2>';
        if (tag_description()) {
            echo '<div class="archive-description">' . tag_description() . '</div>';
        }
    }
}

// Add custom title with h2 for singular posts
remove_action('genesis_entry_header', 'genesis_do_post_title');
add_action('genesis_entry_header', 'custom_genesis_do_post_title_h2');
function custom_genesis_do_post_title_h2() {
    if (is_singular('post')) {
        printf('<h2 class="entry-title">%s</h2>', get_the_title());
    } else {
        genesis_do_post_title(); // Fallback to default for other post types
    }
}

// Adding content to Single Post
add_action('genesis_before_loop', 'add_genesis_do_post_content_back_on_single');
function add_genesis_do_post_content_back_on_single() {
    if ( is_singular('post') ) {
        add_action('genesis_entry_content', 'genesis_do_post_content', 10);
    }
}

// Function to cover all blog templates
function is_blog() {
    if ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) {
        return true;
    } else {
        return false;
    }
}

// Generate ID for each section
function get_persistent_section_id($unique_key = null, $prefix = 'bugs-', $length = 5) {
    // Get the current post ID automatically
    $post_id = get_the_ID();

    // Fallback if no unique key is provided
    if (!$unique_key) {
        $unique_key = 'section_' . wp_unique_id();
    }

    $meta_key = '_section_id_' . $unique_key;
    $section_id = get_post_meta($post_id, $meta_key, true);

    if (!$section_id) {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, strlen($characters) - 1)];
        }
        $section_id = $prefix . $random_string;
        update_post_meta($post_id, $meta_key, $section_id);
    }

    return $section_id;
}
