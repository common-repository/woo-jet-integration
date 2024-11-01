<?php 
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';
$jet_woo_plugin_url = jet_wordpress_plugin_url;

// jet configuration details
$jetapiurl 	= get_option('jetapiurl') ? get_option('jetapiurl') : 'https://merchant-api.jet.com/api/';
$jetapiuser = get_option('jetapiuser');
$jetsecretkey = get_option('jetsecretkey');
$jetfulfillmentid = get_option('jetfulfillmentid');
$jetemailaddress = get_option('jetemailaddress');
$jetstorename = get_option('jetstorename');
$jetreturnid = get_option('jetreturnid');
$jetfirstaddress = get_option('jetfirstaddress');
$jetsecondaddress = get_option('jetsecondaddress');
$jetcity = get_option('jetcity');
$jetstate = get_option('jetstate');
$jetzipcode = get_option('jetzipcode');

$jet_save_configuration_settings_nonce_check = wp_create_nonce('jet_save_configuration_settings_nonce_check');
$jet_reset_configuration_settings_nonce_check = wp_create_nonce('jet_reset_configuration_settings_nonce_check');
?>

<div class="wrap" id="settings_div">
	<h3><?php _e('Configuration Details','nueve-woocommerce-jet-integration'); ?></h3>

	<div id="success_message" class="flash_messages"></div>
	<div id="failure_message" class="flash_messages"></div>

	<table class="setting_form_table1">	
	   <tbody>	

	   		<input type="hidden" name="jet_save_configuration_settings_secure_key" value="<?php _e($jet_save_configuration_settings_nonce_check,'nueve-woocommerce-jet-integration'); ?>"  id="jet_save_configuration_settings_secure_key">

	   		<input type="hidden" name="jet_reset_configuration_settings_secure_key" value="<?php _e($jet_reset_configuration_settings_nonce_check,'nueve-woocommerce-jet-integration'); ?>"  id="jet_reset_configuration_settings_secure_key">

	   		<tr>
	   			<th></th>
	   			<td class="sub_heading">
	   				<?php _e('Jet Details','nueve-woocommerce-jet-integration'); ?>	
	   			</td>
	   		</tr>	

			<tr>
				<th class="settings_form_label">
					<?php _e('API Url','nueve-woocommerce-jet-integration'); ?>	
				</th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input" 
					placeholder="Api url" id="api_url" name="api_url" 
					value="<?php _e($jetapiurl,'nueve-woocommerce-jet-integration'); ?>"
					required >	
				</td>
			</tr>

			<tr>
				<th class="settings_form_label">
					<?php _e('API User','nueve-woocommerce-jet-integration'); ?>
				</th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input" 
					placeholder="Api User" id="api_user" name="api_user" 
					value="<?php _e($jetapiuser,'nueve-woocommerce-jet-integration'); ?>" required >	
				</td>
			</tr>

			<tr>
				<th class="settings_form_label">
					<?php _e('Secret Key','nueve-woocommerce-jet-integration'); ?>
				</th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input" 
					placeholder="Secret key" id="secret_key" name="secret_key"
					value="<?php _e($jetsecretkey,'nueve-woocommerce-jet-integration'); ?>" required >
				</td>
			</tr>

			<tr>
				<th class="settings_form_label">
					<?php _e('Fulfillment ID','nueve-woocommerce-jet-integration'); ?>
				</th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input" 
					placeholder="Fulfillment ID" id="fulfillment_id" name="fulfillment_id" 
					value="<?php _e($jetfulfillmentid,'nueve-woocommerce-jet-integration'); ?>" required >	
				</td>
			</tr>
		
			<tr>
				<th class="settings_form_label">
					<?php _e('Email Address','nueve-woocommerce-jet-integration'); ?>
				</th>
				<td class="settings_form_input_div">
					<input type="email" class="settings_form_input"  
					placeholder="Email Address" id="email_address" name="email_address" 
					value="<?php _e($jetemailaddress,'nueve-woocommerce-jet-integration'); ?>" required >
				</td>
			</tr>
			

			<tr>
				<th class="settings_form_label"><?php _e('Store Name','nueve-woocommerce-jet-integration'); ?></th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input"
					placeholder="Store Name" id="store_name" name="store_name" 
					value="<?php _e($jetstorename,'nueve-woocommerce-jet-integration'); ?>" required >
				</td>
			</tr>

			<tr>
				<th class="settings_form_label"></th>
				<td class="settings_form_input_div settings_btns_div">
					<button type="submit" class="button button-primary settings_btns" id="save_api_configuration" name="save_api_configuration"><?php _e('Save','nueve-woocommerce-jet-integration'); ?></button>
					<button type="submit" class="button button-primary settings_btns" id="reset_api_configuration" name="reset_api_configuration"><?php _e('Reset','nueve-woocommerce-jet-integration'); ?></button>
					<img height="50px" width="50px" id="jetloading"  style="display:none;" src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">
				</td>
			</tr>

		</tbody>
	</table>

	<table class="setting_form_table2">		
		<tbody>	

			<tr>
				<th></th>
	   			<td class="sub_heading">
	   				<?php _e('Return Location Details','nueve-woocommerce-jet-integration'); ?>
	   			</td>
	   		</tr>	

			<tr>
				<th class="settings_form_label">
					<?php _e('Return ID','nueve-woocommerce-jet-integration'); ?>
				</th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input"
					placeholder="Return ID" id="return_id" name="return_id" 
					value="<?php _e($jetreturnid,'nueve-woocommerce-jet-integration'); ?>" required >	
				</td>
			</tr>

			<tr>
				<th class="settings_form_label">
					<?php _e('First Address','nueve-woocommerce-jet-integration'); ?>
				</th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input" 
					placeholder="First Address" id="first_address" name="first_address"
					value="<?php _e($jetfirstaddress,'nueve-woocommerce-jet-integration'); ?>" 
					required >	
				</td>
			</tr>

			<tr>
				<th class="settings_form_label">
					<?php _e('Second Address','nueve-woocommerce-jet-integration'); ?>	
				</th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input" 
					placeholder="Second Address" id="second_address" name="second_address" 
					value="<?php _e($jetsecondaddress,'nueve-woocommerce-jet-integration'); ?>" >	
				</td>
			</tr>

			<tr>
				<th class="settings_form_label"><?php _e('City','nueve-woocommerce-jet-integration'); ?></th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input" 
					placeholder="City" id="city" name="city" 
					value="<?php _e($jetcity,'nueve-woocommerce-jet-integration'); ?>" 
					required >	
				</td>
			</tr>

			<tr>
				<th class="settings_form_label"><?php _e('State','nueve-woocommerce-jet-integration'); ?></th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input" 
					placeholder="State" id="state" name="state" 
					value="<?php _e($jetstate,'nueve-woocommerce-jet-integration'); ?>" 
					required >	
				</td>
			</tr>

			<tr>
				<th class="settings_form_label"><?php _e('Zip Code','nueve-woocommerce-jet-integration'); ?></th>
				<td class="settings_form_input_div">
					<input type="text" class="settings_form_input"
					placeholder="Zip Code" id="zip_code" name="zip_code" 
					value="<?php _e($jetzipcode,'nueve-woocommerce-jet-integration'); ?>" 
					required >	
				</td>
			</tr>

		</tbody>
	</table>

</div>