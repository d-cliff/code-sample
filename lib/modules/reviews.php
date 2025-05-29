<?php

// =========== Variables =========== //

$dsp = get_sub_field('display');
$rvws = get_sub_field('reviews');

// ============ Styling ============ //

wp_enqueue_style('reviews-style', get_stylesheet_directory_uri() . '/css/modules/reviews.css', array(), CHILD_THEME_VERSION);

// ============ Scripts ============ //

wp_enqueue_script( 'reviews-script', get_stylesheet_directory_uri() . '/js/modules/reviews.js', array('jquery'), CHILD_THEME_VERSION)

// ============ Markup ============= // ?>

<?php if($dsp) { ?>

<section id="<?php echo get_persistent_section_id(); ?>" class="reviews">

    <div class="inr">

        <h5>What our customers are saying</h5>

        <?php if($rvws) : ?>
            <div class="reviews-slider">
                <?php foreach($rvws as $rvw) :
                    $name = $rvw['name'];
                    $review = $rvw['review']; ?>
                    <div class="review">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/stars.svg" class="stars" alt="5 Stars" />
                        <?php if($review) { echo '<h3>"' . esc_html($review) . '"</h3>'; } ?>
                        <?php if($name) { echo '<p>- ' . esc_html($name) . '</p>'; } ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

</section>

<?php } ?>