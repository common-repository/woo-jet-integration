<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';
$jet_woo_plugin_url = jet_wordpress_plugin_url;

$jet_get_order_details_nonce_check = wp_create_nonce('jet_get_order_details_nonce_check');
$jet_order_cancel_nonce_check = wp_create_nonce('jet_order_cancel_nonce_check');
$jet_acknowledge_order_nonce_check = wp_create_nonce('jet_acknowledge_order_nonce_check');
$jet_request_refund_nonce_check = wp_create_nonce('jet_request_refund_nonce_check');
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

#order_div, #jetloading, #btn_loader_image, #no-rep, #no-result, #order_view_header {
	display:none;
}

#jetloading {
	margin-left: 30px;
}

#btn_loader_image {
    margin: 10px 0px 20px 30px;
}

#order_header {
	margin: 10px 0px;
}

#order_header div {
	display:inline;
}

#order_view_header {
	text-align:left;
    text-transform: capitalize;
    font-size: 24px;
    font-weight: 700;
}


#order_div {
	background: #fff;
	padding:20px;
	border: 1px solid #ddd;
	margin-right:10px;
}

.order_data {
	font-size: 16px;
    padding: 0px 0px 20px;
    color: #23282d;
}

.order_label {
	font-weight:600;
	margin-right:10px;
	float:left;
	width:25%;
	text-transform:uppercase;
}


#customer_info, #shipped_info, #orders_info, #shipments_info, #refund_div, #request_refund_div {
    padding-top: 20px;
    margin-top: 10px;
    border-top: 1px dotted grey;
}

#customer_header, #shipped_header, #orders_header, #shipments_header, #refund_header {
    font-weight: 700;
    font-size: 20px;
    text-transform: uppercase;
}

#exception_state {
	color:red;
	font-size:13px;
}

#ic_div {
	line-height: 2;
	margin-left: 26%;
}

#order_status {
	text-transform:capitalize;
}

#order_print,#package_slip_no_shipping,#package_slip {
    font-size: 15px;
    font-weight: 500;
    border-radius: 5px !important;
    color: #fff!important;
    padding: 6px 10px;
    cursor: pointer;
    -webkit-box-shadow: 0 1px 0 #ccc;
    box-shadow: 0 1px 0 #ccc;
    text-decoration:none;
}

#order_print, #package_slip_no_shipping{
	background: #265a88;
    border: 1px solid #265a88;
}

#package_slip{
	background: #398439;
    border: 1px solid #398439;
}  

#printing_process {
	margin-left:70%;
}

.print_header {
	font-size:15px;	
}

#order_items_list_tbl, #refund_order_items_list {
	width:100%;
	font-size:15px;
	margin-bottom: 20px;
}

#order_items_list_tbl>thead>tr>th, #refund_order_items_list_tbl>thead>tr>th {
	text-transform:uppercase;
	text-align: left;
}

.refunds_rows {
  margin-bottom: 10px;
}

.total_quantity_returned, .order_return_refund_qty, .refund_amount_inputs {	
    width: 60px;
    border: 1px solid #666!important;
}

.refund_amount_inputs {
 	margin-top: 10px;
}


.refund_reason, .refund_feedback {
    border: 1px solid #666!important;
    width: 100%;
    height: 35px !important;
    font-size: 16px;
}

.notes {
	border: 1px solid #666!important;
	margin-top:20px;
}


#order_items_list_tbl>thead>tr>th, #order_items_list_tbl>tbody>tr>td,
 #order_items_list_tbl>tfoot>tr>td, #refund_order_items_list_tbl>thead>tr>th, 
 #refund_order_items_list_tbl>tbody>tr>td,  #refund_order_items_list_tbl>tfoot>tr>td  {
 	padding:10px;
	border: 1px solid #ddd;
	vertical-align:top;
}

#total_order_payable {
	text-align:right;
	font-size:15px;
}
.order_rows {
 margin-bottom: 10px;
}

