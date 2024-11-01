<?php 
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';
$jet_woo_plugin_url = jet_wordpress_plugin_url;

$jet_get_woo_products_nonce_check = wp_create_nonce('jet_get_woo_products_nonce_check');
$jet_upload_products_nonce_check = wp_create_nonce('jet_upload_products_nonce_check');
$jet_product_status_nonce_check = wp_create_nonce('jet_product_status_nonce_check');
?>

<style type="text/css">
.upload_btns, #jetloading, #no-rep, #woo_products_list {
	display:none;
}

#cb {
	padding-left:10px;
}

#no-rep {
	font-size: 26px;
    font-weight: 700;
    text-transform: uppercase;
    text-align: center;
    padding:0px;
}

.alert{
	display:none;
	width: 98%;
    color: #000 !important;
    background-color: #eae4e4 !important;
}

</style>

<br/> 

<div id="upload_btns_div">
	<button type="submit" id="upload_products" btn_type="upload" class="btn btn-primary upload_btns"><?php _e('Upload Products','nueve-woocommerce-jet-integration');?></button>

	<button type="submit" id="archive_products" btn_type="archive" class="btn btn-primary upload_btns"><?php _e('Archive Products','nueve-woocommerce-jet-integration');?></button>

	<button type="submit" id="unarchive_products"  btn_type="unarchive" class="btn btn-primary upload_btns"><?php _e('Unarchive Products','nueve-woocommerce-jet-integration');?></button>

	<button type="submit" id="update_product_status" btn_type="update_product_status" class="btn btn-primary upload_btns"><?php _e('Update Product Status','nueve-woocommerce-jet-integration');?></button>

	<div style="display:none;">
		<button type="submit" id="import_products" btn_type="import_products" class="btn btn-primary upload_btns"><?php _e('Import Products','nueve-woocommerce-jet-integration');?></button>
		<button type="submit" id="import_inventories" btn_type="import_inventories" class="btn btn-primary upload_btns"><?php _e('Import Inventories','nueve-woocommerce-jet-integration');?></button>
	</div>

	<img height="50px" width="50px" id="jetloading"  src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">
</div>

<br/> 



<input type="hidden" value="<?php _e($jet_woo_plugin_url,'nueve-woocommerce-jet-integration'); ?>"
  id="jet_woo_plugin_url">

<input type="hidden" name="jet_get_woo_products_secure_key"
 value="<?php _e($jet_get_woo_products_nonce_check,'nueve-woocommerce-jet-integration'); ?>" id="jet_get_woo_products_secure_key">

<input type="hidden" name="jet_upload_products_secure_key" 
value="<?php _e($jet_upload_products_nonce_check,'nueve-woocommerce-jet-integration'); ?>" id="jet_upload_products_secure_key">

<input type="hidden" name="jet_product_status_secure_key"
 value="<?php _e($jet_product_status_nonce_check,'nueve-woocommerce-jet-integration'); ?>" id="jet_product_status_secure_key">
 

<div class="alert">
	<a href="#" class="close">&times;</a>
	<span class="alert-text"></span>
</div>


<div id="no-rep"><?php _e('No Products Available','nueve-woocommerce-jet-integration');?></div>

<div id="woo_products_list">

	<table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="manage-column column-cb check-column no-sort" id="cb" scope="col">
					<input type="checkbox" id="woo-products-select-all">
				</th>
				<th class="manage-column column-name sortable no-sort" id="product_id" scope="col"><?php _e('ID','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-name sortable" id="product_image" scope="col"><?php _e('Image','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-name sortable" id="merchant_sku" scope="col"><?php _e('Merchant SKU','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-name sortable" id="parent_sku" scope="col"><?php _e('Parent SKU','nueve-woocommerce-jet-integration');?></th>				
				<th class="manage-column column-name sortable" id="product_title" scope="col"><?php _e('Product Title','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-sku sortable" id="product_price" scope="col"><?php _e('Price','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-price sortable" id="product_qty" scope="col"><?php _e('Inventory','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-qty sortable" id="product_cat" scope="col"><?php _e('Category','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-qty sortable" id="jet_product_status" scope="col"><?php _e('Jet Product Status','nueve-woocommerce-jet-integration');?></th>	
				<th class="manage-column column-qty sortable no-sort" id="action" scope="col"><?php _e('Action','nueve-woocommerce-jet-integration');?></th>				
			</tr>
		</thead>

		<tbody></tbody>

	</table>

</div>

