<?php
/*
	Plugin Name: Oceanpayment WeChatPay Gateway
	Plugin URI: http://www.oceanpayment.com/
	Description: Oceanpayment WeChatPay Gateway.
	Version: 6.0
	Author: Oceanpayment
	Requires at least: 4.0
	Tested up to: 6.1
    Text Domain: oceanpayment-wechat-gateway
*/


/**
 * Plugin updates
 */

load_plugin_textdomain( 'oceanpayment-wechat-gateway', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );


add_filter('woocommerce_payment_gateways', 'woocommerce_oceanwechat_add_gateway' );

add_action( 'plugins_loaded', 'woocommerce_oceanwechat_init', 0 );

/**
 * Initialize the gateway.
 *
 * @since 1.4
 */
function woocommerce_oceanwechat_init() {

	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;

	require_once( plugin_basename( 'class-wc-oceanwechat.php' ) );


} // End woocommerce_oceanwechat_init()

/**
 * Add the gateway to WooCommerce
 *
 * @since 1.4
 */
function woocommerce_oceanwechat_add_gateway( $methods ) {
	$methods[] = 'WC_Gateway_Oceanwechat';
	return $methods;
} // End woocommerce_oceanwechat_add_gateway()

/**
 * Custom function to declare compatibility with cart_checkout_blocks feature
 */
function wc_oceanwechat_declare_cart_checkout_blocks_compatibility() {
    // Check if the required class exists
    if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
        // Declare compatibility for 'cart_checkout_blocks'
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('cart_checkout_blocks', __FILE__, true);
    }
}
// Hook the custom function to the 'before_woocommerce_init' action
add_action('before_woocommerce_init', 'wc_oceanwechat_declare_cart_checkout_blocks_compatibility');


add_action( 'woocommerce_blocks_loaded', 'wc_oceanwechat_register_order_approval_payment_method_type' );

function wc_oceanwechat_register_order_approval_payment_method_type() {

    // Check if the required class exists
    if ( ! class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
        return;
    }

    // Include the custom Blocks Checkout class
    require_once plugin_dir_path(__FILE__) . 'oceanwechat-block.php';
    // Hook the registration function to the 'woocommerce_blocks_payment_method_type_registration' action
    add_action(
        'woocommerce_blocks_payment_method_type_registration',
        function( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
            // Register an instance of My_Custom_Gateway_Blocks
            $payment_method_registry->register( new Oceanwechat_Gateway_Blocks );
        }
    );
}
