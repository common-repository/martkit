<?php
namespace MWCOPTIMIZER;

class Admin {

    private $settings_api;

    public function __construct() {
        
        $this->settings_api = new DWCSettings_API();

        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
        add_action ('admin_init', [$this, 'registra_opciones']);
        add_action( 'admin_init', [ $this, 'admin_init' ] );
    }

    public function admin_init() {
        //set the settings

        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function get_settings_sections() {

        $sections = array(
            array(
                'id'    => 'martkit_wc',
                'title' => 'Please consider reloading the page after saving changes to see the results. It\'s highly recommended.',
                'name' => __( 'Optimize WooCommerce', 'martkit' )
            ),
             array(
                'id'    => 'martkit_order_counter',
                'title' => 'Use [martkit_wc_order_count] shortcode to display the total number of WooCommerce completed orders.',
                'name' => __( 'Display Order Count', 'markit' ),            
             ),
             
             array(
                'id'    => 'martkit_affiliate_product_new_tab',
                'title' => 'Set all external / affiliate product buy now links on a WooCommerce site to open in a new web browser tab.',
                'name' => __( 'External/Affiliate Product New Tab', 'markit' ),            
            ),

            array(
                'id'    => 'martkit_previous_page_redirect',
                'title' => 'After logged in from WooCommerce My Account page, this settings will redirect the user to the previous page or product they were checking.',
                'name' => __( 'Redirection', 'markit' ),            
            ) 
        );

        return apply_filters( 'martkit_settings_sections', $sections );
    }

    public function get_settings_fields() {
        
        $settings_fields = [
            'martkit_affiliate_product_new_tab' => [
                [
                    'name'     => __( 'martkit_disable_external', 'martkit' ),
                    'label'    => __( 'External/Affiliate Product New Tab', 'martkit' ),
                    'id'       => 'martkit_disable_external',
                    'type'     => 'checkbox',
                    'desc'     => __( 'Enable External/Affiliate Product New Tab' ),
                ],


            ],
              'martkit_previous_page_redirect' => [
                [
                    'name'     => __( 'martkit_previous_page_redirect_woocommerce', 'martkit' ),
                    'label'    => __( 'Previous Page Redirect', 'martkit' ),
                    'id'       => 'martkit_previous_page_redirect_woocommerce',
                    'type'     => 'checkbox',
                    'desc'     => __( 'Enable Previous Page Redirection' ),
                ],

                
            ],
            'martkit_wc' => [
                [
                    'name'     => __( 'martkit_admin_disable', 'martkit' ),
                    'label'    => __( 'WooCommerce Admin', 'martkit' ),
                    'id'       => 'martkit_admin_disable',
                    'type'     => 'checkbox',
                    'desc'     => __( 'Disable WooCommerce Admin' ),
                    'desc_tip' => __( '<a href="https://woocommerce.com/posts/woocommerce-admin-a-new-central-dashboard-for-woocommerce/" target="_blank">WooCommerce Admin</a> is a new advanced filterable JavaScript-driven interface for managing your store. Which also includes the Analytics tab and Notification bar. Mark the checkbox as checked in order to completely disable WooCommerce Admin, Analytics tab, and Notification bar. The home screen feature will also be disabled.', 'martkit' ),
                ],

                [
                    'name'     => __( 'martkit_marketing_disable', 'martkit' ),
                    'label'    => __( 'Marketing Hub', 'martkit' ),
                    'id'       => 'martkit_marketing_disable',
                    'type'     => 'checkbox',
                    'desc'     => __( 'Disable Marketing Hub' ),
                    'desc_tip' => __( 'From WooCommerce 4.1, there is a new <a href="https://docs.woocommerce.com/document/marketing-hub/" target="_blank">Marketing</a> menu item to the WordPress Dashboard. Which Includes Installed Marketing Extensions, Recommended Extensions, WooCommerce Knowledge Base, and Coupons Management. By marking this checkbox as checked will allow to completely disable WooCommerce Marketing Hub. But the Coupon menu and its functionality will be accessible in the old way by navigating (WooCommerce -> Coupons).</a>.', 'martkit' ),
                ],

                [
                    'name' => __( 'Admin interface', 'martkit' ),
                    'label' => __( '<h1>Admin Interface: </h1>', 'martkit' ),
                    'type' => 'title',
                    'id' => 'martkit_interface',
                    'desc' => __( '<h3>Make your Admin Panel a.k.a ( <a href="/wp-admin/index.php">WordPress Dashboard</a> )faster and cleaner by using the following options. Which will eventually contribute to the overall store experience.</h3>', 'martkit' ),
                    'desc_tip' => __( 'Enabling this option will remove WooCommerce Status Meta Box from <a href="/wp-admin/index.php">WordPress Dashboard</a>.', 'martkit' ),
                ],

                [
                    'name'     => __( 'martkit_wc_helper_disable', 'martkit' ),
                    'label'     => __( 'WooCommerce.com', 'martkit' ),
                    'id'       => 'martkit_wc_helper_disable',
                    'type'     => 'checkbox',
                    'desc'     => __( 'Disable WooCommerce.com notice', 'martkit' ),
                    'desc_tip' => __( 'WooCommerce version 3.3.1+ has introduced a notice of an admin area a.k.a ( <a href="/wp-admin/index.php">WordPress Dashboard</a>) message that says “Connect your store to WooCommerce.com to receive extensions updates and support.” Use this checkbox to remove that admin message.', 'martkit' ),
                ],

                [
                    'name'     => __( 'martkit_wc_status_meta_box_disable', 'martkit' ),
                    'label'     => __( 'WooCommerce Status Meta Box ', 'martkit' ),
                    'id'       => 'martkit_wc_status_meta_box_disable',
                    'type'     => 'checkbox',
                    'css'      => 'min-width:300px;',
                    'desc'     => __( 'Disable WooCommerce Status Meta Box', 'martkit' ),
                    'desc_tip' => __( 'By default, WooCommerce has a status meta box (widget) that loads in the WordPress dashboard. A lot of times this isn’t used. In this case, if you aren’t using it, it is better to disable it to speed up the admin area.', 'martkit' ),
                ],

                [
                    'name'     => __( 'martkit_wc_marketplace', 'martkit' ),
                    'label'     => __( 'Marketplace Suggestions', 'martkit' ),
                    'desc_tip' => __( 'This option will disable Marketplace Suggestions.', 'martkit' ),
                    'id'       => 'martkit_wc_marketplace',
                    'type'     => 'checkbox',
                    'css'      => 'min-width:300px;',
                    'desc'     => __( 'WooCommerce displays plugin ads in the admin area for their Marketplace. Basically, WooCommerce version 3.6+ has introduced <a href="https://woocommerce.com/posts/marketplace-suggestions/" target="_blank">“Marketplace Suggestions.”</a> The suggestions to the products admin screen, which vary based on whether it’s an empty state or within the list of products. ', 'martkit' ),
                ],

                [
                    'name'     => __( 'martkit_remove_addon_submenu', 'martkit' ),
                    'label'     => __( 'Extensions submenu', 'martkit' ),
                    'desc_tip' => __( 'The Extensions submenu basically is an <a href="https://woocommerce.com/products/" target="_blank">Extension Store</a> that enables easy purchasing from WooCommerce. Similar to WordPress plugins, WooCommerce extensions add extra features to the store. But in most cases, it\'s left unused. If this is the case, hide the Extensions submenu from the WooCommerce Admin menu, in your admin panel. Disabling this submenu will contribute to the store loading time.', 'martkit' ),
                    'id'       => 'martkit_remove_addon_submenu',
                    'type'     => 'checkbox',
                    'css'      => 'min-width:300px;',
                    'desc'     => __( 'Disable Extensions submenu', 'martkit' ),
                ],


                [
                    'name' => __( 'martkit_performance', 'martkit' ),
                    'label' => __( '<h1>Site Performance</h1>', 'martkit' ),
                    'type' => 'title',
                    'id' => 'martkit_performance',
                    'desc' => __( '<h3>Reduce HTTP requests on the front end of the store. Disable scripts and styles that are slowing the store. Please be careful while configuring the options below to make the WooCommerce shop clean and lightweight, as they can affect some of the features that the store usages.</h3>', 'martkit' ),
                ],


                [
                    'name'     => __( 'martkit_password_meter_disable', 'martkit' ),
                    'label'     => __( 'Password Strength Meter', 'martkit' ),
                    'desc_tip' => __( 'WooCommerce has an integrated Password Strength Meter which forces users to use strong passwords. Making this checkbox as checked, will allow removing the WordPress and WooCommerce password strength meter scripts (over 400 KB) from non-essential pages.', 'martkit' ),
                    'id'       => 'martkit_password_meter_disable',
                    'type'     => 'checkbox',
                    'desc'     => __( 'Disable Password Strength Meter', 'martkit' ),
                ],

                [
                    'name'     => __( 'martkit_wc_scripts_disable', 'martkit' ),
                    'label'     => __( 'WooCommerce scripts and styles', 'martkit' ),
                    'desc_tip' => __( 'After activating WooComerce it loads its scripts and styles on every page of the site. This is definitely not great for website performance. In a test case, WooCommerce was loading 8 scripts on the home page, where there aren\'t even have any products. Marking this checkbox as checked, will disable WooCommerce scripts and styles everywhere except on product, cart, and checkout pages.

', 'martkit' ),
                    'id'       => 'martkit_wc_scripts_disable',
                    'type'     => 'checkbox',
                    'desc'     => __( 'Disable WooCommerce scripts and styles', 'martkit' ),
                ],

                [
                    'name'     => __( 'martkit_wc_fragmentation_disable', 'martkit' ),
                    'label'     => __( 'WooCommerce Cart Fragments', 'martkit' ),
                    'desc_tip' => __( 'WooCommerce “Cart Fragments” is a script using admin ajax to update the cart without refreshing the page. This functionality will slow down the speed of your site or break caching on pages that don\'t actually require cart information. <strong>Noteworthy:</strong> Disabling it will speed up the WooCommerce store, but it may result in the wrong calculations in the mini cart. Please use it with sharp consent and caution.' ),
                    'id'       => 'martkit_wc_fragmentation_disable',
                    'type'     => 'checkbox',
                    'css'      => 'min-width:300px;',
                    'desc'     => __( 'Disable WooCommerce Cart Fragments', 'martkit' ),
                ],
                
                [
                    'name'     => __( 'martkit_wc_widgets_disable', 'martkit' ),
                    'label'     => __( 'WooCommerce Widgets', 'martkit' ),
                    'desc_tip' => __( 'By default, WooCommerce comes with a decent number of widgets installed. They often are not used at all but those widgets add backend and front-end load. Use this option to disable the WooCommerce widgets. <strong>Noteworthy: </strong>Please make sure that you are <a href="/wp-admin/widgets.php">not using any of WooCommerce Widgets</a> anywhere in your site.', 'martkit' ),
                    'id'       => 'martkit_wc_widgets_disable',
                    'type'     => 'checkbox',
                    'css'      => 'min-width:300px;',
                    'desc'     => __( 'Disable WooCommerce Widgets', 'martkit' ),
                ],

            ],


        ];

        return apply_filters( 'martkit_settings_fields', $settings_fields );
    }

    public function admin_menu() {
        global $submenu;

        $capability = 'manage_options';
        $slug       = 'martkit-home';

        $hook = add_menu_page( __( 'MartKit Home', 'martkit' ), __( 'MartKit', 'martkit' ), $capability, $slug, [ $this, 'settings_page' ], 'dashicons-admin-generic' );
        add_submenu_page( $slug, 'MartKit Customizer', 'Add to Cart Text', 'manage_options', 'martkit-customizer', [ $this,'martkit_addto_cart_button_text_customizer']);
         
    }

    function martkit_addto_cart_button_text_customizer (){

        $this -> add_to_cart_opciones();

    }


    public function settings_page() {
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php esc_html_e( 'MartKit: Build the best WooCommerce Store', 'martkit' ) ?></h1><br>
            <div class="martkit-settings-wrap">
                <?php
                    $this->settings_api->show_navigation();
                    $this->settings_api->show_forms();
                ?>
            </div>
        </div>
        <?php
        
    }
    public function registra_opciones () {

            register_setting ('addtocart-opciones', 'add_to_cart_button_text_settings');
            }

        public function add_to_cart_opciones () {

            current_user_can ('manage_options') or wp_die (__('Sorry, you are not allowed to access this page.'));

            $this->carga_opciones();

            ?>

            <div class="wrap">

                <h2><?php _e(' Change the Default Add To Cart Button Text', 'martkit'); ?></h2>

                <hr>

                <form method="post" action="options.php">

                    <?php

                        settings_fields ('addtocart-opciones');
                        do_settings_sections ('addtocart-opciones');

                        $idioma  = get_locale();
                        $general = substr ($idioma, 0, 2);

                    ?>

                    <h3><?php _e('Button text in single product pages: Custom text for the Add to cart button in single product pages by product type', 'martkit'); ?></h3>

                    <table class="form-table">
                
                        <tr valign="top">

                            <th scope="row"><?php _e('Simple product Downloadable & Virtual', 'woocommerce'); ?></th>
                            <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_simple_single]" value="<?php _e(esc_attr ($this->add_to_cart_simple_single)); ?>" /></td>

                        </tr>

                        <tr valign="top">

                            <th scope="row"><?php _e('External/Affiliate product', 'woocommerce'); ?></th>
                            <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_external_single]" value="<?php _e(esc_attr ($this->add_to_cart_external_single)); ?>" /></td>

                        </tr>
                
                        <tr valign="top">

                            <th scope="row"><?php _e('Variable product', 'woocommerce'); ?></th>
                            <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_variable_single]" value="<?php _e(esc_attr ($this->add_to_cart_variable_single)); ?>" /></td>

