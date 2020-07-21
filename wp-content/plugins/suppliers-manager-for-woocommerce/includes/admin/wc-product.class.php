<?php

if (!class_exists('FT_SMFW_wc_product')) {
    class FT_SMFW_wc_product
    {

        // +-------------------+
		// | CLASS CONSTRUCTOR |
		// +-------------------+

		public function __construct()
		{
            $this->init_hooks(); // Init hooks in Wordpress
            $this->init_filters(); // Init filters in Wordpress
		}

        // +---------------+
        // | CLASS METHODS |
        // +---------------+

    	/**
    	 * Initiate plugin hooks in Wordpress
    	 */
        public function init_hooks()
        {

            // Simple product new fields
            add_action('woocommerce_product_options_general_product_data', array($this, 'simple_product_supplier_fields'), 10, 3);
            add_action('woocommerce_process_product_meta', array($this, 'save_post'), 10, 2);

            // Variable product new fields
            add_action('woocommerce_product_after_variable_attributes', array($this, 'variable_product_supplier_fields'), 10, 3);
            add_action('woocommerce_save_product_variation', array($this, 'save_post_variations'), 10, 2);
        }

    	/**
    	 * Initiate plugin filters in Wordpress
    	 */
        public function init_filters() {}

        /**
         * Show informations metabox in the editor
         */
        public function simple_product_supplier_fields()
        {
            global $woocommerce, $post;

            // Get suppliers
            $suppliers = FT_SMFW_Supplier::findAll();
            $product = wc_get_product($post->ID);

            if (count($suppliers)) :

                // Build select array
                $suppliers_array = array(0 => __('-', FT_SMFW_TEXT_DOMAIN));
                foreach ($suppliers as $supplier) {
                    $suppliers_array[$supplier->getId()] = $supplier->getName();
                }

                ?>
                <div class="options_group">
        			<?php
                    woocommerce_wp_select(
            			array(
            				'id'          => 'ft_smfw_supplier',
            				'label'       => __('Supplier', FT_SMFW_TEXT_DOMAIN),
            				'description' => __('Choose a supplier in the list', FT_SMFW_TEXT_DOMAIN),
            				'value'       => get_post_meta($product->get_id(), 'ft_smfw_supplier', true),
            				'options'     => $suppliers_array
        				)
        			);

                    // If the product is a simple product, we show here the field for the supplier price and packaging
                    // (else => product variation)
            		if ($product->is_type('simple')) :
                        $this->show_supplier_price_field($product->get_id(), 'simple');
                        $this->show_supplier_packaging_field($product->get_id(), 'simple');
                        $this->show_supplier_part_number_field($product->get_id(), 'simple');
                    endif;

                    ?>
                    </div>
                <?php
            else :
                ?>
                <p><?php _e('Oups! No supplier…', FT_SMFW_TEXT_DOMAIN); ?> <a href="" class="new ft_supplier link"><?php _e('add.one', FT_SMFW_TEXT_DOMAIN); ?></a></p>
                <?php
            endif;
        }

        /**
         * Hook called when a post is saved
         */
        public function save_post($post_id)
        {
        	// If this is just a revision, don't continue
        	if (wp_is_post_revision($post_id)) return;

            // Update datas
            if (isset($_POST['ft_smfw_supplier'])) {
                update_post_meta($post_id, 'ft_smfw_supplier', sanitize_text_field($_POST['ft_smfw_supplier']));
            }
            if (isset($_POST['ft_smfw_supplier_price'])) {
                update_post_meta($post_id, 'ft_smfw_supplier_price', sanitize_text_field($_POST['ft_smfw_supplier_price']));
            }
            if (isset($_POST['ft_smfw_supplier_packaging'])) {
                update_post_meta($post_id, 'ft_smfw_supplier_packaging', sanitize_text_field($_POST['ft_smfw_supplier_packaging']));
            }
            if (isset($_POST['ft_smfw_supplier_part_number'])) {
                update_post_meta($post_id, 'ft_smfw_supplier_part_number', sanitize_text_field($_POST['ft_smfw_supplier_part_number']));
            }
        }

        /**
        * Hook called when a post is saved
        */
        public function save_post_variations($post_id)
        {
            // If this is just a revision, don't continue
            if (wp_is_post_revision($post_id)) return;

            // Update datas
            if (isset($_POST['ft_smfw_supplier_price'][$post_id])) {
                update_post_meta($post_id, 'ft_smfw_supplier_price', sanitize_text_field($_POST['ft_smfw_supplier_price'][$post_id]));
            }
            if (isset($_POST['ft_smfw_supplier_packaging'][$post_id])) {
                update_post_meta($post_id, 'ft_smfw_supplier_packaging', sanitize_text_field($_POST['ft_smfw_supplier_packaging'][$post_id]));
            }
            if (isset($_POST['ft_smfw_supplier_part_number'][$post_id])) {
                update_post_meta($post_id, 'ft_smfw_supplier_part_number', sanitize_text_field($_POST['ft_smfw_supplier_part_number'][$post_id]));
            }
        }

        public function variable_product_supplier_fields($loop, $variation_data, $variation)
        {
            $this->show_supplier_price_field($variation->ID, 'variation');
            $this->show_supplier_packaging_field($variation->ID, 'variation');
            $this->show_supplier_part_number_field($variation->ID, 'variation');
        }


        public function show_supplier_price_field($product_id, $type = 'simple')
        {
            woocommerce_wp_text_input(
                array(
                    'id'                => 'ft_smfw_supplier_price' . (('simple' == $type) ? '' : '[' . $product_id . ']'),
                    'label'             => sprintf(__("Supplier price (%s)", FT_SMFW_TEXT_DOMAIN), get_woocommerce_currency_symbol()),
                    'desc_tip'          => true,
                    'description'       => __("Enter here the negotiated price with the supplier", FT_SMFW_TEXT_DOMAIN),
                    'value'             => get_post_meta($product_id, 'ft_smfw_supplier_price', true),
                    'type'              => 'number',
                    'custom_attributes' => array(
                        'step' 	=> 'any',
                        'min'	=> '0'
                    )
                )
            );
        }

        public function show_supplier_packaging_field($product_id, $type = 'simple')
        {
            woocommerce_wp_text_input(
                array(
                    'id'                => 'ft_smfw_supplier_packaging' . (('simple' == $type) ? '' : '[' . $product_id . ']'),
                    'label'             => __("Packaging", FT_SMFW_TEXT_DOMAIN),
                    'desc_tip'          => true,
                    'description'       => __("Set the number of units in a package", FT_SMFW_TEXT_DOMAIN),
                    'value'             => get_post_meta($product_id, 'ft_smfw_supplier_packaging', true),
                    'type'              => 'number',
                    'custom_attributes' => array(
                        'step' 	=> 'any',
                        'min'	=> '0'
                    )
                )
            );
        }

        public function show_supplier_part_number_field($product_id, $type = 'simple')
        {
            woocommerce_wp_text_input(
                array(
                    'id'                => 'ft_smfw_supplier_part_number' . (('simple' == $type) ? '' : '[' . $product_id . ']'),
                    'label'             => __("Part number", FT_SMFW_TEXT_DOMAIN),
                    'desc_tip'          => true,
                    'description'       => __("Supplier part number identifier", FT_SMFW_TEXT_DOMAIN),
                    'value'             => get_post_meta($product_id, 'ft_smfw_supplier_part_number', true),
                    'type'              => 'text',
                    'custom_attributes' => array()
                )
            );
        }
	}
}

// Launch plugin
new FT_SMFW_wc_product();
