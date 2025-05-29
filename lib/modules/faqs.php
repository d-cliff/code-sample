<?php

// =========== Variables =========== //

$dsp = get_sub_field('display');
$atxt = get_sub_field('above_text');
$faqs = get_sub_field('faqs');
$btxt = get_sub_field('below_text');

// ============ Styling ============ //

wp_enqueue_style('faqs-style', get_stylesheet_directory_uri() . '/css/modules/faqs.css', array(), CHILD_THEME_VERSION);

// ============ Scripts ============ //

wp_enqueue_script( 'faqs-script', get_stylesheet_directory_uri() . '/js/modules/faqs.js', array('jquery'), CHILD_THEME_VERSION)

// ============ Markup ============= // ?>

<?php if($dsp) { ?>

<section id="<?php echo get_persistent_section_id(); ?>" class="faqs">

    <div class="inr">

        <?php if($atxt) { echo $atxt; } ?>

        <?php if ($faqs) : ?>
            <div class="faqs-grid" itemscope itemtype="https://schema.org/FAQPage">
                <?php foreach ($faqs as $faq) :
                    $title = $faq['title'];
                    $text = $faq['text']; ?>
                    <div class="faq" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <?php if ($title) { ?>
                            <div class="faq-question">
                                <h3 itemprop="name"><?php echo esc_html($title); ?></h3>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/arrow.svg" class="faq-arrow" />
                            </div>
                        <?php } ?>
                        <?php if ($text) { ?>
                            <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <div class="faq-answer-text" itemprop="text"> <?php echo wp_kses_post($text); ?> </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if($atxt) { echo $btxt; } ?>

    </div>

</section>

<?php } ?>