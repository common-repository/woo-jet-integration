<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';
$jet_woo_plugin_url = jet_wordpress_plugin_url;

$jet_get_products_list_nonce_check = wp_create_nonce('jet_get_products_list_nonce_check');
$jet_oupload_products_nonce_check = wp_create_nonce('jet_oupload_products_nonce_check');
$jet_pdt_price_update_nonce_check = wp_create_nonce('jet_pdt_price_update_nonce_check');
$jet_pdt_inventory_update_nonce_check = wp_create_nonce('jet_pdt_inventory_update_nonce_check');


$product_type = 'active';
$cur_page = 1;
$page_limit = 50;
?>

<style type="text/css">
#no-rep {
	font-size: 26px;
    font-weight: 700;
    text-transform: uppercase;
    text-align: center;
    padding:0px;
}

#products_list {
	padding-right:10px;
}

.product_image {
    max-width: 60px;
    max-height: 100px;
    vertical-align: middle;
}

.upload_btns, #jetloading, #no-rep, #products_list, #paginate_div {
	display:none;
}

ul.pagination {
	float: right;
    margin-right: 50px;
}

ul.pagination li {
    position: relative;
    box-sizing: border-box;
    display: inline-block;
    min-width: 1.5em;
    padding: 0.5em 1em;
    margin-left: 2px;
    text-align: center;
    text-decoration: none !important;
    cursor: pointer;
    border: 1px solid transparent;
    border-radius: 2px;
    color: #333;
    background:none;
}

.pagination li:hover {
	color: #fff !important;
    border: 1px solid #979797;
    background-color: #333;
}

.pagination li.active {
	color: #333 !important;
    border: 1px solid #979797;
    background-color: #fff;
    background: linear-gradient(to bottom, #fff 0%, #dcdcdc 100%);
}


.paginate_button.disabled, .paginate_button.disabled:hover, .paginate_button.disabled:active {
    cursor: default;
    color: #666 !important;
    border: 1px solid transparent;
    background: transparent;
    box-shadow: none;
}

.alert{
	display:none;
	width: 98%;
    color: #000 !important;
    background-color: #eae4e4 !important;
}

.pdt_msg_status
{
    font-size: 12px;
    padding: 5px;
    color: #0b810b;
    font-weight: bold;
    display:none;
}

.price_update, .inventory_update
{
    width: auto;
    margin-left:3px;
    margin-top:10px;
    border-color: #8c2eff !important;
    background-color: #8c2eff !important;
    box-shadow:none !important;
}

</style>

<br/> 

<div id="upload_btns_div">

	<button type="submit" id="archive_products" btn_type="archive" class="btn btn-primary upload_btns upld_btns"><?php _e('Archive Products','nueve-woocommerce-jet-integration');?></button>

	<button type="submit" id="unarchive_products"  btn_type="unarchive" class="btn btn-primary upload_btns upld_btns"><?php _e('Unarchive Products','nueve-woocommerce-jet-integration');?></button>

	<button type="submit" id="refresh_products_list" class="btn btn-primary upload_btns"><?php _e('Refresh Products List','nueve-woocommerce-jet-integration');?></button>	

	<img height="50px" width="50px" id="jetloading"  src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">

</div>

<br/> 

<input type="hidden" value="<?php _e($jet_woo_plugin_url,'nueve-woocommerce-jet-integration'); ?>"
  id="jet_woo_plugin_url">

<input type="hidden" value="<?php _e($product_type,'nueve-woocommerce-jet-integration'); ?>"
  id="product_type">

<input type="hidden" name="jet_get_products_list_secure_key"
 value="<?php _e($jet_get_products_list_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
  id="jet_get_products_list_secure_key">

<input type="hidden" name="jet_oupload_products_secure_key" 
value="<?php _e($jet_oupload_products_nonce_check,'nueve-woocommerce-jet-integration'); ?>" id="jet_oupload_products_secure_key">

<input type="hidden" name="jet_pdt_price_update_secure_key" 
value="<?php _e($jet_pdt_price_update_nonce_check,'nueve-woocommerce-jet-integration'); ?>" id="jet_pdt_price_update_secure_key">

<input type="hidden" name="jet_pdt_inventory_update_secure_key" 
value="<?php _e($jet_pdt_inventory_update_nonce_check,'nueve-woocommerce-jet-integration'); ?>" id="jet_pdt_inventory_update_secure_key">


<input type="hidden" name="cur_page" value="<?php echo $cur_page;?>"  id="cur_page">
<input type="hidden" name="page_limit" value="<?php echo $page_limit;?>"  id="page_limit">


<div class="alert">
	<a href="#" class="close">&times;</a>
	<span class="alert-text"></span>
</div>

<div id="post_url" style="display:none;"><?php echo admin_url('/post.php?post=');?></div>
<div id="no-rep"><?php _e('No Products Available','nueve-woocommerce-jet-integration');?></div>

<div id="products_list">
	<table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="manage-column column-cb check-column no-sort" id="cb" scope="col">
					<input type="checkbox" id="products-select-all">
				</th>
				<th class="manage-column column-name sortable" id="product_image" scope="col"><?php _e('Image','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-name sortable" id="merchant_sku" scope="col"><?php _e('Merchant SKU','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-name sortable" id="parent_sku" scope="col"><?php _e('Parent SKU','nueve-woocommerce-jet-integration');?></th>				
				<th class="manage-column column-name sortable" id="product_title" scope="col"><?php _e('Product Title','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-sku sortable" id="product_price" scope="col"><?php _e('Price','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-price sortable" id="product_qty" scope="col"><?php _e('Inventory','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-qty sortable" id="jet_product_status" scope="col"><?php _e('Product Status','nueve-woocommerce-jet-integration');?></th>	
				<th class="manage-column column-qty sortable no-sort" id="action" scope="col"><?php _e('Action','nueve-woocommerce-jet-integration');?></th> 
			</tr>
		</thead>
		<tbody id="dataTable_row"> 

		</tbody>
	</table>
</div>

<div id="paginate_div"></div>
