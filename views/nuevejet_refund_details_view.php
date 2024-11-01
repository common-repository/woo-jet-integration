<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';
$jet_woo_plugin_url = jet_wordpress_plugin_url;

$jet_get_refund_details_nonce_check = wp_create_nonce('jet_get_refund_details_nonce_check');
?>


<style type="text/css">

#no-rep, #no-result {
	font-size: 26px;
    font-weight: 700;
    text-transform: uppercase;
    text-align: center;
    padding:0px;
    margin-top:20px;
}

#refund_div, #jetloading, #no-rep, #no-result,#refund_view_header {
	display:none;
}

#jetloading {
	margin-left: 30px;
}


#refund_main_header {
	margin: 10px 0px;
}

#refund_main_header div {
	display:inline;
}

#refund_view_header {
	text-align:left;
    text-transform: capitalize;
    font-size: 24px;
    font-weight: 700;
}

#refund_status {
	text-transform:capitalize;
}

#refund_div {
	background: #fff;
	padding:20px;
	border: 1px solid #ddd;
	margin-right:10px;
}

.refund_data {
	font-size: 16px;
    padding: 0px 0px 20px;
    color: #23282d;
}

.refund_label {
	font-weight:600;
	margin-right:10px;
	float:left;
	width:40%;
	text-transform:uppercase;
}


#refund_header {
    font-weight: 700;
    font-size: 18px;
    text-transform: uppercase;
}

#refund_items_list_tbl {
	width:100%;
	font-size:15px;
	margin-bottom: 20px;;
}

#refund_items_list_tbl>thead>tr>th, #refund_items_list_tbl>tbody>tr>td, #refund_items_list_tbl>tfoot>tr>td {
	padding:10px;
	border: 1px solid #ddd;
	vertical-align:top;
}

#refund_items_list_tbl>thead>tr>th {
	text-align:left;
}


.refunds_rows {
  margin-bottom: 10px;
}

.tbl_td {
	text-align:center;
}
</style>

<?php 
	if(!isset($_REQUEST['refund_id']) || empty($_REQUEST['refund_id']) ){
	?>
		<div id="no-result" style="display:block;"><?php _e('Refund ID is Required','nueve-woocommerce-jet-integration');?></div>
	<?php
	exit;
	} else if(isset($_REQUEST['refund_id']) && !empty($_REQUEST['refund_id']) ){
		$refund_id = $_REQUEST['refund_id'];
	?>

		<input type="hidden" value="<?php _e($jet_woo_plugin_url,'nueve-woocommerce-jet-integration'); ?>"  id="jet_woo_plugin_url">

		<input type="hidden" value="<?php _e($refund_id,'nueve-woocommerce-jet-integration'); ?>"  id="refund_id">

		<input type="hidden" name="jet_get_refund_details_secure_key"
		 value="<?php _e($jet_get_refund_details_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_get_refund_details_secure_key">
					
		<div id="refund_main_header">
			<div id="refund_view_header"  style="display:none;"><?php _e('View Refund Details','nueve-woocommerce-jet-integration');?></div> 
			<div id="load_img_div">
				<img height="50px" width="50px" id="jetloading"  src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">
			</div>
		</div>

		<div id="refund_details">

			<div id="no-rep"><?php _e('No Refund Details Found','nueve-woocommerce-jet-integration');?></div>
			

			<div id="refund_div">
				
				<div class="refund_data">
		            <span class="refund_label"><?php _e('Refund Authorization ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="refund_text" id="refund_authorization_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="refund_data">
		            <span class="refund_label"><?php _e('Reference Order ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="refund_text" id="reference_order_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="refund_data">
		            <span class="refund_label"><?php _e('Refund ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="refund_text" id="merchant_refund_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="refund_data">
		            <span class="refund_label"><?php _e('Merchant Order ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="refund_text" id="merchant_order_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="refund_data">
		            <span class="refund_label"><?php _e('Refund Status:','nueve-woocommerce-jet-integration');?></span>
		            <span class="refund_text" id="refund_status"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div id="refunds_info">
		            <div class="refund_data">
		                <br/> <span id="refund_header"> </span>
		            </div>

		            <div class = "clearfix"></div>

		            <div id="refund_items_list"></div>
		            
		        </div>

		        <div class = "clearfix"></div>

			</div>			
		</div>
	<?php
	}
?>