                        </tr>
                
                        <tr valign="top">

                            <th scope="row"><?php _e('Grouped product', 'woocommerce'); ?></th>
                            <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_grouped_single]" value="<?php _e(esc_attr ($this->add_to_cart_grouped_single)); ?>" /></td>

                        </tr>

                        <?php if (post_type_exists ('bookable_resource')) : ?>
                
                            <tr valign="top">

                                <th scope="row"><?php _e('Bookable product', 'woocommerce-bookings'); ?></th>
                                <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_bookable_single]" value="<?php _e(esc_attr ($this->add_to_cart_bookable_single)); ?>" /></td>

                            </tr>

                        <?php endif; ?>

                    </table>

                    <hr />

                    <h3><?php _e('Button text in archive pages: Custom text for the Add to cart button in archive pages (shop, category, tags...) by product type', 'martkit'); ?></h3>

                    <table class="form-table">

                        <tr valign="top">

                            <th scope="row"><?php _e('Simple product', 'woocommerce'); ?></th>
                            <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_simple]" value="<?php _e(esc_attr ($this->add_to_cart_simple)); ?>" /></td>

                        </tr>

                        <tr valign="top">

                            <th scope="row"><?php _e('External/Affiliate product', 'woocommerce'); ?></th>
                            <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_external]" value="<?php _e(esc_attr ($this->add_to_cart_external)); ?>" /></td>

                        </tr>
                

                        <tr valign="top">

                            <th scope="row"><?php _e('Variable product', 'woocommerce'); ?></th>
                            <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_variable]" value="<?php _e(esc_attr ($this->add_to_cart_variable)); ?>" /></td>

                        </tr>
                
                        <tr valign="top">

                            <th scope="row"><?php _e('Grouped product', 'woocommerce'); ?></th>
                            <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_grouped]" value="<?php _e(esc_attr ($this->add_to_cart_grouped)); ?>" /></td>

                        </tr>

                        <?php if (post_type_exists ('bookable_resource')): ?>
                
                            <tr valign="top">

                                <th scope="row"><?php _e('Bookable product', 'woocommerce-bookings'); ?></th>
                                <td><input type="text" name="add_to_cart_button_text_settings[add_to_cart_bookable]" value="<?php _e(esc_attr ($this->add_to_cart_bookable), 'woocommerce-bookings'); ?>" /></td>

                            </tr>

                        <?php endif; ?>

                    </table>
            
                    <?php submit_button(); ?>

                </form>

            <?php if ('es' == $general) : ?>

                <div style="padding:10px 25px;border:2px solid #ec731e;border-radius:4px;">

                    <h3>Otros plugins para WooCommerce que te pueden interesar</h3>

                    <ul>

                        <?php if ('es_ES' == $idioma || 'ca_ES' == $idioma) { ?>

                            <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-provincias-envios-woocommerce/">Plugin para seleccionar a qué provincias se realizan envíos (España)</a></li>
                            <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-pedir-nif-pedidos-woocommerce/">Plugin para pedir el NIF/CIF en los pedidos</a> <?php if (class_exists ('WPO_WCPDF')) echo '(compatible con WooCommerce PDF Invoices & Packing Slips, permite insertar el NIF en la factura)'; ?></li>

                        <?php } elseif ('es_AR' == $idioma) { ?>

                            <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-envio-provincias-argentina-woocommerce/">Plugin para seleccionar a qué provincias se realizan envíos (Argentina)</a></li>

                        <?php } elseif ('es_MX' == $idioma) { ?>

                            <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-envio-provincias-mexico-woocommerce/">Plugin para seleccionar a qué provincias se realizan envíos (México)</a></li>

                        <?php } elseif ('es_CO' == $idioma) { ?>

                            <li><a target="_blank" href="https://www.enriquejros.com/plugins/anadir-departamentos-colombia-woocommerce/">Añadir departamentos de Colombia a WooCommerce</a></li>

                        <?php } elseif ('es_UY' == $idioma) { ?>

                            <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-anadir-los-departamentos-uruguay-woocommerce/">Añadir departamentos de Uruguay a WooCommerce</a></li>

                        <?php } ?>

                        <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-contenido-email-pedido-woocommerce/">Plugin para añadir contenido personalizado en el email del pedido</a></li>
                        <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-personalizar-checkout-woocommerce/">Plugin para personalizar campos del checkout</a></li>
                        <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-zonas-envio-personalizadas-woocommerce/">Plugin para personalizar los estados/provincias/departamentos</a></li>
                        <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-insertar-pixel-facebook-woocommerce/">Plugin para insertar el píxel de Facebook en WooCommerce</a></li>
                        <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-pestanas-mi-cuenta-woocommerce/">Plugin para añadir pestañas personalizadas en la página <i>Mi cuenta</i></a></li>
                        <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-directo-checkout-sin-carrito/">Plugin para ir directo al checkout sin pasar por el carrito</a></li>
                        <li><a target="_blank" href="https://www.enriquejros.com/plugins/quitar-intervalo-precios-productos-variables/">Plugin para quitar el intervalo de precios en productos variables</a></li>
                        <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-envio-gratuito-woocommerce/">Plugin para ocultar las formas de envío si está disponible el envío gratuito</a></li>
                        <li><a target="_blank" href="https://www.enriquejros.com/plugins/plugin-pedido-minimo-woocommerce/">Plugin para establecer un pedido mínimo</a></li>
                        
                    </ul>

                </div>

                <?php endif; ?>

            </div>

            <?php
            }

        /**
         * For retrocompatibility purposes
         *
         * @since 3.0.0
         *
         */
        private function carga_opciones () {

            $this->addtocart     = __('Add to cart', 'woocommerce');
            $this->buyproduct    = _x('Buy product', 'placeholder', 'woocommerce');
            $this->selectoptions = __('Select options', 'woocommerce');
            $this->viewproducts  = __('View products', 'woocommerce');
            $this->booknow       = __('Book now', 'woocommerce-bookings');

            $opciones = array(
                'add_to_cart_external'          => $this->buyproduct,
                'add_to_cart_grouped'           => $this->viewproducts,
                'add_to_cart_simple'            => $this->addtocart,
                'add_to_cart_variable'          => $this->selectoptions,
                'add_to_cart_external_single'   => $this->buyproduct,
                'add_to_cart_grouped_single'    => $this->addtocart,
                'add_to_cart_simple_single'     => $this->addtocart,
                'add_to_cart_variable_single'   => $this->addtocart,
                'add_to_cart_bookable'          => $this->booknow,
                'add_to_cart_bookable_single'   => $this->booknow,
                );

            if ($this->ajustes = get_option ('add_to_cart_button_text_settings'))
                foreach ($opciones as $opcion => $default)
                    $this->$opcion = isset ($this->ajustes[$opcion]) ? $this->ajustes[$opcion] : false;

            else { //New install or updated from 2.3.0

                foreach ($opciones as $opcion => $default) {

                    $this->$opcion          = get_option ($opcion, $default);
                    $this->ajustes[$opcion] = $this->$opcion;
                    }

                update_option ('add_to_cart_button_text_settings', $this->ajustes);
                }
            }

        
}