<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';
$jet_woo_plugin_url = jet_wordpress_plugin_url;

$jet_get_return_details_nonce_check = wp_create_nonce('jet_get_return_details_nonce_check');
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

#return_div, #jetloading, #no-rep, #no-result, #return_view_header {
	display:none;
}
 
#jetloading {
	margin-left: 30px;
}

#return_main_header {
	margin: 10px 0px;
}

#return_main_header div {
	display:inline;
}

#return_view_header {
	text-align:left;
    text-transform: capitalize;
    font-size: 24px;
    font-weight: 700;
}


#return_div {
	background: #fff;
	padding:20px;
	border: 1px solid #ddd;
	margin-right:10px;
}

.return_data {
	font-size: 16px;
    padding: 0px 0px 20px;
    color: #23282d;
}

.return_label {
	font-weight:600;
	margin-right:10px;
	float:left;
	width:40%;
	text-transform:uppercase;
}

#return_items_list_tbl {
	width:100%;
	font-size:15px;
	margin-bottom: 20px;;
}

#return_items_list_tbl>thead>tr>th, #return_items_list_tbl>tbody>tr>td, #return_items_list_tbl>tfoot>tr>td {
	border: 1px solid #ddd;
	vertical-align:top;
}

#return_items_list_tbl>thead>tr>th {
	text-align:left;
}

.returns_rows {
    margin-bottom: 10px;
}

.tbl_td {
	text-align:center;
}

#return_charge_feedback_div, #completed_date_div {
    display:none;
}


#return_status{
    text-transform:capitalize;
}


#refund_header, #return_header {
    font-weight: 700;
    font-size: 18px;
    text-transform: uppercase;
}

#refund_items_list_tbl, #return_items_list_tbl{
    width:100%;
    font-size:15px;
    margin-bottom: 20px;;
}


#refund_items_list_tbl>thead>tr>th, #refund_items_list_tbl>tbody>tr>td, #refund_items_list_tbl>tfoot>tr>td,
#return_items_list_tbl>thead>tr>th, #return_items_list_tbl>tbody>tr>td, #return_items_list_tbl>tfoot>tr>td {	
	padding:10px;
    border: 1px solid #ddd;
    vertical-align:top;
}

#refund_items_list_tbl>thead>tr>th, #return_items_list_tbl>thead>tr>th {
    text-align:left;
}

#refund_items_list {
    margin-top:10px;
}

.returns_rows,.refunds_rows {
  margin-bottom: 10px;
}

#complete_return_btn {
    margin: 0px 20px;
    font-size: 15px;
    font-weight: 500;
    border-radius: 0px !important;
    color: #fff !important;
    padding: 12px 15px;
    cursor: pointer;
    border: 1px solid #8c2eff;
    background: #8c2eff;
    -webkit-box-shadow: 0 1px 0 #ccc;
    box-shadow: 0 1px 0 #ccc;
}
</style>

<?php 
	if(!isset($_REQUEST['return_id']) || empty($_REQUEST['return_id']) ){
	?>
		<div id="no-result" style="display:block;"><?php _e('Return ID is Required','nueve-woocommerce-jet-integration');?></div>
	<?php
	exit;
	} else if(isset($_REQUEST['return_id']) && !empty($_REQUEST['return_id']) ){
		$return_id = $_REQUEST['return_id'];
	?>

		<input type="hidden" value="<?php _e($jet_woo_plugin_url,'nueve-woocommerce-jet-integration'); ?>"  id="jet_woo_plugin_url">

		<input type="hidden" value="<?php _e($return_id,'nueve-woocommerce-jet-integration'); ?>"  id="return_id">

		<input type="hidden" name="jet_get_return_details_secure_key"
		 value="<?php _e($jet_get_return_details_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_get_return_details_secure_key">
					
		<div id="return_main_header">
			<div id="return_view_header" style="display:none;"><?php _e('View Return Details','nueve-woocommerce-jet-integration');?></div> 
			<div id="load_img_div">
				<img height="50px" width="50px" id="jetloading"  src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">
			</div>
		</div>

		
		<div id="return_details">

			<div id="no-rep"><?php _e('No Return Details Found','nueve-woocommerce-jet-integration');?></div>			

			<div id="return_div">
		    	
		    	<div class="return_data" id="return_btns" style="float:right;"></div>

		    	<div class = "clearfix"></div>
				
				<div class="return_data">
		            <span class="return_label"><?php _e('Merchant Return Authorization ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="merchant_return_authorization_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Reference Return Authorization ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="reference_return_authorization_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Return Status:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="return_status"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Return Date:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="return_date"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Refund without return:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="refund_without_return"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Merchant Order ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="merchant_order_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Reference Order ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="reference_order_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Shipping Carrier:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="shipping_carrier"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Tracking Number:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="tracking_number"></span>
		            <div class = "clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Merchant return charge:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="merchant_return_charge"></span>
		            <div class = "clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data">
		            <span class="return_label"><?php _e('Agree to return charge:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="return_charge"></span>
		            <div class = "clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>
		      
		        <div class="return_data" id="return_charge_feedback_div">
		            <span class="return_label"><?php _e('Return Charge Feedback:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="return_charge_feedback"></span>
		            <div class = "clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="return_data" id="completed_date_div">
		            <span class="return_label"><?php _e('Completed Date:','nueve-woocommerce-jet-integration');?></span>
		            <span class="return_text" id="completed_date"></span>
		            <div class = "clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div id="returns_info">
		            <div class="return_data">
		                <br/> <span id="return_header"> </span>
		            </div>

		            <div class = "clearfix"></div>

		            <div id="return_items_list"></div>
		            
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


