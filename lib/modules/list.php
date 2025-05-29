<?php

// =========== Variables =========== //

$dsp = get_sub_field('display');
$vars = get_sub_field('vars');
$atxt = get_sub_field('above_text');
$itms = get_sub_field('items');
$btxt = get_sub_field('below_text');

// ============ Styling ============ //

wp_enqueue_style('list-style', get_stylesheet_directory_uri() . '/css/modules/list.css', array(), CHILD_THEME_VERSION);

// ============ Scripts ============ //



// ============ Markup ============= // ?>

<?php if($dsp) { ?>

<section id="<?php echo get_persistent_section_id(); ?>" class="list list-<?php echo $vars; ?>">

    <div class="inr">

        <?php if($atxt) { echo $atxt; } ?>

        <?php if($itms) : ?>
            <div class="list-items">
                <?php $counter = 1; ?>
                <?php foreach($itms as $itm) :
                    $title = $itm['title'];
                    $text = $itm['text']; ?>
                    <div class="item">
                        <?php if($vars == 'steps') : ?>
                            <h3 class="step-number">Step <?php echo $counter; ?></h3>
                            <div class="border-arrow"></div>
                        <?php endif; ?>
                        <?php if($title) { echo '<h4>' . esc_html($title) . '</h4>'; } ?>
                        <?php if($text) { echo '<p>' . $text . '</p>'; } ?>
                    </div>
                    <?php $counter++; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if($btxt) { echo $btxt; } ?>

    </div>

</section>

<?php } ?>