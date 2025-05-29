<?php

// Global Banner
add_action('genesis_footer', 'built_custom_footer', 1);
function built_custom_footer() {

	// =========== Variables =========== //

	$lgo = get_field('logo', 'option'); 
    $add = get_field('address', 'option');
    $phn = get_field('phone', 'option');

    ?>

    <footer role="complimentary" class="ftr">
        <section class="mn-ftr">
            <div class="inr grd lg">
                <div class="ftr-col ftr-col-tp">
                    <?php if($lgo) { echo '<a class="ftr-lgo" href="/"><img class="lazy" data-src="' . $lgo . '" alt="Footer Logo" /></a>'; } ?>
                    <?php if($add) { echo '<address>' . $add['street'] . '<br>' . $add['city'] . ', ' . $add['state'] . ' ' . $add['zip'] . '</address>'; } ?>
                    <?php if($phn) { echo '<div><a href="tel:' . $phn . '">' . $phn . '</a></div>'; } ?>
                    <?php echo do_shortcode('[social_media_icons]'); ?>
                </div>
                <div class="ftr-col ctr-col-cnt">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div>
                <div class="ftr-col ftr-col-lnk">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </div>
            </div>
        </section>
        <section class="crdts">
            <div class="inr grd grd-2 lg">
                <?php echo '<div class="cpy"><span>&copy; ' . get_bloginfo( 'title', 'display' ) . ' ' . date('Y') . '</span></div>'; ?>
                <?php echo '<div class="mwi">' . __('Site Design by', 'bugsdrop') . ' <a href="https://www.mwi.com" target="_blank">' . __('MWI', 'bugsdrop') . '</a></div>'; ?>
            </div>
        </section>
    </footer>

<?php }