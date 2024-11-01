<?php
/*
Plugin Name: Jet Integration for Woocommerce
Plugin URI: https://jetintegration.co
Description: JET Integration Plugin, a complete solution for integrating your online store with Jet.com
Tested up to: 4.9.4
Version: 1.0.0
Author: JetIntegration
Author URI: https://jetintegration.co
*/

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{
	ini_set('precision',100);
	ini_set('serialize_precision',100);
	define('nuevejet_url',plugin_dir_url(__FILE__ ));
	define('nuevejet_path',plugin_dir_path(__FILE__ ));
	define('nuevejet_admin_path', plugin_dir_path(__FILE__ ).'/admin');
	define('nuevejet_tab_path',plugin_dir_path(__FILE__ ).'/tabs');
	define('INVALID_LOGIN','You must have an JetIntgration account (https://jetintegration.co) in order to use this plugin');
	define('API_ERROR', 'API user & API password either or Invalid. Please set API user & API pass from jet configuration.');
	$jet_wordpress_plugin_url = admin_url('/admin.php?page=Jet-Integration');
	define('jet_wordpress_plugin_url', $jet_wordpress_plugin_url);

	if ( !defined('ABSPATH') )
		define('ABSPATH', dirname(__FILE__) . '/');
	/* Loading Function */
	require_once(nuevejet_admin_path.'/index.php');
	require_once(nuevejet_admin_path.'/functions.php');
	require_once(nuevejet_admin_path.'/NueveJetIntegration.php');
	$NueveJetInstance = NueveJetIntegration::getInstance();
	//register activation hook.
	register_activation_hook( __FILE__ , array( $NueveJetInstance , 'nuevejet_activation' ) );
	//adding custom tab in product edit page.
	add_action('woocommerce_product_write_panel_tabs', array($NueveJetInstance,'nuevejet_WooCustomTab'));
	//custom tab fields.
	add_action('woocommerce_product_write_panels', array($NueveJetInstance,'nuevejet_WooCustomTabFields'));
	//processing product custom tab values.
	add_action('woocommerce_process_product_meta', array($NueveJetInstance,'nuevejet_WooProcessProductMeta'));
	// Add Variation Settings
	add_action( 'woocommerce_product_after_variable_attributes',array($NueveJetInstance,'nuevejet_variation_settings'), 10, 3 );
	// Save Variation Settings
	add_action( 'woocommerce_save_product_variation',array($NueveJetInstance,'nuevejet_save_variation_settings'), 10, 2 ); 
	add_action('admin_enqueue_scripts', array($NueveJetInstance,'nuevejet_scripts'));
	add_action('wp_ajax_jet_checkapiaccess',array($NueveJetInstance,'nuevejet_checkapiaccess'));
	add_action('wp_ajax_jet_save_configuration_settings',array($NueveJetInstance,'nuevejet_save_configuration_settings'));
	add_action('wp_ajax_jet_reset_configuration_settings',array($NueveJetInstance,'nuevejet_reset_configuration_settings'));
	add_action('wp_ajax_mapped_category_list',array($NueveJetInstance,'nuevejet_mapped_category_list'));
	add_action('wp_ajax_mapped_add_category',array($NueveJetInstance,'nuevejet_mapped_add_category'));
	add_action('wp_ajax_mapped_category_delete',array($NueveJetInstance,'nuevejet_mapped_category_delete'));
	add_action('wp_ajax_jet_get_woo_products_list',array($NueveJetInstance,'nuevejet_get_woo_products_list'));
	add_action('wp_ajax_jet_upload_product',array($NueveJetInstance,'nuevejet_upload_product'));
	add_action('wp_ajax_jet_update_product_status',array($NueveJetInstance,'nuevejet_update_product_status'));

	add_action('wp_ajax_jet_oupload_product',array($NueveJetInstance,'nuevejet_oupload_product'));
	add_action('wp_ajax_jet_product_update_price',array($NueveJetInstance,'nuevejet_product_update_price'));
	add_action('wp_ajax_jet_product_update_inventory',array($NueveJetInstance,'nuevejet_product_update_inventory'));
	add_action('wp_ajax_jet_get_products_list',array($NueveJetInstance,'nuevejet_get_products_list'));
	add_action('wp_ajax_jet_get_product_details',array($NueveJetInstance,'nuevejet_get_product_details'));
	add_action('wp_ajax_jet_update_product_details', array($NueveJetInstance, 'nuevejet_update_product_details'));
	add_action('wp_ajax_jet_get_category_attributes',array($NueveJetInstance,'nuevejet_get_category_attributes'));

	add_action('wp_ajax_jet_refresh_data',array($NueveJetInstance,'nuevejet_refresh_data'));
	add_action('wp_ajax_jet_get_orders_list',array($NueveJetInstance,'nuevejet_get_orders_list'));
	add_action('wp_ajax_jet_get_order_details',array($NueveJetInstance,'nuevejet_get_order_details'));
	add_action('wp_ajax_jet_acknowledge_order',array($NueveJetInstance,'nuevejet_acknowledge_order'));
	add_action('wp_ajax_jet_order_cancel',array($NueveJetInstance,'nuevejet_order_cancel'));
	add_action('wp_ajax_jet_ship_order',array($NueveJetInstance,'nuevejet_ship_order'));
	add_action('wp_ajax_jet_request_refund_order',array($NueveJetInstance,'nuevejet_request_refund_order'));
	add_action('wp_ajax_get_jet_returns_list',array($NueveJetInstance,'nuevejet_get_returns_list'));
	add_action('wp_ajax_get_jet_return_details',array($NueveJetInstance,'nuevejet_get_return_details'));
	add_action('wp_ajax_jet_return_complete',array($NueveJetInstance,'nuevejet_return_complete'));
	add_action('wp_ajax_get_jet_refunds_list',array($NueveJetInstance,'nuevejet_get_refunds_list'));
	add_action('wp_ajax_get_jet_refund_details',array($NueveJetInstance,'nuevejet_get_refund_details'));
}
?>