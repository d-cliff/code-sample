<?php

// =========== Variables =========== //

$dsp = get_sub_field('display');
$ttl = get_sub_field('title');
$txt = get_sub_field('text');
$img = get_sub_field('image');
$bgc = get_sub_field('background_color');
$lyt = get_sub_field('layout');

// ============ Styling ============ //

wp_enqueue_style('content-style', get_stylesheet_directory_uri() . '/css/modules/content.css', array(), CHILD_THEME_VERSION);

// ============ Scripts ============ //



// ============ Markup ============= // ?>

<?php if($dsp) { ?>

<section id="<?php echo get_persistent_section_id(); ?>" class="content-section <?php echo $lyt; ?> <?php echo $bgc; ?>">

    <div class="inr">

        <?php if($ttl) { echo '<h2>' . $ttl . '</h2>'; } ?>

        <?php if($lyt == 'full-width') : ?>
            <?php if($txt) { echo '<div class="content-section-full-width-content">' . $txt . '</div>'; } ?>
        <?php endif; ?>

        <?php if($lyt != 'full-width') : ?>
            <div class="content-section-<?php echo $lyt; ?>">
                <?php if($img) { echo '<img class="content-section-' . $lyt . '-image lazy" data-src="' . $img['url'] . '" alt="' . $img['alt'] . '"/>'; } ?>
                <?php if($txt) { echo '<div class="content-section-' . $lyt . '-content"><div>' . $txt . '</div></div>'; } ?>
            </div>
        <?php endif; ?>

    </div>

</section>

<?php } ?>