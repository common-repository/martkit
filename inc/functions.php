<?php 



/* Disable WooCommerce Admin, Analytics tab, Notification bar
/***********************************************************************/
if(!empty(martkit_get_options('martkit_admin_disable', 'yes' )) && (martkit_get_options('martkit_admin_disable', 'yes' ) == 'yes')){
	add_filter( 'woocommerce_admin_disabled', '__return_true' );
	
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    if ( version_compare( 'WC_VERSION', '4.4', '>' ) ) {
        // Old version code (example)
        	
	// fix for wc_admin_url in WooCommerce 5.0
	if ( ! function_exists( 'wc_admin_url') ) {
	function wc_admin_url( $path ) {
		return '#';
	}
	class WC_Notes_Run_Db_Update {}
	
	
	// 	fix for AutomateWoo

	
	function wc_admin_connect_page() {
	return;
	}


	function wc_admin_register_page() {
	return;
	}


	function wc_admin_is_registered_page() {
	return;
	}
}
    } else {
        	// fix for wc_admin_url in WooCommerce 5.0
	if ( ! function_exists( 'wc_admin_url') ) {
	function wc_admin_url( $path ) {
		return '#';
	}
	class WC_Notes_Run_Db_Update {}

    }
}
}
}

/* Marketing Hub
/***********************************************************************/

if(!empty(martkit_get_options('martkit_marketing_disable')) && (martkit_get_options('martkit_marketing_disable' ) == 'yes')){
	add_filter( 'woocommerce_marketing_menu_items', '__return_empty_array' );
	add_filter( 'woocommerce_admin_features', 'disable_features' );

function disable_features( $features ) {
	$marketing = array_search('marketing', $features);
	unset( $features[$marketing] );
	return $features;
}
}

/* Connect your store to WooCommerce.com to receive extensions updates and support. message for WooCommerce.com plugins
/***********************************************************************/

if( !empty( martkit_get_options('martkit_wc_helper_disable' ) ) && ( martkit_get_options('martkit_wc_helper_disable') == 'yes' ) ){
	add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );
}

/* Disable Password Strength Meter
/***********************************************************************/
if( !empty( martkit_get_options('martkit_password_meter_disable') ) && ( martkit_get_options('martkit_password_meter_disable') == 'yes' ) ) {
	add_action('wp_print_scripts', 'martkit_disable_password_strength_meter', 100);
}

function martkit_disable_password_strength_meter() {
	global $wp;

	$wp_check = isset($wp->query_vars['lost-password']) || (isset($_GET['action']) && $_GET['action'] === 'lostpassword') || is_page('lost_password');

	$wc_check = (class_exists('WooCommerce') && (is_account_page() || is_checkout()));

	if ( !$wp_check && !$wc_check ) {
		if( wp_script_is('zxcvbn-async', 'enqueued') ) {
			wp_dequeue_script('zxcvbn-async');
		}

		if( wp_script_is('password-strength-meter', 'enqueued') ) {
			wp_dequeue_script('password-strength-meter');
		}

		if( wp_script_is('wc-password-strength-meter', 'enqueued') ) {
			wp_dequeue_script('wc-password-strength-meter');
		}
	}
}

/* Disable WooCommerce Scripts
/***********************************************************************/
if( !empty( martkit_get_options('martkit_wc_scripts_disable') ) && ( martkit_get_options('martkit_wc_scripts_disable') == 'yes') ) {
	add_action('wp_enqueue_scripts', 'martkit_disable_woocommerce_scripts', 99);
}

function martkit_disable_woocommerce_scripts() {
	
	if( function_exists('is_woocommerce') ) {
		
		if( !is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() && !is_product() && !is_product_category() && !is_shop() ) {
			
			//Dequeue WooCommerce Styles
			wp_dequeue_style('woocommerce-general');
			wp_dequeue_style('woocommerce-layout');
			wp_dequeue_style('woocommerce-smallscreen');
			wp_dequeue_style('woocommerce_frontend_styles');
			wp_dequeue_style('woocommerce_fancybox_styles');
			wp_dequeue_style('woocommerce_chosen_styles');
			wp_dequeue_style('woocommerce_prettyPhoto_css');

			//Dequeue WooCommerce Scripts
			wp_dequeue_script('wc_price_slider');
			wp_dequeue_script('wc-single-product');
			wp_dequeue_script('wc-add-to-cart');
			wp_dequeue_script('wc-checkout');
			wp_dequeue_script('wc-add-to-cart-variation');
			wp_dequeue_script('wc-single-product');
			wp_dequeue_script('wc-cart');
			wp_dequeue_script('wc-chosen');
			wp_dequeue_script('woocommerce');
			wp_dequeue_script('prettyPhoto');
			wp_dequeue_script('prettyPhoto-init');
			wp_dequeue_script('jquery-blockui');
			wp_dequeue_script('jquery-placeholder');
			wp_dequeue_script('fancybox');
			wp_dequeue_script('jqueryui');

			if( !empty( martkit_get_options( 'martkit_wc_fragmentation_disable' ) ) && ( martkit_get_options('martkit_wc_fragmentation_disable') == 'yes' ) ) {
				wp_dequeue_script('wc-cart-fragments');
			}
		}
	}
}


/* Disable WooCommerce Cart Fragments
/***********************************************************************/
if( !empty( martkit_get_options('martkit_wc_fragmentation_disable') ) && ( martkit_get_options('martkit_wc_fragmentation_disable') == 'yes') ) {
	add_action( 'wp_enqueue_scripts', 'martkit_disable_woocommerce_cart_fragments', 99);
}

