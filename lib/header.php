<?php

// Global Banner
add_action('genesis_before_header', 'built_custom_header', 1);
function built_custom_header() {

	// =========== Variables =========== //

	$lgo = get_field('logo', 'option'); 
	$eye = get_field('eyebrow_message', 'option'); ?>

	<header class="site-header">

		<?php if ($eye) : ?>
			<div class="eye">
				<div class="inr wd">
					<?php echo $eye; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="navbar">
			<div class="inr lg">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mobile-menu-icon.svg" alt="mobile menu icon"  class="mbl-mnu-trg-open" />
				<?php if($lgo) { echo '<a href="/" class="lgo-lnk"><img class="lgo lazy" src="' . $lgo . '" alt="Site Logo" /></a>'; } ?>
				<?php genesis_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'prm-mnu')); ?>
				<div class="navbar-right">
					<?php
						$cart_url = wc_get_cart_url();
						$my_account_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
					?>
					<a href="<?php echo esc_url($my_account_url); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/user-icon.svg" alt="profile icon" class="icon-user" /></a>
					<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-link">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cart-icon.svg" alt="cart icon" class="icon-cart" />
						<span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
					</a>
				</div>
			</div>
		</div>

		<div class="mbl-mnu">
			<div class="mbl-mnu-trg-close"><i class="fa fa-times"></i></div>
			<?php if($lgo) { echo '<a href="/"><img class="lgo lazy" src="' . $lgo . '" alt="Site Logo" /></a>'; } ?>
			<?php genesis_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'prm-mnu')); ?>
		</div>

	</header>
	
<?php } ?>