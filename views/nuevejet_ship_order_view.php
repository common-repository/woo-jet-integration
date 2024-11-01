<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';
$jet_woo_plugin_url = jet_wordpress_plugin_url;

$jet_get_order_details_nonce_check = wp_create_nonce('jet_get_order_details_nonce_check');
$jet_ship_order_nonce_check = wp_create_nonce('jet_ship_order_nonce_check');
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

#order_div, #jetloading, #order_view_header, #btn_loader_image, #no-rep, #no-result {
	display:none;
}

#jetloading, #btn_loader_image {
	margin-left: 25px;
}

#btn_loader_image {
    margin-top: 10px;
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


.ship_order_dates, .ship_order_inputs {
	height: 35px !important;
    border: 1px solid #333 !important;
    color: #000 !important;
    font-size: 16px !important;
    padding: 0px 10px !important;
    cursor: pointer;
    width: 40% !important;
}

#ship_order_btn {
	margin: 25px 20px 10px 20px;
    font-size: 20px;
    font-weight: 500;
    border-radius: 0px !important;
    color: #fff !important;
    padding: 6px 15px;
    cursor: pointer;
    -webkit-box-shadow: 0 1px 0 #ccc;
    box-shadow: 0 1px 0 #ccc;
    background: #8c2eff;
    border: 1px solid #8c2eff;
}

