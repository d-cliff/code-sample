<?php

// =========== Variables =========== //

$dsp = get_sub_field('display');
$atxt = get_sub_field('above_text');
$slds = get_sub_field('slides');
$btxt = get_sub_field('below_text');

// ============ Styling ============ //

wp_enqueue_style('slider-style', get_stylesheet_directory_uri() . '/css/modules/slider.css', array(), CHILD_THEME_VERSION);

// ============ Scripts ============ //

wp_enqueue_script( 'slider-script', get_stylesheet_directory_uri() . '/js/modules/slider.js', array('jquery'), CHILD_THEME_VERSION)

// ============ Markup ============= // ?>

<?php if($dsp) { ?>

<section id="<?php echo get_persistent_section_id(); ?>" class="slider-area">

    <div class="inr lg">

        <?php if($atxt) { echo $atxt; } ?>

        <?php if ($slds) : ?>
            <div class="slider">
                <?php foreach ($slds as $sld) :
                    $title = $sld['title'];
                    $img = $sld['image'];
                    $text = $sld['text']; ?>
                    <div class="slide">
                        <?php if ($title) { echo '<h4>' . $title . '</h4>'; } ?>
                        <?php if ($img) { echo '<img src="' . $img['url'] . '" alt="' . $img['alt'] . '"/>'; } ?>
                        <?php if ($title) { echo '<div>' . $text . '</div>'; } ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if($atxt) { echo $btxt; } ?>

    </div>

</section>

<?php } ?>