.tbl_td {
	text-align:center;
}

#accept_order_btn, #ship_order_btn, #cancel_order_btn {
	margin: 0px 20px;
    font-size: 15px;
    font-weight: 500;
    border-radius: 0px !important;
    color: #fff !important;
    padding: 6px 10px;
    cursor: pointer;
    -webkit-box-shadow: 0 1px 0 #ccc;
    box-shadow: 0 1px 0 #ccc;
}

#accept_order_btn, #ship_order_btn {    
    background: #8c2eff;
    border: 1px solid #8c2eff;
}

#cancel_order_btn {    
    background: #ea2020;
    border: 1px solid #ea2020;
}


#reject_order_btn {
	height: 35px;
    border: 1px solid #333;
    color: #000;
    font-weight: 500;
    font-size: 15px;
    padding: 0px 5px;
    cursor: pointer;
}

#refund_btn1, #refund_btn2 {
    font-size: 18px;
    font-weight: 500;
    border-radius: 0px !important;
    color: #fff !important;
    padding: 8px 10px;
    cursor: pointer;
    -webkit-box-shadow: 0 1px 0 #ccc;
    box-shadow: 0 1px 0 #ccc;
    background: #8c2eff;
    border: 1px solid #8c2eff;
}


#refund_btn2 {
    margin-right:25px;
    margin-bottom:10px;
    float:right;
}


#refund_notes1 {
    color: #444;
    font-size: 1.2em;
    line-height: 1.5em;
    font-weight:600;
}

#refund_notes2 {
    font-weight: 400;
    letter-spacing: 0.6px;
    line-height: 25px;
}

#refund_notes3 {
    color: #444;
    font-size: 1em;
    line-height: 1em;
    font-weight:600;
}

#refund_notes4 {
    font-weight:400;
}


#refund_notes4 ul li{
    list-style-type: circle;
    margin-left: 30px;
    margin-bottom: 10px;
}

#form-error-text {
    color: #ff0000;
    font-size: 15px;
    margin:10px;
    width:98%;
    display:none;
}

</style>

