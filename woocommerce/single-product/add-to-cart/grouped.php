<?php
/**
 * Grouped product add to cart template with radio buttons and Square Footage select
 */

defined('ABSPATH') || exit;

global $product;

// Ensure this is a grouped product
if (!$product || !$product->is_type('grouped')) {
    return;
}

do_action('woocommerce_before_add_to_cart_form'); ?>

<form class="cart" method="post" enctype="multipart/form-data">

    <table cellspacing="0" class="woocommerce-grouped-product-list group_table">
        <tbody>
            <?php
            // Get grouped products (child products)
            $grouped_products = $product->get_children();

            if (!empty($grouped_products)) {
                $default_product_id = reset($grouped_products); // Select first product by default

                foreach ($grouped_products as $child_id) {
                    $child_product = wc_get_product($child_id);

                    if (!$child_product || !$child_product->is_purchasable()) {
                        continue;
                    }

                    $product_id = $child_product->get_id();
                    $is_checked = ($product_id === $default_product_id) ? 'checked' : ''; // Default checked for first item

                    // Get price details
                    $regular_price = wc_price($child_product->get_regular_price());
                    $sale_price = $child_product->is_on_sale() ? wc_price($child_product->get_sale_price()) : '';

                    // Subscription message
                    $subscription_text = '';
                    if (class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($child_product)) {
                        $interval = WC_Subscriptions_Product::get_interval($child_product);
                        $period = WC_Subscriptions_Product::get_period($child_product);
                        $subscription_text = '<p class="subscription-info">Auto-renews ' . sprintf(_n('every %d %s', 'every %d %ss', $interval, 'woocommerce-subscriptions'), $interval, $period) . '.</p>';
                    }
                    ?>
                    
                    <tr class="woocommerce-grouped-product-list-item">
                        <td class="radio-input">
                            <input type="radio" name="selected_product" value="<?php echo esc_attr($product_id); ?>" id="product-<?php echo esc_attr($product_id); ?>" <?php echo $is_checked; ?> required>
                        </td>
                        <td class="product-list-item-grid">
                            <div class="product-list-item-title">
                                <div class="square"></div>
                                <div class="label">
                                    <label for="product-<?php echo esc_attr($product_id); ?>">
                                        <?php echo esc_html($child_product->get_name()); ?>
                                    </label>
                                    <?php echo $subscription_text; ?>
                                </div>
                            </div>
                            <div class="price">
                                <?php if ($sale_price) : ?>
                                    <del class="regular-price"><?php echo $regular_price; ?></del>
                                    <ins class="sale-price"><?php echo $sale_price; ?></ins>
                                <?php else : ?>
                                    <span class="regular-price"><?php echo $regular_price; ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="3">' . esc_html__('No products found in this group.', 'woocommerce') . '</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <!-- Square Footage Dropdown -->
    <label for="square_footage" class="screen-reader-text">Select Your Home's Square Footage:</label>
    <select name="square_footage" id="square_footage" required>
        <option value="">Select Your Home's Square Footage</option>
        <option value="0-1500">0-1,500 sqft (No upcharge)</option>
        <option value="1501-3000">1,501-3,000 sqft (+$5 upcharge)</option>
        <option value="3001+">3,001+ sqft (+$10 upcharge)</option>
    </select>

    <!-- Hidden input to ensure WooCommerce processes only the selected product -->
    <input type="hidden" name="add-to-cart" id="selected_product_input" value="<?php echo esc_attr($default_product_id); ?>" />
    <input type="hidden" name="square_footage_upcharge" id="square_footage_upcharge" value="0" />
    <input type="hidden" name="square_footage_range" id="square_footage_range" value="" />

    <button type="submit" class="single_add_to_cart_button button alt">
        <?php echo esc_html($product->single_add_to_cart_text()); ?>
    </button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const radioButtons = document.querySelectorAll('input[name="selected_product"]');
        const hiddenInput = document.getElementById("selected_product_input");
        const squareFootageSelect = document.getElementById("square_footage");
        const upchargeInput = document.getElementById("square_footage_upcharge");
        const squareFootageRangeInput = document.getElementById("square_footage_range");
        const priceElements = document.querySelectorAll('.price .regular-price, .price .sale-price');

        // Function to update prices based on square footage
        function updatePrices() {
            const selectedSquareFootage = squareFootageSelect.value;
            let upcharge = 0;

            switch(selectedSquareFootage) {
                case '1501-3000':
                    upcharge = 5;
                    break;
                case '3001+':
                    upcharge = 10;
                    break;
                default:
                    upcharge = 0;
            }

            upchargeInput.value = upcharge;
            squareFootageRangeInput.value = selectedSquareFootage;

            // Update displayed prices
            priceElements.forEach(priceElement => {
                const originalPrice = parseFloat(priceElement.dataset.originalPrice || priceElement.textContent.replace(/[^0-9.]/g, ''));
                const newPrice = originalPrice + upcharge;
                priceElement.textContent = '$' + newPrice.toFixed(2);
            });
        }

        // Store original prices
        priceElements.forEach(priceElement => {
            priceElement.dataset.originalPrice = priceElement.textContent.replace(/[^0-9.]/g, '');
        });

        radioButtons.forEach(radio => {
            radio.addEventListener("change", function () {
                hiddenInput.value = this.value;
            });
        });

        squareFootageSelect.addEventListener("change", updatePrices);
    });
</script>