function martkit_disable_woocommerce_cart_fragments() {
	if( function_exists('is_woocommerce') ) {
		wp_dequeue_script('wc-cart-fragments');
	}
}


/* Disable WooCommerce Status Meta Box
/***********************************************************************/
if( !empty( martkit_get_options('martkit_wc_status_meta_box_disable') ) && ( martkit_get_options('martkit_wc_status_meta_box_disable') == 'yes' ) ) {
	add_action('wp_dashboard_setup', 'martkit_disable_woocommerce_status');
}

function martkit_disable_woocommerce_status() {
	remove_meta_box('woocommerce_dashboard_status', 'dashboard', 'normal');
}




/* Disable WooCommerce Marketplace Suggestions
/***********************************************************************/
if(!empty( martkit_get_options('martkit_wc_marketplace') ) && ( martkit_get_options('martkit_wc_marketplace') == 'yes') ) {
	add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false', 999 );
}


/* Disable Extensions submenu
/***********************************************************************/
if(!empty(martkit_get_options('martkit_remove_addon_submenu')) && ( martkit_get_options('martkit_remove_addon_submenu') == 'yes') ) {
		
	add_action( 'admin_menu', 'martkit_remove_admin_addon_submenu', 999 );
		
	function martkit_remove_admin_addon_submenu() {
		remove_submenu_page( 'woocommerce', 'wc-addons');
	}
}



/* Disable WooCommerce Widgets
/***********************************************************************/
if(!empty(martkit_get_options('martkit_wc_widgets_disable')) && (martkit_get_options('martkit_wc_widgets_disable') == 'yes')) {
	add_action('widgets_init', 'martkit_disable_woocommerce_widgets', 99);
}


function martkit_disable_woocommerce_widgets() {
	unregister_widget('WC_Widget_Products');
	unregister_widget('WC_Widget_Product_Categories');
	unregister_widget('WC_Widget_Product_Tag_Cloud');
	unregister_widget('WC_Widget_Cart');
	unregister_widget('WC_Widget_Layered_Nav');
	unregister_widget('WC_Widget_Layered_Nav_Filters');
	unregister_widget('WC_Widget_Price_Filter');
	unregister_widget('WC_Widget_Product_Search');
	unregister_widget('WC_Widget_Recently_Viewed');
	unregister_widget('WC_Widget_Recent_Reviews');
	unregister_widget('WC_Widget_Top_Rated_Products');
	unregister_widget('WC_Widget_Rating_Filter');
}



function martkit_get_options($key = '' ) {
    $settings = get_option( 'martkit_wc', [] );

    if ( empty( $key ) ) {
        return $settings;
    }

    if ( isset( $settings[ $key ] ) ) {
        return $settings[ $key ];
    }
}



function martkit_wc_order_counter( $atts, $content = null ) {

    $args = shortcode_atts( array(
        'status' => 'completed',
    ), $atts );

    $statuses    = array_map( 'trim', explode( ',', $args['status'] ) );
    $order_count = 0;

    foreach ( $statuses as $status ) {

        // if we didn't get a wc- prefix, add one
        if ( 0 !== strpos( $status, 'wc-' ) ) {
            $status = 'wc-' . $status;
        }

        $order_count += wp_count_posts( 'shop_order' )->$status;
    }

    ob_start();

    echo number_format( $order_count );

    return ob_get_clean();
}
add_shortcode( 'martkit_wc_order_count', 'martkit_wc_order_counter' );



function martkit_wc_default_login_redirect_get_phpsessid(){
    $id = '';
    if( isset( $_COOKIE['PHPSESSID'] ) ){
        $id = $_COOKIE['PHPSESSID'];
    }
    if( !isset( $id ) ){
        $ckis = explode( ';', $_SERVER['HTTP_COOKIE'] );
        foreach( $ckis as $ck ){
            if( strpos( $ck, 'PHPSESSID' ) !== false ){
                $id = str_replace( 'phpsesside', '', sanitize_title( $ck ) );
            }
        }
    }
    return $id;
}
// get  referer url and save it
function martkit_wc_default_login_redirect_url() {
    $woo_acc_url = esc_url_raw( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
    if( isset( $woo_acc_url ) && $woo_acc_url != '' ){
        $woo_acc_url_slug = sanitize_title( str_replace( esc_url_raw( home_url() ), '', $woo_acc_url ) );
        if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ){
            if( strpos( $_SERVER['HTTP_REFERER'], $woo_acc_url_slug ) === false ){
                // only if the url does not contain 'my-account'
                // $_SESSION['wlpr_referer_url'] = $_SERVER['HTTP_REFERER'];
                $psid = martkit_wc_default_login_redirect_get_phpsessid();
                update_option( 'wlpr_referer_url' . $psid, $_SERVER['HTTP_REFERER'] );
            }
        }
    }
}

if ( !empty( get_option('martkit_previous_page_redirect')['martkit_previous_page_redirect_woocommerce'] ) && get_option('martkit_previous_page_redirect')['martkit_previous_page_redirect_woocommerce'] == 'yes' )  {

    add_action( 'template_redirect', 'martkit_wc_default_login_redirect_url' );
    add_filter( 'woocommerce_login_redirect', 'martkit_wc_default_login_redirect', 10, 2 );
}

function martkit_wc_default_login_redirect() {
    //get option from db
    //remove it
    $psid = martkit_wc_default_login_redirect_get_phpsessid();
    $ref_url = get_option( 'wlpr_referer_url' . $psid, null );
    if ( $ref_url !== null ) {
        delete_option( 'wlpr_referer_url' . $psid );
        return $ref_url;
    }
}