.ship_order_border {
	border:1px solid #ef2020 !important;
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
	if(!isset($_REQUEST['order_id']) || empty($_REQUEST['order_id']) ) {
	?>
		<div id="no-result" style="display:block;"><?php _e('Order ID is Required','nueve-woocommerce-jet-integration');?></div>
	<?php
	exit;
	} else if(isset($_REQUEST['order_id']) && !empty($_REQUEST['order_id']) ) {

		$order_id = $_REQUEST['order_id'];

    	$shipping_carriers = array('FedEx','FedEx SmartPost','FedEx Freight','UPS','UPS Freight','UPS Mail Innovations','UPS SurePost','OnTrac','OnTrac Direct Post','DHL','DHL Global Mail','USPS','CEVA','Laser Ship','Spee Dee','A Duie Pyle','A1','ABF','APEX','Averitt','Dynamex','Eastern Connection','Ensenda','Estes','Land Air Express','Lone Star','Meyer','New Penn','Pilot','Prestige','RBF','Reddaway','RL Carriers','Roadrunner','Southeastern Freight','UDS','UES','YRC','GSO','A&M Trucking','SAIA Freight','Old Dominion','Parcel','Bekins / Home Direct','Seko Worldwide','Mail Express','Newgistics','Delivered by Walmart','NonstopDelivery','MPX','Cagney Global','Simmons Carrier','AGS','Watkins & Shepard','Other');    

    	$shipping_methods = array('A1','ABF','ADuiePyle','APEX','Averitt','A&MTrucking','CEVA','DHLEasyReturnPlus','DHLExpress12','DHLExpress9','DHLExpressEnvelope','DHLExpressWorldwide','DHLeCommerce','DHLSmartmailFlatsGround','DHLSmartmailParcelGround','DHLSmartmailParcelPlusGround','DynamexSameDay','EasternConnectionExpeditedMail','EasternConnectionGround','EasternConnectionPriority','EasternConnectionSameDay','EnsendaHome','EnsendaNextDay','EnsendaSameDay','EnsendaTwoMan','Estes','Fedex2Day','FedExExpeditedFreight','FedexExpressSaver','FedexFirstOvernight','FedexFreight','FedExGround','FedExHome','FedexPriorityOvernight','FedexSameDay','FedExSmartPost','FedExSmartPostReturns','FedexStandardOvernight','GSOGround','LandAirExpress','LasershipSameDay','LaserShipNextDay','LaserShipGlobalPriority','Prestige','LSO2ndDay','LSOEarlyNexyDay','LSOEconomyNextDay','LSOGround','LSOPriorityNextDay','LSOSaturday','Meyer','NewPenn','OnTracDirectPost','OnTracGround','OnTracPalletizedFreight','OnTracSaturdayDelivery','OnTracSunrise','OnTracSunriseGold','Other','Pilot','RBF','Reddaway','RLCarriers','RoadRunner','SAIAFreight','SoutheasternFreight','SpeeDee','UDSNextDay','UDSSameDay','UES','UPSSurepost','UPS2ndDayAir','UPS2ndDayAirAM','UPS2ndDayAirFreight','UPS2ndDayAirFreightNGS','UPS3DayFreight','UPS3DayFreightNGS','UPS3DaySelect','UPSExpressCritical','UPSFreight','UPSGround','UPSGroundFreightPricing','UPSHundredweightService','UPSMailInnovations','UPSNextDayAir','UPSNextDayAirEarly','UPSNextDayAirFreight','UPSNextDayAirFreightNGS','UPSNextDayAirSaver','UPSStandard','USPSFirstClassMail','USPSMediaMail','USPSPriorityMail','USPSPriorityMailExpress','USPSRetailGround','YRC','DHLEasyReturnLight','DHLEasyReturnGround','DHLSmartmailFlatsExpedited','DHLSmartmailParcelExpedited','DHLSmartmailParcelPlusExpedited','GSOPriority','GSOFreight');

    	$cur_date = date('d-m-Y H:i').':00';
	?>

		<input type="hidden" value="<?php _e($jet_woo_plugin_url,'nueve-woocommerce-jet-integration'); ?>"  id="jet_woo_plugin_url">

		<input type="hidden" value="<?php _e($order_id,'nueve-woocommerce-jet-integration'); ?>"  id="order_id">

		<input type="hidden" name="jet_get_order_details_secure_key"
		 value="<?php _e($jet_get_order_details_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_get_order_details_secure_key">

		<input type="hidden" name="jet_ship_order_secure_key"
		 value="<?php _e($jet_ship_order_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_ship_order_secure_key">

				
		<div id="order_header">
			<div id="order_view_header" style="display:none;"><?php _e('Jet Ship Order','nueve-woocommerce-jet-integration');?></div> 
			<div id="load_img_div">
				<img height="50px" width="50px" id="jetloading"  src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">
			</div>
		</div>	
		
		<div id="order_details">

			<div id="no-rep"><?php _e('No Order Details Found','nueve-woocommerce-jet-integration');?></div>


			<div id="order_div">

				<div id="form-error-text"></div>
						    	
		    	<div class = "clearfix"></div>

		    	<div class="order_data">
		            <span class="order_label"><?php _e('Order Placed Date:','nueve-woocommerce-jet-integration');?></span>
		            <span class="order_text" id="order_placed_date"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="order_data">
		            <span class="order_label"><?php _e('Order Acknowledged Date:','nueve-woocommerce-jet-integration');?></span>
		            <span class="order_text" id="order_acknowledge_date"></span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="order_data">

		       		<span class="order_label"><?php _e('Carrier:','nueve-woocommerce-jet-integration');?></span>

		       		<select class="ship_order_dates" id="carrier" name="carrier"> 
			            <?php foreach($shipping_carriers as $shipping_carrier) {?>
			                <option value="<?php echo $shipping_carrier;?>" >
			                	<?php echo $shipping_carrier;?></option>
			            <?php } ?>	            
			        </select>

		            <div class="clearfix"></div>

		        </div>

		        <div class="clearfix"></div>

		        <div class="order_data">

		       		<span class="order_label"><?php _e('Shipment Method:','nueve-woocommerce-jet-integration');?></span>

		       		<select class="ship_order_dates" id="response_shipment_method" name="response_shipment_method">  
			            <?php foreach($shipping_methods as $shipping_method) {?>
			                <option value="<?php echo $shipping_method;?>">
			                	<?php echo $shipping_method;?></option>
			            <?php } ?>            
			        </select>

		            <div class="clearfix"></div>

		        </div>

		        <div class = "clearfix"></div>

		        <div class="order_data">

		       		<span class="order_label"><?php _e('Shipment date:','nueve-woocommerce-jet-integration');?></span>

		       		<input type="datetime-local" class="ship_order_inputs"  id="response_shipment_date" name="response_shipment_date" required />

		            <div class="clearfix"></div>

		        </div>

		        <div class="clearfix"></div>

		        <div class="order_data">

		       		<span class="order_label"><?php _e('Carrier pick up date:','nueve-woocommerce-jet-integration');?></span>

		       		<input type="datetime-local"  class="ship_order_inputs" id="carrier_pick_up_date" name="carrier_pick_up_date" required />

		            <div class="clearfix"></div>

		        </div>


		        <div class="clearfix"></div>

		        <div class="order_data">

		       		<span class="order_label"><?php _e('Expected delivery date:','nueve-woocommerce-jet-integration');?></span>

		       		<input  type="datetime-local" class="ship_order_inputs"  id="expected_delivery_date" name="expected_delivery_date" required />

		            <div class="clearfix"></div>

		        </div>

		        <div class="clearfix"></div>

		        <div class="order_data">

		       		<span class="order_label"><?php _e('Tracking Number:','nueve-woocommerce-jet-integration');?></span>

		       		<input type="text"  class="ship_order_inputs" id="tracking_number" name="tracking_number"  minlength='8' placeholder="Tracking Number" value="" />

		            <div class="clearfix"></div>

		        </div>
				
				<div class="clearfix"></div>

		        <div class="order_data">

		       		<span class="order_label"><?php _e('Ship from Zip Code:','nueve-woocommerce-jet-integration');?></span>

		       		<input type="text"  class="ship_order_inputs"  id="ship_from_zip_code" name="ship_from_zip_code" placeholder="Zip Code"  value="" required />

		            <div class="clearfix"></div>

		        </div>

		        <div class="order_data">

		       		<button type="submit" id="ship_order_btn" class="btn btn-primary"><?php _e('Ship Order','nueve-woocommerce-jet-integration');?></button>  

		            <img height="50px" width="50px" id="btn_loader_image" class="order_image_loader" src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?>">

		        </div>

			</div>			
		</div>

	<?php
	}
?>


