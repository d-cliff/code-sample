<?php

//* Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'genesis_404' );

function genesis_404() {

	echo genesis_html5() ? '<article class="entry">' : '<div class="post hentry">';

		printf( '<h1 class="entry-title">%s</h1>', apply_filters( 'genesis_404_entry_title', __( '404 - Page Not Found', 'genesis' ) ) );
		echo '<div class="entry-content">';

			if ( genesis_html5() ) :

				echo apply_filters( 'genesis_404_entry_content', '<p>' . sprintf( __( 'The page you are looking for no longer exists.</p><p>Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for.', 'genesis' ), trailingslashit( home_url() ) ) . '</p>' );

			else :
	?>

			<p><?php printf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for.', 'genesis' ), trailingslashit( home_url() ) ); ?></p>



	<?php
			endif;

			if ( ! genesis_html5() ) {
				genesis_sitemap( 'h4' );
			} elseif ( genesis_a11y( '404-page' ) ) {
				echo '<h2>' . __( 'Sitemap', 'genesis' ) . '</h2>';
				genesis_sitemap( 'h3' );
			}

			echo '</div>';

		echo genesis_html5() ? '</article>' : '</div>';

}

genesis();
