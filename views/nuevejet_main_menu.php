<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

$jet_tab = $_GET['tab'];
?>

<style type="text/css">
.loading-style-bg {
    background-color: rgba(51, 51, 51, 0.56);
    height: 100%;
    position: fixed;
    text-align: center;
    top: 0;
    width: 90%;
    z-index: 999;
    margin-left: -20px;
}
.loading-style-bg img {
	height: 65px;
    position: relative;
    top: 30%;
    width: 62px;
    margin-top: 50px;
}

.loading-style-bg .loading-content {
	color:#fff;
	display:none;
}

/*.jetintgration_menus {
  display:none;
}*/

</style>


<?php
$nuevejet_url = nuevejet_url;
$invalid_login = INVALID_LOGIN;
$api_error = API_ERROR;

$loading_link =  $nuevejet_url.'images/BigCircleBall.gif';

$settings_link = jet_wordpress_plugin_url.'&tab=settings';
$mapping_categories_link = jet_wordpress_plugin_url.'&tab=mapping-categories';
$products_link = jet_wordpress_plugin_url.'&tab=products';
$jet_products_link = jet_wordpress_plugin_url.'&tab=jet-products';
$jet_orders_link = jet_wordpress_plugin_url.'&tab=jet-orders';
$jet_returns_link = jet_wordpress_plugin_url.'&tab=jet-returns';
$jet_refunds_link = jet_wordpress_plugin_url.'&tab=jet-refunds';

$jet_checkapiaccess_nonce_check = wp_create_nonce('jet_checkapiaccess_nonce_check');
$jet_refresh_data_nonce_check = wp_create_nonce('jet_refresh_data_nonce_check');
?>

<div id="plugin_path_link" style="display:none;"><?php esc_url( _e($nuevejet_url,'nueve-woocommerce-jet-integration') ); ?></div>
<div id="jet_path_res" style="display:none;"><?php _e($invalid_login,'nueve-woocommerce-jet-integration');?></div>
<div id="api_error" style="display:none;"><?php _e($api_error,'nueve-woocommerce-jet-integration');?></div>

<div id="jet-loading" class="loading-style-bg" style="display: none;">
	<img src="<?php esc_url( _e($loading_link,'nueve-woocommerce-jet-integration') ); ?>">
	<p class="loading-content"><?php _e('Processing... Please Wait..','nueve-woocommerce-jet-integration');?></p>
</div>

<input type="hidden" id="settings_link" value="<?php esc_url( _e($settings_link,'nueve-woocommerce-jet-integration') ); ?>" />
<input type="hidden" name="jet_checkapiaccess_secure_key" value="<?php _e($jet_checkapiaccess_nonce_check,'nueve-woocommerce-jet-integration'); ?>" id="jet_checkapiaccess_secure_key">
<input type="hidden" name="jet_refresh_data_secure_key" value="<?php _e($jet_refresh_data_nonce_check,'nueve-woocommerce-jet-integration'); ?>" id="jet_refresh_data_secure_key">

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" /> -->

<div class="topnav">

  <a class="jet_menus <?php if($jet_tab == '' || $jet_tab == 'settings' )
   { _e('active','nueve-woocommerce-jet-integration'); } ?>" 
    href="<?php esc_url( _e($settings_link,'nueve-woocommerce-jet-integration') ); ?>">
  <?php _e('Settings','nueve-woocommerce-jet-integration');?> </a>

  <a class="jet_menus <?php if($jet_tab == 'mapping-categories' ) 
    { _e('active','nueve-woocommerce-jet-integration'); } ?>" 
    href="<?php esc_url( _e($mapping_categories_link,'nueve-woocommerce-jet-integration') ); ?>" >
  <?php _e('Mapping Categories','nueve-woocommerce-jet-integration');?> </a>

  <a class="jet_menus <?php if($jet_tab == 'products' ) 
    { _e('active','nueve-woocommerce-jet-integration'); } ?>" 
    href="<?php esc_url( _e($products_link,'nueve-woocommerce-jet-integration') ); ?>">
  <?php _e('Products','nueve-woocommerce-jet-integration');?> </a>

  <a class="jetintgration_menus jet_menus <?php if($jet_tab == 'jet-products' || $jet_tab == 'jet-product-view') 
    { _e('active','nueve-woocommerce-jet-integration'); } ?>" 
    href="<?php esc_url( _e($jet_products_link,'nueve-woocommerce-jet-integration') ); ?>"><?php _e('Jet Products','nueve-woocommerce-jet-integration');?> </a>

  <a class="jetintgration_menus jet_menus <?php if($jet_tab == 'jet-orders' || $jet_tab == 'jet-order-view' || $jet_tab == 'jet-ship-order')
    { _e('active','nueve-woocommerce-jet-integration'); } ?>" 
    href="<?php esc_url( _e($jet_orders_link,'nueve-woocommerce-jet-integration') ); ?>"><?php _e('Jet Orders','nueve-woocommerce-jet-integration');?> </a>

  <a class="jetintgration_menus jet_menus <?php if($jet_tab == 'jet-returns' || $jet_tab == 'jet-return-view' || $jet_tab == 'jet-complete-return') 
    { _e('active','nueve-woocommerce-jet-integration'); } ?>" 
    href="<?php esc_url( _e($jet_returns_link,'nueve-woocommerce-jet-integration') ); ?>">
    <?php _e('Jet Returns','nueve-woocommerce-jet-integration');?> </a>

  <a class="jetintgration_menus jet_menus <?php if($jet_tab == 'jet-refunds' || $jet_tab == 'jet-refund-view' )
    { _e('active','nueve-woocommerce-jet-integration'); } ?>" 
    href="<?php esc_url( _e($jet_refunds_link,'nueve-woocommerce-jet-integration') ); ?>"><?php _e('Jet Refunds','nueve-woocommerce-jet-integration'); ?> </a>   

</div>