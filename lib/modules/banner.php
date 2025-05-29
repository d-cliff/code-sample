<?php

// =========== Variables =========== //

$dsp = get_sub_field('display');
$lyt = get_sub_field('layout');
$txt = get_sub_field('text');
$img = get_sub_field('image');

// ============ Styling ============ //

wp_enqueue_style('banner-style', get_stylesheet_directory_uri() . '/css/modules/banner.css', array(), CHILD_THEME_VERSION);

// ============ Scripts ============ //



// ============ Markup ============= // ?>

<?php if($dsp) { ?>

<section id="<?php echo get_persistent_section_id(); ?>" class="banner <?php echo $lyt; ?> lazy">

        <?php if($lyt == "overlay") : ?>
            <div class="banner-background-image lazy" data-bg="url(<?php echo $img['url']; ?>)"></div>
            <div class="banner-overlay"></div>
        <?php endif; ?>

    <div class="inr lg">

        <?php if($lyt == "overlay") : ?>

            <?php if($txt) { echo '<div class="banner-text">' . $txt . '</div>'; } ?>

        <?php elseif($lyt == "split") : ?>

            <?php if($txt) { echo '<div class="banner-text">' . $txt . '</div>'; } ?>
            <?php if($img) { echo '<img class="banner-image lazy" data-src="' . $img['url'] . '"alt="' . $img['alt'] . '"/>'; } ?>

        <?php endif; ?>

    </div>

</section>

<?php } ?>