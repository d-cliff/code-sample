<?php 

// Favicon
add_filter('genesis_pre_load_favicon', 'built_favicon');
function built_favicon($favicon_url) {
	return '/wp-content/uploads/2025/02/favicon.png';
}

// Excerpt Length
add_filter('excerpt_length', 'built_excerpt_length');
function built_excerpt_length($length) {
	return 25;
}

// Replace [...] with ...
add_filter('excerpt_more', 'built_excerpt_more');
function built_excerpt_more($more) {
    return '...';
}

?>