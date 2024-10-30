<?php 

/**
 * Plugin Name:          MartKit
 * Description:          Build the best WooCommerce Store
 * Version:              0.0.3
 * Author:               Engramium
 * Author URI:           www.engramium.com/
 * Text Domain:          martkit
 * Domain Path:          /languages
 * Requires at least:    4.5
 * Tested up to:         5.7.2
 * Requires PHP:         5.6
 * WC requires at least: 4.0
 * WC tested up to:      5.3.0
 * License:              GNU General Public License v3.0
 * License URI:          http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( !defined( 'ABSPATH' ) ) exit;

final class MartkitOptimizer {

    public $version    = '1.0';
    private $container = [];
    public  $token     = 'martkit';

    public function __construct() {
        $this->define_constants();
        
        register_activation_hook( __FILE__, array( $this, 'install' ) );

        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );

    }

    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Self();
        }

        return $instance;
    }

    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    public function define_constants() {
        define( 'MOPTIMIZER_VERSION', $this->version );
        define( 'MOPTIMIZER_SEPARATOR', ' | ');
        define( 'MOPTIMIZER_FILE', __FILE__ );
        define( 'MOPTIMIZER_ROOT', __DIR__ );
        define( 'MOPTIMIZER_PATH', dirname( MOPTIMIZER_FILE ) );
        define( 'MOPTIMIZER_INCLUDES', MOPTIMIZER_PATH . '/inc' );
        define( 'MOPTIMIZER_URL', plugins_url( '', MOPTIMIZER_FILE ) );
        define( 'MOPTIMIZER_ASSETS', MOPTIMIZER_URL . '/assets' );
    }

    /**
     * Load the plugin after all plugis are loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_classes();
        $this->init_hooks();
    }

    public function includes() {
        require_once MOPTIMIZER_INCLUDES . '/class-admin.php';
        require_once MOPTIMIZER_INCLUDES . '/class-settings-api.php';
        require_once MOPTIMIZER_INCLUDES . '/functions.php';
        require_once MOPTIMIZER_INCLUDES . '/martkit-atcctc-class.php';        
    }

    public function init_classes() {
        if ( is_admin() ) {
            $this->container['admin'] = new MWCOPTIMIZER\Admin();
        }else{
           new Martkit_Add_To_Cart_Text();
        }
    }

    public function init_hooks() {
        add_action( 'init', array( $this, 'localization_setup' ) );

        if ( class_exists( 'woocommerce' ) ) {
            // Remove the default WooCommerce single external product add to cart button.
            remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
            // Add the open in a new browser tab WooCommerce single external product add to cart button.
            add_action( 'woocommerce_external_add_to_cart', array( $this,'wc_external_add_to_cart'), 30 );
        } else {
            add_action( 'admin_notices', array( $this, 'martkit_install_woocommerce_core_notice' ) );
        }
    }

    public function localization_setup() {
        load_plugin_textdomain( 'martkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    public function install() {
      $this->log_plugin_version_number();
    }
  
    private function log_plugin_version_number() {
      // Log the version number.
      update_option( $this->token . '-version', $this->version );
    }


        public function martkit_install_woocommerce_core_notice() {
      echo '<div class="notice is-dismissible updated">
        <p>' . __( 'MartKit requires that you have the main WooCommerce plugin installed and activated.', 'martkit' ) . ' <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">' . __( 'Get WooCommerce now!', 'martkit' ) . '</a></p>
      </div>';
    }

  
    public function wc_external_add_to_cart() {
      global $product;
  
      if ( ! $product->add_to_cart_url() ) {
        return;
      }
  
      $product_url = $product->add_to_cart_url();
      $button_text = $product->single_add_to_cart_text();
  
      do_action( 'woocommerce_before_add_to_cart_button' ); ?>
  
      <p class="cart">
          <a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow noopener noreferrer" class="single_add_to_cart_button button alt" target="<?php echo ( !empty( get_option('martkit_affiliate_product_new_tab')['martkit_disable_external'] ) && get_option('martkit_affiliate_product_new_tab')['martkit_disable_external'] == 'yes' ) ? '_blank' : '_self'; ?>"><?php echo esc_html( $button_text ); ?></a>
      </p>
  
      <?php do_action( 'woocommerce_after_add_to_cart_button' );
  
    }


}


if( !function_exists('moptimizer') ) {
    function moptimizer() {
        return MartkitOptimizer::init();
    }
}

moptimizer();