<?php 
	if(!isset($_REQUEST['order_id']) || empty($_REQUEST['order_id']) ){
	?>
		<div id="no-result" style="display:block;"><?php _e('Order ID is Required','nueve-woocommerce-jet-integration');?></div>
	<?php
	exit;
	} else if(isset($_REQUEST['order_id']) && !empty($_REQUEST['order_id']) ){
		$order_id = $_REQUEST['order_id'];
	?>

		<input type="hidden" value="<?php _e($jet_woo_plugin_url,'nueve-woocommerce-jet-integration'); ?>"  id="jet_woo_plugin_url">

		<input type="hidden" value="<?php _e($order_id,'nueve-woocommerce-jet-integration'); ?>"  id="order_id">

		<input type="hidden" name="jet_get_order_details_secure_key"
		 value="<?php _e($jet_get_order_details_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_get_order_details_secure_key">

		<input type="hidden" name="jet_acknowledge_order_secure_key"
		 value="<?php _e($jet_acknowledge_order_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_acknowledge_order_secure_key">

		<input type="hidden" name="jet_order_cancel_secure_key"
		 value="<?php _e($jet_order_cancel_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_order_cancel_secure_key">

		<input type="hidden" name="jet_request_refund_secure_key"
		 value="<?php _e($jet_request_refund_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_request_refund_secure_key">
	  
	  	<div id="order_header">
			<div id="order_view_header" style="display:none;"><?php _e('View Order Details','nueve-woocommerce-jet-integration');?></div> 
			<div id="load_img_div">
				<img height="50px" width="50px" id="jetloading"  src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">
			</div>
		</div>
					
		<div id="order_details">

			<div id="no-rep"><?php _e('No Order Details Found','nueve-woocommerce-jet-integration');?></div>
			
			<div id="order_div">

				<div id="form-error-text"></div>

		    	<img height="30px" width="30px" id="btn_loader_image" class="order_image_loader" src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?>">

		    	<div class="order_data" id="order_btns" style="float:right;"></div>

		    	<div class = "clearfix"></div>
				
				<div class="order_data">
		            <span class="order_label"><?php _e('Order ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="order_text" id="merchant_order_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="order_data">
		            <span class="order_label"><?php _e('Reference Order ID:','nueve-woocommerce-jet-integration');?></span>
		            <span class="order_text" id="reference_order_id"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="order_data">
		            <span class="order_label"><?php _e('Order Placed Date:','nueve-woocommerce-jet-integration');?></span>
		            <span class="order_text" id="order_placed_date"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="order_data" id="order_complete_date_div">
		            <span class="order_label"><?php _e('Order Complete Date:','nueve-woocommerce-jet-integration');?></span>
		            <span class="order_text" id="order_complete_date"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="order_data">
		            <span class="order_label"><?php _e('Status:','nueve-woocommerce-jet-integration');?></span>
		            <span class="order_text" id="order_status"></span>
            		<span class="order_text" id="exception_state"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="order_data">
		            <span class="order_label"><?php _e('Order Totals:','nueve-woocommerce-jet-integration');?></span>
		             <span class="order_text">

		                <span id="bp_div">
		                	<b><?php _e('Items Base Price:','nueve-woocommerce-jet-integration');?> </b>$<span id="total_base_price"></span> 
		                </span>
		               	<br/> 
		               	<span id="ic_div">
		               		<b><?php _e('Shipping Cost:','nueve-woocommerce-jet-integration');?> </b>$<span id="total_item_shipping_cost"></span>
		               	</span>

		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="order_data">
		            <span class="order_label"><?php _e('Order Fees:','nueve-woocommerce-jet-integration');?></span>
		            <span class="order_text" id="order_fees"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		       	<div class="order_data">
		            <span class="order_label"><?php _e('Total Payable:','nueve-woocommerce-jet-integration');?></span>
		            <span class="order_text" id="total_payable"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div id="customer_info">

			        <div class="order_data">
			            <span id="customer_header"><?php _e('Customer Information:','nueve-woocommerce-jet-integration');?></span>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Name:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="customer_name"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Phone:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="customer_phone"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Email:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="customer_email"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			    </div>

			    <div class = "clearfix"></div>

			    <div id="shipped_info">

			        <div class="order_data">
			            <span id="shipped_header"><?php _e('Ship To:','nueve-woocommerce-jet-integration');?></span>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Recipient:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="recipient_name"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Address:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="recipient_address"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('City:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="recipient_city"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('State:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="recipient_state"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Zip Code:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="recipient_zipcode"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Carrier:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="shipping_carrier"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Service Level:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="service_level"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Ship By:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="ship_by_date"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div class="order_data">
			            <span class="order_label"><?php _e('Delivery By:','nueve-woocommerce-jet-integration');?></span>
			            <span class="order_text" id="delivery_date"></span>
			            <div class="clearfix"></div>
			        </div>

			        <div class="clearfix"></div>

			        <div id="printing_process" style="display:none;">

			            <div class="print_header"><?php _e('Do NOT send those to a buyer:','nueve-woocommerce-jet-integration');?></div>

			            <div>
			                <br/><a href="#" target="_blank" class="o_print btn btn-primary" id="order_print"><?php _e('Print Order','nueve-woocommerce-jet-integration');?></a>
			            </div>  

			            <div>
			                <br/><a href="#" target="_blank" class="o_print btn btn-primary" id="package_slip_no_shipping"><?php _e('Print Package Slip without Shipping details','nueve-woocommerce-jet-integration');?></a>
			            </div>
		    			<br/>
		    			<div id="order_complete_print" style="display:none;">
			                <div class="print_header"><?php _e('Send this to a buyer','nueve-woocommerce-jet-integration');?></div>
			                <div>                 
			                <br/><a href="#" target="_blank" class="o_print btn btn-warning" id="package_slip"><?php _e('Print Package Slip with Tracking #','nueve-woocommerce-jet-integration');?></a>
			                </div>
			            </div>
			            <br/>
			        </div>

			    </div>

			    <div class = "clearfix"></div>

			    <div id="orders_info">
			    	<div class="order_data">
		                <span id="orders_header"> </span>
		            </div>

		            <div class = "clearfix"></div>

		            <div id="order_items_list"></div>
		            
			    </div>

			    <div class = "clearfix"></div>

			    <div id="shipments_info">

				    <div class="order_data">
				        <span id="shipments_header"><?php _e('Shipments:','nueve-woocommerce-jet-integration');?></span>
				    </div>

				    <div class = "clearfix"></div>

				    <div class="order_data">
				        <span class="order_label"><?php _e('Carrier:','nueve-woocommerce-jet-integration');?></span>
				        <span class="order_text" id="shipments_carrier"></span>
				        <div class = "clearfix"></div>
				    </div>

				    <div class = "clearfix"></div>

				    <div class="order_data">
				        <span class="order_label"><?php _e('Shipment method:','nueve-woocommerce-jet-integration');?></span>
				        <span class="order_text" id="shipments_shipping_method"></span>
				        <div class = "clearfix"></div>
				    </div>

				    <div class = "clearfix"></div>

				    <div class="order_data">
				        <span class="order_label"><?php _e('Tracking number:','nueve-woocommerce-jet-integration');?></span>
				        <span class="order_text" id="shipment_tracking_number"></span>
				        <div class = "clearfix"></div>
				    </div>

				    <div class = "clearfix"></div>

				    <div class="order_data">
				        <span class="order_label"><?php _e('Shipment date:','nueve-woocommerce-jet-integration');?></span>
				        <span class="order_text" id="response_shipment_date"></span>
				        <div class = "clearfix"></div>
				    </div>

				    <div class = "clearfix"></div>

				    <div class="order_data">
				        <span class="order_label"><?php _e('Carrier pick up date:','nueve-woocommerce-jet-integration');?></span>
				        <span class="order_text" id="carrier_pick_up_date"></span>
				        <div class = "clearfix"></div>
				    </div>

				    <div class = "clearfix"></div>

				    <div class="order_data">
				        <span class="order_label"><?php _e('Expected delivery date:','nueve-woocommerce-jet-integration');?></span>
				        <span class="order_text" id="expected_delivery_date"></span>
				        <div class = "clearfix"></div>
				    </div>

				    <div class = "clearfix"></div>

				</div>

				<div class = "clearfix"></div>

				<div class="order_data" id="refund_div" style="display:none;">
		        
			        <button id="refund_btn1">Request Refund</button>

			        <br/><br/>	        

			        <div id="refund_instructions">
			            <span id="refund_notes1"><?php _e('Please Read Before Refunding:','nueve-woocommerce-jet-integration');?></span>
			            <br/><br/>
			            <span id="refund_notes2"><?php _e("Refunds should be placed in the event that a customer returns an item directly to the retailer (who supplied it directly), rather than through JET. In this case, the merchant can generate a refund off of the order after they've received, processed, and evaluated the state of the return. Generating a refund off of an order will alert Jet to refund the customer the amount specified in the refund message.",'nueve-woocommerce-jet-integration');?></span>
			            <br/><br/>
			            <span id="refund_notes3"><?php _e('There are many reasons for refunds to be used including:','nueve-woocommerce-jet-integration');?></span>
			            <br/>
			            <span id="refund_notes4">
			                <ul>
			                    <li><?php _e("The order was rejected at the post office or member's address.",'nueve-woocommerce-jet-integration');?></li>
			                    <li><?php _e('The member sent the product back to the merchant directly without first contacting Jet.','nueve-woocommerce-jet-integration');?></li>
			                    <li><?php _e('The merchant wants to refund the member due to receiving a damaged product before a return is created.','nueve-woocommerce-jet-integration');?></li>
			                </ul>
			            </span>
			        </div>

			        <div class = "clearfix"></div>

			    </div>

			    <div class = "clearfix"></div>

			    <div id="request_refund_div" style="display:none;">

			    	<div id="refund_header"></div>

			    	<div class = "clearfix"></div>

		            <button id="refund_btn2"><?php _e('Request Refund','nueve-woocommerce-jet-integration');?></button>

		            <div class = "clearfix"></div>

		            <div id="refund_order_items_list"> </div>

			    </div>

			</div>			
		</div>

		<input type="hidden" id="refund_status">

		<div id="print_order_div" style="display:none;">
			<?php _e('printing','nueve-woocommerce-jet-integration');?>
		</div>

		<div id="package_slip_div" style="display:none;">
			
			<div id="package_slip_with_shipping">

				<div id="package_slip_without_shipping">
					<div class="print_slip_invoice_title" style="text-align:center;">
				        <h2><?php _e('JET.com','nueve-woocommerce-jet-integration');?></h2>
				    </div>

				    <hr/>

				    <div style="text-align:center;">
				        <h2><?php _e('Order #','nueve-woocommerce-jet-integration');?> <span id="print_slip_reference_order_id"></span></h2>
				        <p><?php _e('Order Date:','nueve-woocommerce-jet-integration');?> <span id="print_slip_reference_order_id"><span id="print_slip_order_place_date"></span></p>                        
				    </div>
				</div>

			    <div id="package_slip_shipping_div"><?php _e('shipping','nueve-woocommerce-jet-integration');?></div>

			</div>
		</div>

	<a class="no-print" href="javascript:printDiv('orders_div');" style="display:none;"><?php _e('Print','nueve-woocommerce-jet-integration');?></a>

	<textarea id="printing-css" style="display:none;"></textarea>

	<textarea id="printing-css2" style="display:none;">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}body{font:normal normal .8125em/1.4 Arial,Sans-Serif;background-color:white;color:#333}strong,b{font-weight:bold}cite,em,i{font-style:italic}a{text-decoration:none}a:hover{text-decoration:underline}a img{border:none}abbr,acronym{border-bottom:1px dotted;cursor:help}sup,sub{vertical-align:baseline;position:relative;top:-.4em;font-size:86%}sub{top:.4em}small{font-size:86%}kbd{font-size:80%;border:1px solid #999;padding:2px 5px;border-bottom-width:2px;border-radius:3px}mark{background-color:#ffce00;color:black}p,blockquote,pre,table,figure,hr,form,ol,ul,dl{margin:1.5em 0}hr{height:1px;border:none;background-color:#666}h1,h2,h3,h4,h5,h6{font-weight:bold;line-height:normal;margin:1.5em 0 0}h1{font-size:200%}h2{font-size:180%}h3{font-size:160%}h4{font-size:140%}h5{font-size:120%}h6{font-size:100%}ol,ul,dl{margin-left:3em}ol{list-style:decimal outside}ul{list-style:disc outside}li{margin:.5em 0}dt{font-weight:bold}dd{margin:0 0 .5em 2em}input,button,select,textarea{font:inherit;font-size:100%;line-height:normal;vertical-align:baseline}textarea{display:block;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}pre,code{font-family:"Courier New",Courier,Monospace;color:inherit}pre{white-space:pre;word-wrap:normal;overflow:auto}blockquote{margin-left:2em;margin-right:2em;border-left:4px solid #ccc;padding-left:1em;font-style:italic}table[border="1"] th,table[border="1"] td,table[border="1"] caption{border:1px solid;padding:.5em 1em;text-align:left;vertical-align:top}th{font-weight:bold}table[border="1"] caption{border:none;font-style:italic}.no-print{display:none}</textarea>

	<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
    

	<?php
	}
?>


