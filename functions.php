<?php
include_once( get_template_directory() . '/lib/init.php');
include('lib/filters.php');
include('lib/actions.php');
include('lib/shortcodes.php');
include('lib/woocommerce.php');
include('lib/header.php');
include('lib/footer.php');

// Child Theme Variables
define('CHILD_THEME_NAME', 'THEME');
define('CHILD_THEME_URL', 'URL');
define('CHILD_THEME_VERSION', '0.0.282');

// Add Theme Support
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list' ));
add_theme_support('genesis-responsive-viewport');
add_theme_support('custom-background');

?>