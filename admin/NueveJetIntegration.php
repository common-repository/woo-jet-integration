<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class NueveJetIntegration {

	private static $_instance;
	
	public static function getInstance() {
		self::$_instance = new self;
		if( !self::$_instance instanceof self )
			self::$_instance = new self;	     
		return self::$_instance;	
	}

	public function nuevejet_scripts() {	
			
		wp_enqueue_script( 'jet_general_script',plugins_url('../js/general.js',__FILE__) );

		if(isset($_GET['page']) && ($_GET['page']  == 'Jet-Integration') ) {
			wp_enqueue_style('jet_general_style',plugins_url('../css/general.css', __FILE__) );
		
			wp_enqueue_script( 'jet_bootstrap_script',plugins_url('../js/bootstrap.min.js',__FILE__) );
			wp_enqueue_style('jet_bootstrap_style',plugins_url('../css/bootstrap.min.css', __FILE__) );

			wp_enqueue_script( 'jet_botstrap_select_script',plugins_url('../js/bootstrap-select.min.js',__FILE__) );
			wp_enqueue_style('jet_bootstrap_select_style',plugins_url('../css/bootstrap-select.min.css', __FILE__) );

			if ( isset ( $_GET['tab'] ) ) {	

				if($_GET['tab'] == 'settings') 	{ 
					wp_enqueue_script( 'jet_settings',plugins_url('../js/jet_settings.js',__FILE__) );
				}			

				if($_GET['tab'] == 'mapping-categories') {
					wp_enqueue_script( 'jet_mc_script',plugins_url('../js/jet_mc_script.js',__FILE__) );
				}

				if($_GET['tab'] == 'products' || $_GET['tab'] == 'jet-products' || $_GET['tab'] == 'jet-orders' || $_GET['tab'] == 'jet-returns' || $_GET['tab'] == 'jet-refunds') 	{
					wp_enqueue_style('jet_dataTable_style',plugins_url('../css/jquery.dataTables.min.css', __FILE__) );
					wp_enqueue_script( 'jet_dataTable_script',plugins_url('../js/jquery.dataTables.min.js',__FILE__) );
				}

				if($_GET['tab'] == 'products') 	{ 
					wp_enqueue_script( 'jet_woo_pro_script',plugins_url('../js/jet_woo_products.js',__FILE__) );
				}

				if($_GET['tab'] == 'jet-products') 	{ 
					wp_enqueue_script( 'jet_pro_script',plugins_url('../js/jet_products.js',__FILE__) );
				}


				if($_GET['tab'] == 'jet-product-view') 	{ 
					wp_enqueue_script( 'jet_pro_view_script',plugins_url('../js/jet_product_view.js',__FILE__) );
				}

				if($_GET['tab'] == 'jet-orders') 	{ 
					wp_enqueue_script( 'jet_order_script',plugins_url('../js/jet_orders.js',__FILE__) );
				}

				if($_GET['tab'] == 'jet-order-view') 	{ 
					wp_enqueue_script( 'jet_order_view_script',plugins_url('../js/jet_order_view.js',__FILE__) );
				}

				if($_GET['tab'] == 'jet-ship-order') 	{ 
					wp_enqueue_script( 'jet_ship_order_script',plugins_url('../js/jet_ship_order.js',__FILE__) );
				}

				if($_GET['tab'] == 'jet-returns') 	{ 
					wp_enqueue_script( 'jet_returns_script',plugins_url('../js/jet_returns.js',__FILE__) );
				}

				if($_GET['tab'] == 'jet-return-view') 	{ 
					wp_enqueue_script( 'jet_return_view_script',plugins_url('../js/jet_return_view.js',__FILE__) );
				}

				if($_GET['tab'] == 'jet-complete-return') 	{ 
					wp_enqueue_script( 'jet_complete_return_script',plugins_url('../js/jet_complete_return.js',__FILE__) );
				}

				if($_GET['tab'] == 'jet-refunds') 	{ 
					wp_enqueue_script( 'jet_refunds_script',plugins_url('../js/jet_refunds.js',__FILE__) );
				}

				if($_GET['tab'] == 'jet-refund-view') 	{ 
					wp_enqueue_script( 'jet_refund_view_script',plugins_url('../js/jet_refund_view.js',__FILE__) );
				}
			} else {
				wp_enqueue_script( 'jet_settings',plugins_url('../js/jet_settings.js',__FILE__) );
			}
		}
		
	}


	public function nuevejet_checkapiaccess() {

		$result = '';
		if(check_admin_referer('jet_checkapiaccess_nonce_check','jet_checkapiaccess_secure_key')){
			$result = @admin::CheckApiAccess();
		}
		echo $result;
		exit;
	}



	public function nuevejet_save_configuration_settings() 	{

		if(check_admin_referer('jet_save_configuration_settings_nonce_check','jet_save_configuration_settings_secure_key')) {

			$result = '';
			if(isset($_POST['save_api_configuration'])) {

				$api_url = 	sanitize_text_field( esc_attr($_POST['api_url']) );
				$api_user = 	sanitize_text_field( esc_attr($_POST['api_user']) );
				$secret_key = 	sanitize_text_field( esc_attr($_POST['secret_key']) );
				$fulfillment_id = sanitize_text_field( esc_attr($_POST['fulfillment_id']) );
				$email_address = 	sanitize_text_field( esc_attr($_POST['email_address']) );
				$store_name = 	sanitize_text_field( esc_attr($_POST['store_name']) );
				$return_id = 	sanitize_text_field( esc_attr($_POST['return_id']) );
				$first_address = 	sanitize_text_field( esc_attr($_POST['first_address']) );
				$second_address = 	sanitize_text_field( esc_attr($_POST['second_address']) );
				$city = 	sanitize_text_field( esc_attr($_POST['city']) );
				$state = 	sanitize_text_field( esc_attr($_POST['state']) );
				$zip_code = sanitize_text_field( esc_attr($_POST['zip_code']) );

				if ( is_email( $email_address ) ) {

					update_option('jetapiurl',	$api_url);
					update_option('jetapiuser', $api_user);
					update_option('jetsecretkey',	$secret_key);
					update_option('jetfulfillmentid',	$fulfillment_id);
					update_option('jetemailaddress',	$email_address);
					update_option('jetstorename',	$store_name);
					update_option('jetreturnid',	$return_id);
					update_option('jetfirstaddress',	$first_address);
					update_option('jetsecondaddress',	$second_address);
					update_option('jetcity',	$city);
					update_option('jetstate',	$state);
					update_option('jetzipcode', $zip_code);	

					$result = 'success';	
				} else {
					$result = 'Not a Valid Email Address. Please enter correct email address';
				}	
			}
			echo $result;			
			exit;	
		}			
	}

	public function nuevejet_reset_configuration_settings() 	{

		if(check_admin_referer('jet_reset_configuration_settings_nonce_check','jet_reset_configuration_settings_secure_key')) {

			$result = '';			
			if(isset($_POST['reset_api_configuration'])) {

				delete_option('jetapiurl');
				delete_option('jetapiuser');
				delete_option('jetsecretkey');
				delete_option('jetfulfillmentid');
				delete_option('jetemailaddress');
				delete_option('jetstorename');
				delete_option('jetreturnid');
				delete_option('jetfirstaddress');
				delete_option('jetsecondaddress');
				delete_option('jetcity');
				delete_option('jetstate');
				delete_option('jetzipcode');

				$result = 'success';			
			}
			echo $result;			
			exit;	
		}			
	}

	public function nuevejet_mapped_category_list() {

		if(check_admin_referer('jet_map_category_list_nonce_check','jet_map_category_list_secure_key')) {
			$update_mapped_cat = get_option('NueveWooJetMapping',true);
			$all_map_cat_details = array();
			$i = 0;
			foreach($update_mapped_cat as $woo_cat => $jetcatid){
				$term	=	get_term_by('id', $woo_cat, 'product_cat');
				if(isset($term)){
					$mappedWooCatName	=	$term->name;
				}
				$all_map_cat_details[$i]['woo_cat_id'] 		= $woo_cat;
				$all_map_cat_details[$i]['woo_cat_name'] 	= $mappedWooCatName;
				$all_map_cat_details[$i]['jet_cat_id'] 		= $jetcatid;
				$i++;	
			}
			$result = array('mapped_category_list'=>$all_map_cat_details);


			echo json_encode($result);		
			exit;	
		}
	}


	public function nuevejet_mapped_add_category()  {
		if(check_admin_referer('jet_map_category_adding_nonce_check','jet_map_category_adding_secure_key')) {

			if(isset( $_POST['woo_category'] ) && isset( $_POST['jet_cat_id'] ) ) {

				$woo_category = sanitize_text_field( esc_attr($_POST['woo_category']) );
				$jet_cat_id = sanitize_text_field( esc_attr($_POST['jet_cat_id']) );

				if(!empty($woo_category) && !empty($jet_cat_id)) {

					$jetmappedArray	=	get_option('NueveWooJetMapping',false);

					if(empty($jetmappedArray)){
						$jetmappedArray				=	array();
						$jetmappedArray[$woo_category]		=	$jet_cat_id;	
						// insert attributes values
						@admin::nuevejet_insertAttributeData($jet_cat_id);			
					} else {					
						if(is_array($jetmappedArray)) {
							$tempArray = array();
							foreach ($jetmappedArray as $mappedWoocat => $mappedjetcat) {	
								$tempArray[]	=	$mappedWoocat;
							}

							if(in_array($woo_category, $tempArray)) {							
								$result = array('response'=>'Product Category is already mapped with a Jet Category');
								echo json_encode($result);
								exit;
							} else{							
								$jetmappedArray[$woo_category]		=	$jet_cat_id;
								// insert attributes values
								@admin::nuevejet_insertAttributeData($jet_cat_id);
							}
						}
					}

					// updating category values
					update_option('NueveWooJetMapping', $jetmappedArray);

					//ouput response
					$result = array('response'=>'success');				
					echo json_encode($result);		
					exit;			
				}
			}
		}
	}


	public function nuevejet_mapped_category_delete()  {

		if(check_admin_referer('jet_map_category_delete_nonce_check','jet_map_category_delete_secure_key')) {
			
			if(isset( $_POST['product_category_id'] )) {
				$product_category_id = sanitize_text_field( esc_attr($_POST['product_category_id']) );

				if(!empty($product_category_id)) {

					$jetmappedArray	=	get_option('NueveWooJetMapping',false);

					foreach($jetmappedArray as $wooid => $jetCatId) {
						if($wooid	==	$product_category_id) {
							unset($jetmappedArray[$wooid]);
							delete_option($jetCatId.'_NueveJetAttributes');
						}
					}

					// updating category values
					update_option('NueveWooJetMapping', $jetmappedArray);
					
					//ouput response
					$result = array('response'=>'success');				
					echo json_encode($result);		
					exit;			
				}
			}
		}
	}

	public function nuevejet_get_products_list() {

		if(check_admin_referer('jet_get_products_list_nonce_check','jet_get_products_list_secure_key')) {
			$result = '';
			if(isset($_POST['product_type']) && !empty($_POST['product_type'])) {
				$product_type = sanitize_text_field( esc_attr( $_POST['product_type'] ));
				$cur_page = sanitize_text_field( esc_attr( $_POST['cur_page'] ));
				$page_limit = sanitize_text_field( esc_attr( $_POST['page_limit'] ));

				$result = @admin::jet_get_products_list($product_type, $cur_page, $page_limit);	
			}
			echo $result;			
			exit;	
		}
	}

	public function nuevejet_refresh_data() {
		if(check_admin_referer('jet_refresh_data_nonce_check','jet_refresh_data_secure_key')) {	
			$result = '';

			if(isset($_POST['cron_type']) && !empty($_POST['cron_type'])) {	
				$cron_type = sanitize_text_field( esc_attr($_POST['cron_type'] ));	
				$result = @admin::jet_refresh_data($cron_type);				
				echo $result;			
				exit;	
			}
		}
	}

	

	public function nuevejet_get_product_details() {

		if(check_admin_referer('jet_get_product_details_nonce_check','jet_get_product_details_secure_key')) {
			$result = '';
			if(isset($_POST['product_sku']) && !empty($_POST['product_sku'])) {
				$product_sku = sanitize_text_field( esc_attr($_POST['product_sku'] ));
				$result = @admin::jet_get_product_details($product_sku);				
			}
			echo $result;			
			exit;
		}
	}

	public function nuevejet_update_product_details() {

		if(check_admin_referer('jet_update_product_details_nonce_check','jet_update_product_details_secure_key')) {
			$result = '';
			if(isset($_POST['pdt_data']) && !empty($_POST['pdt_data'])) {
				$pdt_data = $_POST['pdt_data'];
				$result = @admin::jet_update_product_details($pdt_data);				
			}
			echo $result;			
			exit;
		}
	}

	public function nuevejet_get_category_attributes() {

		if(check_admin_referer('jet_get_category_attributes_nonce_check','jet_get_category_attributes_secure_key')) {
			$result = '';
			if(isset($_POST['jet_category']) && !empty($_POST['jet_category'])) {
				$jet_category = sanitize_text_field( esc_attr($_POST['jet_category'] ));
				$result = @admin::jet_get_category_attributes($jet_category);				
			}
			echo $result;			
			exit;
		}
	}

	public function nuevejet_get_orders_list() {

		if(check_admin_referer('jet_get_orders_list_nonce_check','jet_get_orders_list_secure_key')) {
			$result = '';
			if(isset($_POST['order_type']) && !empty($_POST['order_type'])) {
				$order_type = sanitize_text_field( esc_attr( $_POST['order_type'] ));
				$cur_page = sanitize_text_field( esc_attr( $_POST['cur_page'] ));
				$page_limit = sanitize_text_field( esc_attr( $_POST['page_limit'] ));

				$result = @admin::jet_get_orders_list($order_type, $cur_page, $page_limit);				
			}
			echo $result;			
			exit;	
		}			
	}

	public function nuevejet_get_order_details() {

		if(check_admin_referer('jet_get_order_details_nonce_check','jet_get_order_details_secure_key')) {
			$result = '';
			if(isset($_POST['order_id']) && !empty($_POST['order_id'])) {
				$order_id = sanitize_text_field( esc_attr( $_POST['order_id'] ));
				$result = @admin::jet_get_order_details($order_id);				
			}
			echo $result;			
			exit;	
		}			
	}

	public function nuevejet_acknowledge_order() {

		if(check_admin_referer('jet_acknowledge_order_nonce_check','jet_acknowledge_order_secure_key')) {

			$result = '';
			if(isset($_POST['order_id']) && !empty($_POST['order_id']) && 
				isset($_POST['ack_type']) && !empty($_POST['ack_type']) ) {

				$order_id = sanitize_text_field( esc_attr( $_POST['order_id'] ));
				$ack_type = sanitize_text_field( esc_attr( $_POST['ack_type'] ));

				$result = @admin::jet_acknowledge_order($order_id, $ack_type);				
			}
			echo $result;			
			exit;	
		}			
	}

	public function nuevejet_order_cancel() {

		if(check_admin_referer('jet_order_cancel_nonce_check','jet_order_cancel_secure_key')) {

			$result = '';
			if(isset($_POST['order_id']) && !empty($_POST['order_id'])) {
				$order_id = sanitize_text_field( esc_attr( $_POST['order_id'] ));
				$result = @admin::jet_order_cancel($order_id);				
			}
			echo $result;			
			exit;	
		}			
	}

	public function nuevejet_ship_order() {

		if(check_admin_referer('jet_ship_order_nonce_check','jet_ship_order_secure_key')) {

			$result = '';
			if(isset($_POST['order_id']) && !empty($_POST['order_id'])) {

				$order_id = sanitize_text_field( esc_attr($_POST['order_id']));
				$carrier = sanitize_text_field(esc_attr($_POST['carrier']));
				$response_shipment_method = sanitize_text_field(esc_attr($_POST['response_shipment_method']));
				$response_shipment_date = sanitize_text_field(esc_attr($_POST['response_shipment_date']));
				$carrier_pick_up_date = sanitize_text_field(esc_attr($_POST['carrier_pick_up_date']));
				$expected_delivery_date = sanitize_text_field(esc_attr($_POST['expected_delivery_date']));
				$tracking_number = sanitize_text_field(esc_attr($_POST['tracking_number']));
				$ship_from_zip_code = sanitize_text_field(esc_attr($_POST['ship_from_zip_code']));
			
				$ship_order_array = array('carrier'=>$carrier,'response_shipment_method'=>$response_shipment_method,'response_shipment_date'=>$response_shipment_date,'carrier_pick_up_date'=>$carrier_pick_up_date,'expected_delivery_date'=>$expected_delivery_date,'tracking_number'=>$tracking_number,'ship_from_zip_code'=>$ship_from_zip_code);
				
				$result = @admin::jet_ship_order($order_id,$ship_order_array);				
			}
			echo $result;			
			exit;	
		}			
	}

	public function nuevejet_request_refund_order() {

		if(check_admin_referer('jet_request_refund_nonce_check','jet_request_refund_secure_key')) {

			$result = '';
			if(isset($_POST['order_id']) && !empty($_POST['order_id'])) {

				$order_id = sanitize_text_field( esc_attr($_POST['order_id']));
				$order_item_id = sanitize_text_field(esc_attr($_POST['order_item_id']));
				$refund_reason = sanitize_text_field(esc_attr($_POST['refund_reason']));
				$total_quantity_returned = sanitize_text_field(esc_attr($_POST['total_quantity_returned']));
				$order_return_refund_qty = sanitize_text_field(esc_attr($_POST['order_return_refund_qty']));
				$r_amount_principal = sanitize_text_field(esc_attr($_POST['r_amount_principal']));
				$refund_amount_principal = sanitize_text_field(esc_attr($_POST['refund_amount_principal']));
				$refund_amount_shipping_cost = sanitize_text_field(esc_attr($_POST['refund_amount_shipping_cost']));
				$refund_amount_shipping_tax = sanitize_text_field(esc_attr($_POST['refund_amount_shipping_tax']));
				$refund_amount_tax = sanitize_text_field(esc_attr($_POST['refund_amount_tax']));
				$refund_feedback = sanitize_text_field(esc_attr($_POST['refund_feedback']));
				$notes = sanitize_text_field(esc_attr($_POST['notes']));

				$refund_array = array('order_item_id'=>$order_item_id,'refund_reason'=>$refund_reason,'total_quantity_returned'=>$total_quantity_returned,'order_return_refund_qty'=>$order_return_refund_qty,'r_amount_principal'=>$r_amount_principal,'refund_amount_principal'=>$refund_amount_principal,'refund_amount_shipping_cost'=>$refund_amount_shipping_cost,'refund_amount_shipping_tax'=>$refund_amount_shipping_tax,'refund_amount_tax'=>$refund_amount_tax,'refund_feedback'=>$refund_feedback,'notes'=>$notes);

				//$result = json_encode($refund_array);
				
				$result = @admin::jet_request_refund_order($order_id, $refund_array);				
			}
			echo $result;			
			exit;	
		}				
	}

	public function nuevejet_get_returns_list() 	{

		if(check_admin_referer('jet_get_returns_list_nonce_check','jet_get_returns_list_secure_key')) {
			$result = '';
			if(isset($_POST['return_type']) && !empty($_POST['return_type'])) {
				$return_type = sanitize_text_field(esc_attr($_POST['return_type']));
				$cur_page = sanitize_text_field( esc_attr( $_POST['cur_page'] ));
				$page_limit = sanitize_text_field( esc_attr( $_POST['page_limit'] ));
				$result = @admin::jet_get_returns_list($return_type, $cur_page, $page_limit);	
			}
			echo $result;			
			exit;	
		}			
	}
	

	public function nuevejet_get_return_details() {

		if(check_admin_referer('jet_get_return_details_nonce_check','jet_get_return_details_secure_key')) {
			$result = '';
			if(isset($_POST['return_id']) && !empty($_POST['return_id'])) {
				$return_id = sanitize_text_field(esc_attr( $_POST['return_id']));
				$result = @admin::get_return_details($return_id);				
			}
			echo $result;			
			exit;	
		}			
	}

	public function nuevejet_return_complete() {	

		if(check_admin_referer('jet_get_return_complete_nonce_check','jet_get_return_complete_secure_key')) {

			$result = '';	
			if(isset($_POST['return_authorization_id']) && !empty($_POST['return_authorization_id'])) {

				$return_id = sanitize_text_field(esc_attr($_POST['return_authorization_id']));
				$merchant_order_id = sanitize_text_field(esc_attr($_POST['merchant_order_id']));
				$alt_order_id = sanitize_text_field(esc_attr($_POST['alt_order_id']));
				$refund_type = sanitize_text_field(esc_attr($_POST['refund_type']));
				$agree_to_return_charge = sanitize_text_field(esc_attr($_POST['agree_to_return_charge']));
				$order_item_id = sanitize_text_field(esc_attr($_POST['order_item_id']));
				$order_return_refund_qty = sanitize_text_field(esc_attr($_POST['order_return_refund_qty']));
				$refund_amount_shipping_cost = sanitize_text_field(esc_attr($_POST['refund_amount_shipping_cost']));
				$refund_amount_shipping_tax = sanitize_text_field(esc_attr($_POST['refund_amount_shipping_tax']));
				$refund_amount_tax = sanitize_text_field(esc_attr($_POST['refund_amount_tax']));
				$refund_amount_principal = sanitize_text_field(esc_attr($_POST['refund_amount_principal']));
				$return_charge_feedback = sanitize_text_field(esc_attr($_POST['return_charge_feedback']));
				$return_refund_feedback = sanitize_text_field(esc_attr($_POST['return_refund_feedback']));
				$total_quantity_returned = sanitize_text_field(esc_attr($_POST['total_quantity_returned']));


				$return_array = array('merchant_order_id'=>$merchant_order_id,'alt_order_id'=>$alt_order_id,'refund_type'=>$refund_type,'agree_to_return_charge'=>$agree_to_return_charge,'order_item_id'=>$order_item_id,'order_return_refund_qty'=>$order_return_refund_qty,'refund_amount_shipping_cost'=>$refund_amount_shipping_cost,'refund_amount_shipping_tax'=>$refund_amount_shipping_tax,'refund_amount_tax'=>$refund_amount_tax,'refund_amount_principal'=>$refund_amount_principal,'return_charge_feedback'=>$return_charge_feedback,'return_refund_feedback'=>$return_refund_feedback,'total_quantity_returned'=>$total_quantity_returned);

				$result = @admin::jet_return_complete($return_id,$return_array);
			}
		}
		echo $result;
		exit;				
	}	


	public function nuevejet_get_refunds_list() {

		if(check_admin_referer('jet_get_refunds_list_nonce_check','jet_get_refunds_list_secure_key')) {
			$result = '';
			if(isset($_POST['refund_type']) && !empty($_POST['refund_type'])) {
				$refund_type = sanitize_text_field(esc_attr($_POST['refund_type']));
				$cur_page = sanitize_text_field( esc_attr( $_POST['cur_page'] ));
				$page_limit = sanitize_text_field( esc_attr( $_POST['page_limit'] ));

				$result = @admin::jet_get_refunds_list($refund_type, $cur_page, $page_limit);			
			}
			echo $result;			
			exit;	
		}					
	}

	public function nuevejet_get_refund_details() {

		if(check_admin_referer('jet_get_refund_details_nonce_check','jet_get_refund_details_secure_key')) {
			$result = '';
			if(isset($_POST['refund_id']) && !empty($_POST['refund_id'])) {
				$refund_id = sanitize_text_field(esc_attr($_POST['refund_id']));
				$result = @admin::get_refund_details($refund_id);				
			}
			echo $result;			
			exit;	
		}			
	}


	public function nuevejet_WooCustomTab() {		
		?>
		<li class="custom_tab">
			<a href="#jet_attribute_settings"> Jet Attributes</a>
		</li>
		<li class="custom_tab">
			<a href="#jet_extra_attribute_settings"> Jet Extra Attributes</a>
		</li><?php
	}


	public function nuevejet_WooCustomTabFields() {
		global $post;
		$_product 		= 	get_product($post->ID);
		
		if(!$_product->is_type('simple'))
			return;

		$custom_tab_options = array(
			'JetParentSKU' => get_post_meta($post->ID,'JetParentSKU',true),
			'JetStandardProductCodeType'=> get_post_meta($post->ID,'JetStandardProductCodeType',true),
			'JetStandardProductCode' => get_post_meta($post->ID,'JetStandardProductCode',true),
			'Jet_PriceSelect' => get_post_meta($post->ID,'Jet_PriceSelect',true),
			'Jet_Price'		=> get_post_meta($post->ID, 'Jet_Price',true),
			'Jet_StockSelect' => get_post_meta($post->ID, 'Jet_StockSelect',true),
			'Jet_Stock'		=> get_post_meta($post->ID, 'Jet_Stock',true)
		);

		$extra_tab_options = array(			
			'JetMultiPackQuantity'		=> get_post_meta($post->ID,'JetMultiPackQuantity',true),
			'JetMapPrice'		=> get_post_meta($post->ID,'JetMapPrice',true),
			'JetMapImplementation'		=> get_post_meta($post->ID,'JetMapImplementation',true),
			'JetMSRP'		=> get_post_meta($post->ID,'JetMSRP',true),
			'JetProductBrand'		=> get_post_meta($post->ID,'JetProductBrand',true),
			'JetCountry' =>	 get_post_meta($post->ID, 'JetCountry', true),
			'JetProductManufacturer' =>get_post_meta($post->ID, 'JetProductManufacturer', true),
			'JetMFR'   => get_post_meta($post->ID,'JetMFR',true),
			'JetPackageLength' =>get_post_meta($post->ID, 'JetPackageLength', true),
			'JetPackageWidth' =>get_post_meta($post->ID, 'JetPackageWidth', true),
			'JetPackageHeight' =>get_post_meta($post->ID, 'JetPackageHeight', true),
			'JetProductTaxCode' =>get_post_meta($post->ID, 'JetProductTaxCode', true),
			'JetSafetyWarning' =>get_post_meta($post->ID, 'JetSafetyWarning', true),
	        'JetLegalDisc' =>get_post_meta($post->ID, 'JetLegalDisc', true),
	        'JetProp65' =>get_post_meta($post->ID, 'JetProp65', true),
	        'JetBullets' =>get_post_meta($post->ID, 'JetBullets', true),
	        'JetCpsiaCautionaryStatements' =>get_post_meta($post->ID, 'JetCpsiaCautionaryStatements', true)
		);
		?>

		<style>
			.jet-field-labels {
				width: 35% !important;
				margin-right:20px !important;
			}

			.jet-text-fields, .jet-select-fields {
				width: 60% !important;
			}

			.woocommerce_options_panel .dimensions_field .wrap {
				width:80% !important;
			}

			.woocommerce_options_panel .dimensions_field .wrap input {
				width: 24% !important;
				margin-right: 2% !important;
			}

			.bullet_field2, .bullet_field3, .bullet_field4, .bullet_field5 {
				margin-left: 10px !important;
    			margin-top: 5px !important;
			}

		</style>
	    <div id="jet_attribute_settings" class="panel woocommerce_options_panel">

	    	<div class="options_group"> 
	        	<p class="form-field">
	        		<label class="jet-field-labels">Parent SKU</label>
	        		<input type="text" class="jet-text-fields" name="JetParentSKU" value="<?php echo @$custom_tab_options['JetParentSKU']; ?>" placeholder="Parent SKU" />
	        	</p>
	        </div>

	        <div class="options_group"> 
	        	<p class="form-field">
	        		<label class="jet-field-labels">Standard Product Code Type</label>
	        		<select name="JetStandardProductCodeType" class="jet-select-fields">
           	 			<option value="GTN-14" <?php if(@$custom_tab_options['JetStandardProductCodeType'] == 'GTN-14'){ echo "selected"; }?>>GTN-14</option>
           	 			<option value="EAN" <?php if(@$custom_tab_options['JetStandardProductCodeType'] == 'EAN'){ echo "selected"; }?>>EAN</option>
           	 			<option value="ISBN-10" <?php if(@$custom_tab_options['JetStandardProductCodeType'] == 'ISBN-10'){ echo "selected"; }?>>ISBN-10</option>
           	 			<option value="ISBN-13" <?php if(@$custom_tab_options['JetStandardProductCodeType'] == 'ISBN-13'){ echo "selected"; }?>>ISBN-13</option>
           	 			<option value="UPC" <?php if(@$custom_tab_options['JetStandardProductCodeType'] == 'UPC'){ echo "selected"; }?>>UPC</option>
           	 			<option value="ASIN" <?php if(@$custom_tab_options['JetStandardProductCodeType'] == 'ASIN'){ echo "selected"; }?>>ASIN</option>
           	 		</select>
	        	</p> 
	        	<p class="form-field">
	        		<label class="jet-field-labels">Standard Product Code</label>
	        		<input type="text" size="20" class="jet-text-fields" name="JetStandardProductCode" value="<?php echo @$custom_tab_options['JetStandardProductCode']; ?>" Placeholder="Standard Product Code" />
	        	</p>
	        </div>

	        <?php $type = 'sale';?>
	        <div class="options_group">
	        	<p class="form-field">
		        	<label class="jet-field-labels">Jet Price</label>
		        	<select name="Jet_PriceSelect" id="Jet_PriceSelect" class="jet-select-fields">
		        		<option value="main_price" <?php if(@$custom_tab_options['Jet_PriceSelect'] == 'main_price'){ echo "selected"; }?>>Main Price</option>
		        		<option value="sale_price" <?php if(@$custom_tab_options['Jet_PriceSelect'] == 'sale_price'){ echo "selected"; }?>>Sale Price</option>
		        		<option value="otherPrice" <?php if(@$custom_tab_options['Jet_PriceSelect'] == 'otherPrice'){ echo "selected"; }?>>Other</option>
		        	</select>
	        	</p>

	        	<p class="form-field" id="JetPriceField" <?php if(@$custom_tab_options['Jet_PriceSelect']!='otherPrice'){ echo 'style="display: none"'; }?> >
	                <label class="jet-field-labels">Price</label>
		            <input type="number" size="5" step="0.01" class="jet-text-fields"  name="Jet_Price" value="<?php echo @$custom_tab_options['Jet_Price']; ?>"  placeholder="Product Price" />
             	</p>
	        </div>

	        <div class="options_group">
	        	<p class="form-field">
		        	<label class="jet-field-labels">Jet Stock</label>
		        	<select name="Jet_StockSelect" id="Jet_StockSelect"  class="jet-select-fields">
		        		<option value="central" <?php if(@$custom_tab_options['Jet_StockSelect'] == 'central'){ echo "selected"; }?>>central (product Stock)</option>
		        		<option value="other" <?php if(@$custom_tab_options['Jet_StockSelect'] == 'other'){ echo "selected"; }?>>Other</option>
		        	</select>
	        	</p>

	        	<p class="form-field" id="JetStockField" <?php if($custom_tab_options['Jet_StockSelect']!='other'){ echo 'style="display: none"'; }?> >
	                <label class="jet-field-labels">Stock</label>
		            <input type="number" size="5" step="1" class="jet-text-fields"  name="Jet_Stock" value="<?php echo @$custom_tab_options['Jet_Stock']; ?>"  Placeholder="Product Stock" />
             	</p>
	        </div>

		    <?php
			    $productCats 			= 	get_the_terms($post->ID, "product_cat");
		    	$mappedIDs				=	get_option('NueveWooJetMapping',true);

				if(!empty($productCats)) {
			    	if(is_array($mappedIDs)) {	    			
			    		$catArray	=	array();
			    		foreach($mappedIDs as $woocatid => $jetcatId) {	    				
			    			$catArray[]	=	$woocatid;
			    		}
			    			
			    		if(!empty($catArray) && is_array($catArray)){
			    			
							$jetSelectedNodeID = array();
			    			foreach ($productCats as $index	=>	$catObject){
			    				if(in_array($catObject->term_id, $catArray)) {     				
			    					$jetSelectedNodeID[$catObject->term_id]	=	$mappedIDs[$catObject->term_id];
			    				}
			    			}
			    		}
			    	}
		    	}

		    	$jetAttrInfo	=	array();

		    	if(!empty($jetSelectedNodeID)) {
			    	foreach($jetSelectedNodeID as $wooNodeID => $jetNodeID) {    		
						$mappedAttributes		=	get_option($jetNodeID.'_NueveJetAttributes',false);
						

						if($mappedAttributes) {				
							$mappedAttributes	=	json_decode($mappedAttributes);

							if(is_array($mappedAttributes)) {						
								$jetAttrInfo[$jetNodeID] = @admin::nuevejet_getattrdetails($mappedAttributes);	

							}
						}
					}
		    	}

		    	//exit;
		    	
		    	$enable 	= 	get_post_meta($post->ID,'JetSelectedCatAttr', true);

		    	if(!empty($jetAttrInfo) && count($jetAttrInfo)){
		    		foreach($jetAttrInfo as $jetNode => $mappedCAT) {
		    			$wooCatID 	=	array_search($jetNode, $jetSelectedNodeID);
			      		$term	=	get_term_by('id', $wooCatID, 'product_cat');
			      
			    		$mappedWooCatName	=	'';			    		
			    		if(isset($term)) {	
			    			$mappedWooCatName	=	$term->name;
			    		}
			    		if($enable == $jetNode){
			    			$check = "checked='checked'";
			    		}else{
			    			$check	=	'';
			    		}?>

			    		<div class="options_group" >
				    		<p><?php _e($mappedWooCatName." JET Attributes",'wocommerce-jet-integration');?>
				    			<input type="radio" class="jet-category-select" name="JetSelectedCatAttr" value="<?php echo $jetNode;?>" <?php echo $check;?>>
				    			<img class="expand-image" value="<?php echo $jetNode; ?>" style="float: right;" src="<?php echo nuevejet_url;?>images/expand.png" height="16" width="16" />
				    			<img class="help_tip" data-tip="<?php _e("Select this if you want to send the attributes mapped with this jet category(only single category attributes can be sent to jet.)", "woocommerce-jet-integration");?>" src="<?php echo nuevejet_url;?>images/help.png" height="16" width="16" />
				    		</p>
			    		</div>
			    		<div class="options_group" id="<?php echo $jetNode;?>" style="display: none">
			    			<?php
			    			foreach($mappedCAT as $attrARRAY) {
			    				$attrObject = $attrARRAY[0];			    				

			    				if($attrObject->freetext == 1) {
			    					$tempName	=	$jetNode."_".$attrObject->jet_attr_id;
									$tempValue	=	get_post_meta($post->ID, $tempName , true);
			    					?>
				    				<p class="form-field dimensions_field">
										<label for="jetAttributes"><?php echo stripslashes($attrObject->name);?></label>
										<?php ?>
										<input type="text" value="<?php echo $tempValue;?>" name="<?php echo $tempName;?>" size="5" >
										<?php if($attrObject->variant==1){?><img class="help_tip" data-tip="<?php echo 'Variant must be filled';?>" src="<?php echo nuevejet_url;?>images/help.png" height="16" width="16" /><?php } ?>
									</p>
			    				<?php
			    				}

			    				if($attrObject->freetext == 0 && !empty($attrObject->values) && empty($attrObject->unit)) {

			    					$tempName	=	$jetNode."_".$attrObject->jet_attr_id;
					    			$tempValue	=	get_post_meta($post->ID, $tempName , true);

					    			$values	=	json_decode($attrObject->values);
					    		
					    			$assocValues	=	array();
					    			$assocValues['none']	=	'Select A Value';
	    			
				    				if(!empty($values)){
					    			foreach($values as $VALUE):
					    				$assocValues[$VALUE]	=	$VALUE;
					    			endforeach;
					    			}


					    			if($attrObject->variant==0){
		            					woocommerce_wp_select(
		              						array(
		              			        		'id'      => $tempName,
		              			        		'label'   => $attrObject->name,
		              			        		'description' =>'Select a value',
		              			        		'value'       => $tempValue,
		              			        		'options' => $assocValues,
	              			        		)
		              			        );
	              			  		}


  			            			if($attrObject->variant==1){
  			            				woocommerce_wp_select(
											array(
											'id'      => $tempName,
											'label'   => $attrObject->name,
											'description' =>'Used as Variant',
											'value'       => $tempValue,
											'options' => $assocValues,
											)
										);
  			            			}
					    		}
			    			} ?>
			    		</div>
		    		<?php
			    	}
		    	}
			?>

	    </div>

	    <div id="jet_extra_attribute_settings" class="panel woocommerce_options_panel">

	    	<div class="options_group"> 

	       		<p class="form-field">
		           <label class="jet-field-labels">MultiPack Quantity</label>
			        <input type="text" step="1" size="3" class="jet-text-fields" name="JetMultiPackQuantity" value="<?php echo @$extra_tab_options['JetMultiPackQuantity']; ?>" placeholder = "Multipack Quantity" />
		        </p>

		        <p class="form-field">
		           <label class="jet-field-labels">Map Price</label>
			        <input type="text" step="0.01" size="5" class="jet-text-fields" name="JetMapPrice" value="<?php echo @$extra_tab_options['JetMapPrice']; ?>"  placeholder="Map Price" />
		        </p>

		        <p class="form-field">
		           <label class="jet-field-labels">Map Implementation</label>
			        <select name="JetMapImplementation" class="jet-select-fields">
			        	<option value="101" <?php if($extra_tab_options['JetMapImplementation'] == '101' ) { echo 'selected';} ?> >no restrictions on product based pricing</option>
			        	<option value="102" <?php if($extra_tab_options['JetMapImplementation'] == '102' ) { echo 'selected';} ?> >Jet member savings on product only visible to logged in Jet members</option>
			        	<option value="103" <?php if($extra_tab_options['JetMapImplementation'] == '103' ) { echo 'selected';} ?> >Jet member savings never applied to product</option>
			        </select>
		        </p>

		        <p class="form-field">
		           <label class="jet-field-labels">Manufacturer Suggested Retail Price</label>
			        <input type="text" step="0.01" size="5" class="jet-text-fields" name="JetMSRP" value="<?php echo @$extra_tab_options['JetMSRP']; ?>" placeholder="MSRP" />
		        </p>

	        	<p class="form-field">
	        		<label class="jet-field-labels">Brand</label>
	        		<input type="text" class="jet-text-fields" name="JetProductBrand" value="<?php echo @$extra_tab_options['JetProductBrand']; ?>" placeholder="Product Brand" />
	        	</p>


			    <p class="form-field">
		            <label class="jet-field-labels">Country Manufacturer</label>
			        <input type="text"  class="jet-text-fields" name="JetCountry" value="<?php echo @$extra_tab_options['JetCountry']; ?>" placeholder="Country Manufacturer" />
		        </p>

			    <p class="form-field">
		            <label class="jet-field-labels">Product Manufacturer</label>
			        <input type="text"  class="jet-text-fields" name="JetProductManufacturer" value="<?php echo @$extra_tab_options['JetProductManufacturer']; ?>" placeholder="Product Manufacturer" />
		        </p>

		        <p class="form-field">
		            <label class="jet-field-labels">MFR Part Number</label>
			        <input type="text" class="jet-text-fields" name="JetMFR" value="<?php echo @$extra_tab_options['JetMFR']; ?>" placeholder="MFR Part Number" />
		        </p>

		         <p class="form-field dimensions_field">
					<label class="jet-field-labels">Package (inches)</label>
					<span class="wrap">
						<input type="text" value="<?php echo @$extra_tab_options['JetPackageLength']; ?>" name="JetPackageLength" size="6" class="input-text wc_input_decimal" placeholder="Length">
						<input type="text" value="<?php echo @$extra_tab_options['JetPackageWidth']; ?>" name="JetPackageWidth" size="6" class="input-text wc_input_decimal" placeholder="Width">
						<input type="text" value="<?php echo @$extra_tab_options['JetPackageHeight']; ?>" name="JetPackageHeight" size="6" class="input-text wc_input_decimal" placeholder="Height">
					</span>
				</p>

				
		        <p class="form-field">
		        	<label class="jet-field-labels">Product Tax Code</label>
		         	<?php $taxcode = array('Generic Taxable Product','Toilet Paper', 'Thermometers','Sweatbands','SPF Suncare Products', 'Sparkling Water','Smoking Cessation','Shoe Insoles','Safety Clothing','Pet Foods','Paper Products',  'OTC Pet Meds','OTC Medication','Oral Care Products','Non-Motorized Boats','Non Taxable Product','Mobility Equipment','Medicated Personal Care Items','Infant Clothing','Helmets','Handkerchiefs','General Grocery Items','General Clothing','Fluoride Toothpaste','Feminine Hygiene Products','Durable Medical Equipment','Drinks under 50 Percent Juice','Disposable Wipes','Disposable Infant Diapers','Dietary Supplements','Diabetic Supplies','Costumes','Contraceptives','Contact Lens Solution', 'Carbonated Soft Drinks','Car Seats','Candy with Flour','Candy','Breast Pumps','Braces and Supports','Bottled Water Plain','Beverages with 51 to 99 Percent Juice','Bathing Suits','Bandages and First Aid Kits','Baby Supplies','Athletic Clothing','Adult Diapers');?>

                   <select name="JetProductTaxCode" class="jet-select-fields"> 
	                   <?php foreach($taxcode as $key => $val){?>                  		
	               		    <?php if($extra_tab_options['JetProductTaxCode'] === $val ){?>
		           				<option value="<?php echo $val;?>" selected="selected"><?php echo $val; ?></option>
		           			<?php }else{?>
		           				<option value="<?php echo $val;?>" ><?php echo $val; ?></option>
		           			<?php }?>
	           			<?php }?>
                   </select>
                </p>

                <p class="form-field">
		           <label class="jet-field-labels">Safety Warning</label>
			        <input type="text" class="jet-text-fields"  name="JetSafetyWarning" value="<?php echo @$extra_tab_options['JetSafetyWarning']; ?>" placeholder="Safety Warning" />
		        </p>

		        <p class="form-field">
		           <label class="jet-field-labels">Legal Disclaimer</label>
			       <input type="text"  class="jet-text-fields" name="JetLegalDisc" value="<?php echo @$extra_tab_options['JetLegalDisc']; ?>" placeholder="Legal Disclaimer" />
		        </p>

		        <p class="form-field">
	                <label class="jet-field-labels">PROP 65</label>
		            <?php $prop = array("false","true");?>
		            <select name="JetProp65" class="select sort">
		           		<?php foreach($prop as $key => $val){?>
		           			<?php if($extra_tab_options['JetProp65'] === $val ){?>
		           				<option value="<?php echo $val;?>" selected="selected"><?php echo $val; ?></option>
		           			<?php }else{?>
		           				<option value="<?php echo $val;?>" ><?php echo $val; ?></option>
		           			<?php }?>
		           		<?php }?>		           
		       		</select>		           
	            </p>

	            <?php
	            $JetBullets = json_decode($extra_tab_options['JetBullets']);
				$cpsia = json_decode($extra_tab_options['JetCpsiaCautionaryStatements']);
				?>

	            <p class="form-field">
	           		<label class="jet-field-labels">Bullets:</label>           		
	           		<input type="text"  name="JetBullets[]"  class="jet-text-fields bullet_field1" value="<?php echo @$JetBullets[0]; ?>" placeholder="bullet1" />
	           		<input type="text"  name="JetBullets[]"  class="jet-text-fields bullet_field2" value="<?php echo @$JetBullets[1]; ?>" placeholder="bullet2" />
	           		<input type="text"  name="JetBullets[]"  class="jet-text-fields bullet_field3" value="<?php echo @$JetBullets[2]; ?>" placeholder="bullet3" />
	           		<input type="text"  name="JetBullets[]"  class="jet-text-fields bullet_field4" value="<?php echo @$JetBullets[3]; ?>" placeholder="bullet4" />
	           		<input type="text"  name="JetBullets[]"  class="jet-text-fields bullet_field5" value="<?php echo @$JetBullets[4]; ?>" placeholder="bullet5" />
	        	</p>

	        	<p class="form-field">
	        		<label class="jet-field-labels">CPSIA CAUTIONARY STATEMENTS</label>

	            <select name="JetCpsiaCautionaryStatements[]"  class="jet-select-fields" multiple> 
                  <?php 
                    $cpsia_statement = array('choking hazard small parts','choking hazard is a small ball','choking hazard is a marble', 'choking hazard contains a small ball', 'choking hazard contains a marble', 'choking hazard balloon');	 
                    foreach($cpsia_statement as $key => $val) { 
                    ?>
                    <option value="<?php echo $val;?>" <?php if( (!empty($cpsia)) && (in_array($val,$cpsia)) ) { echo 'selected';} ?> >
	           			<?php echo $val; ?></option>
                    <?php
                    }
                   ?>
                </select>

		        </p>

	    	</div>
	    </div>

	<?php
	}

	public function nuevejet_WooProcessProductMeta($post_id) {

		update_post_meta($post_id, 'JetParentSKU', sanitize_text_field( esc_attr($_POST['JetParentSKU']) ) );
		update_post_meta($post_id, 'JetStandardProductCodeType',sanitize_text_field( esc_attr($_POST['JetStandardProductCodeType']) ) );
		update_post_meta($post_id,  'JetStandardProductCode', sanitize_text_field( esc_attr($_POST['JetStandardProductCode']) ) );
		update_post_meta($post_id, 'Jet_PriceSelect', sanitize_text_field( esc_attr($_POST['Jet_PriceSelect']) ) );

		$jet_price = (float)$_POST['Jet_Price'];
		$jet_stock = (int)$_POST['Jet_Stock'];

		update_post_meta($post_id, 'Jet_Price', sanitize_text_field( esc_attr($jet_price) ) );
		update_post_meta($post_id, 'Jet_StockSelect', sanitize_text_field( esc_attr($_POST['Jet_StockSelect']) ) );
		update_post_meta($post_id, 'Jet_Stock', sanitize_text_field( esc_attr($jet_stock) ) );		

		if(isset($_POST['JetSelectedCatAttr'])) {
			update_post_meta($post_id,'JetSelectedCatAttr',sanitize_text_field(
				esc_attr($_POST['JetSelectedCatAttr']) ) );
	    }

		$productCats 			= 	get_the_terms($post_id, "product_cat");
		$mappedIDs				=	get_option('NueveWooJetMapping',true);

		if(is_array($mappedIDs)) {			 
			$catArray	=	array();
			foreach($mappedIDs as $woocatid => $jetcatId){		
				$catArray[]	=	$woocatid;
			}
			 
			if(!empty($catArray) && is_array($catArray)) {				 
				$jetSelectedNodeID = array();
				foreach ($productCats as $index	=>	$catObject) {						
					if(in_array($catObject->term_id, $catArray)) {						 
						$jetSelectedNodeID[$catObject->term_id]	=	$mappedIDs[$catObject->term_id];
					}
				}
			}
		}
		 
		$jetAttrInfo	=	array();

		foreach($jetSelectedNodeID as $wooNodeID => $jetNodeID){
		
			$mappedAttributes		=	get_option($jetNodeID.'_NueveJetAttributes',false);
				
			if($mappedAttributes){
		
				$mappedAttributes	=	json_decode($mappedAttributes);
				if(is_array($mappedAttributes)){
		
					$jetAttrInfo[$jetNodeID]	=	@admin::nuevejet_getattrdetails($mappedAttributes);
				}
			}
		}

		foreach($jetAttrInfo as $jetNode => $mappedCAT) {
			foreach($mappedCAT as $attrARRAY) {
				$attrObject = $attrARRAY[0];
				$tempName	=	$jetNode."_".$attrObject->jet_attr_id;

				update_post_meta($post_id, 	$tempName, sanitize_text_field( esc_attr($_POST[$tempName]) ) );

				/*if($attrObject->freetext == 2 || ($attrObject->freetext == 0 && !empty($attrObject->unit)) ){
					update_post_meta($post_id, 	$tempName, 	sanitize_text_field($_POST[$tempName]) );
					update_post_meta($post_id, 	$tempName.'_unit', 	sanitize_text_field($_POST[$tempName.'_unit']) );
				}
				else if($attrObject->freetext == 1) {					
					update_post_meta($post_id, 	$tempName, sanitize_text_field($_POST[$tempName]) );
				}else{
					update_post_meta($post_id, 	$tempName, sanitize_text_field($_POST[$tempName]) );
				}*/
			}
		}
	

		update_post_meta($post_id,  'JetMultiPackQuantity', sanitize_text_field( esc_attr($_POST['JetMultiPackQuantity']) ) );
		update_post_meta($post_id,  'JetMapPrice', sanitize_text_field( esc_attr($_POST['JetMapPrice']) ) );
		update_post_meta($post_id,  'JetMapImplementation', sanitize_text_field( esc_attr($_POST['JetMapImplementation']) ) );
		update_post_meta($post_id,  'JetMSRP', sanitize_text_field( esc_attr($_POST['JetMSRP']) ) );
		update_post_meta($post_id,  'JetProductBrand', sanitize_text_field( esc_attr($_POST['JetProductBrand']) ) );

		update_post_meta($post_id,  'JetCountry', sanitize_text_field( esc_attr($_POST['JetCountry']) ) );
		update_post_meta($post_id,  'JetProductManufacturer', sanitize_text_field( esc_attr($_POST['JetProductManufacturer']) ) );
		update_post_meta($post_id,  'JetMFR', sanitize_text_field( esc_attr($_POST['JetMFR']) ) );

		update_post_meta($post_id, 'JetPackageLength', sanitize_text_field( esc_attr($_POST['JetPackageLength']) ) );
		update_post_meta($post_id,  'JetPackageWidth', sanitize_text_field( esc_attr($_POST['JetPackageWidth']) ) );
		update_post_meta($post_id,  'JetPackageHeight', sanitize_text_field( esc_attr($_POST['JetPackageHeight']) ) );

		update_post_meta($post_id,  'JetProductTaxCode', sanitize_text_field( esc_attr($_POST['JetProductTaxCode']) ) );
		update_post_meta($post_id,  'JetSafetyWarning',  sanitize_text_field( esc_attr($_POST['JetSafetyWarning']) ) );		
		update_post_meta($post_id, 'JetLegalDisc', sanitize_text_field( esc_attr($_POST['JetLegalDisc']) ) );
		update_post_meta($post_id, 'JetProp65', sanitize_text_field( esc_attr($_POST['JetProp65']) ) );

		
		$JetBullets = array();
		if(count($_POST['JetBullets']) > 0) {
			$JetBullets =  $_POST['JetBullets'];
		}

		update_post_meta($post_id, 'JetBullets', json_encode( $JetBullets ) );

		$cpsia = array();
		if(count($_POST['JetCpsiaCautionaryStatements']) > 0) {
			$cpsia =  $_POST['JetCpsiaCautionaryStatements'];
		}

		update_post_meta( $post_id, 'JetCpsiaCautionaryStatements', json_encode( $cpsia ) );
	}

	public function nuevejet_variation_settings() {
		
		echo '<div id="jet_attribute_settings" class="panel woocommerce_options_panel">
			hello
		</div>';	
	}
	

	public function nuevejet_save_variation_settings($post_id) 	{

		echo 'post:'.$post_id;

		exit;
	}


	public function nuevejet_get_woo_products_list() {
		
		if(check_admin_referer('jet_get_woo_products_nonce_check','jet_get_woo_products_secure_key')) {	

			$result = array();
			
			$mappedCategories	=	get_option('NueveWooJetMapping',false);
			if(!empty($mappedCategories)) {
				$all_woo_cat	=	array();
				foreach($mappedCategories as $mappedwoocat	=> $mappedjetcat){		
					$all_woo_cat[]	=	$mappedwoocat;		
				}
			}

			if(count($all_woo_cat) > 0) {
				global $wpdb;

				$args = array(
					'post_type' => array('product'),
					'post_status' => 'publish',
					'tax_query' => array(
						array(
							'taxonomy'      => 'product_cat',
							'field' 		=> 'term_id',
							'terms'         => $all_woo_cat,
							'operator'      => 'IN'
						)
					)
				);

				$loop = new WP_Query($args);

				if( $loop->have_posts() ) {
					while ( $loop->have_posts() ) {
						$loop->the_post(); 
						$_product = get_product($loop->post->ID);
						
						if( empty($_product->is_downloadable('yes')) && ($_product->product_type == 'simple')  ) {
							
							$product_id = $_product->id;
							$product_image = $_product->get_image(array(100,70));
							$product_sku = $_product->get_sku();
							$parent_sku = get_post_meta($product_id,'JetParentSKU',true); 
							$product_title = $_product->get_title();
							$product_price = @admin::PriceDetails($_product);
							$product_stock = @admin::StockDetails($_product);

							$category = get_the_terms($product_id, "product_cat");		

							if($category) {
								$categories = '';
								foreach ($category as $term){
									$categories .= $term->name.',';
								}
								$categories = rtrim($categories,',');
							}

							$product_category = $categories;

							$pdt_status = get_post_meta($product_id,'JetProductStatus',true);

							if(!empty($pdt_status))	{ 
								$product_status = $pdt_status;
							} else {
								$product_status = 'Not Uploaded';
							}

							$product_details_link = admin_url('/post.php?post=').$product_id.'&action=edit';

							$result[] = array('product_id'=>$product_id,'product_image'=>$product_image,'product_sku'=>$product_sku,'parent_sku'=>$parent_sku,'product_title'=>$product_title,'product_price'=>$product_price,'product_stock'=>$product_stock,'product_category'=>$product_category,'product_status'=>$product_status, 'product_details_link'=>$product_details_link);	
						}
					}
				}
			}

			echo json_encode($result);
			exit;
		}
	}


	public function nuevejet_oupload_product() {
		
		if(check_admin_referer('jet_oupload_products_nonce_check','jet_oupload_products_secure_key')){
		
			$validate = @admin::nuevejet_validateUserData();

			if($validate) {
				if(isset( $_POST['upload_type'] ) ) {
					$upload_type =   sanitize_text_field( esc_attr($_POST['upload_type']));		
					$selectedProductIDs	=  $_POST['all_product_ids'];
					if(count($selectedProductIDs)	==	0) 	{
						echo "Please Select product\'s to perform Action.";
						exit;
					} else {
						$productIdsChunks	= (array_chunk($selectedProductIDs,30));

						if($upload_type	==	'archive'){				
							$this->nuevejet_oarchiveAction($productIdsChunks);
						} else if($upload_type	==	'unarchive'){				
							$this->nuevejet_ounarchiveAction($productIdsChunks);
						}
					}
				}
			} else {
				echo 'Please add all the Jet Configuration details';
				exit;
			}
		}
	}



	public function nuevejet_product_update_price() {
		if(check_admin_referer('jet_pdt_price_update_nonce_check','jet_pdt_price_update_secure_key')){
			$sku = $_POST['psku'];
			$woo_id = $_POST['wooproductid'];
			$price = $_POST['price'];

			$checking = 'yes';
			if($woo_id!='') {
				$productDetails	=	@admin::fetchProductDetail($woo_id);
				if($productDetails['type'] != 'simple') {
					$checking = 'no';
				}
			}

			if($checking == 'yes') {

				$get_response  	= 	@admin::nuevejet_getrequest('/merchant-skus/'.$sku);

				if( ($get_response != INVALID_LOGIN) && ($get_response != API_ERROR) ) {
					$update = @admin::nuevejet_update_price($sku, $price);				
					if($update == "success") {
						if($woo_id!='') {	
							$this->nuevejet_PriceChange($woo_id,$price);
						}					
					}
					echo $update;
					exit;					
				} else {
					echo $get_response;
					exit;
				}
			}

			exit;
		}
	}

	public function nuevejet_product_update_inventory() {
		if(check_admin_referer('jet_pdt_inventory_update_nonce_check','jet_pdt_inventory_update_secure_key')){

			$sku = $_POST['psku'];
			$woo_id = $_POST['wooproductid'];
			$inventory = $_POST['inventory'];

			$checking = 'yes';
			if($woo_id!='') {
				$productDetails	=	@admin::fetchProductDetail($woo_id);
				if($productDetails['type'] != 'simple') {
					$checking = 'no';
				}
			}

			if($checking == 'yes') {

				$get_response  	= 	@admin::nuevejet_getrequest('/merchant-skus/'.$sku);

				if( ($get_response != INVALID_LOGIN) && ($get_response != API_ERROR) ) {
					$update = @admin::nuevejet_update_inventory($sku, $inventory);	

					if($update == "success") {

						if($woo_id!='') {	
							$this->nuevejet_InventoryChange($woo_id,$inventory);	
						}						
					}
					echo $update;
					exit;					
				} else {
					echo $get_response;
					exit;
				}
			}

			exit;
		}
	}
		
	public function nuevejet_oarchiveAction($productIdsChunks){
		
		$ids = $productIdsChunks[0];
		
		if(!is_array($ids) && $ids!='')	{
			$ids=array($ids);
		}
		
		if(!is_array($ids)) {
			echo 'Please select product id(es)';
			exit;
		} else	{

			$cArchived=0; $cClosed=0;

			foreach ($ids as $id) {

				$pids = explode('/',$id);

				$sku = $pids[0];
				$woo_id = $pids[1];

				$checking = 'yes';
				if($woo_id!='') {
					$productDetails	=	@admin::fetchProductDetail($woo_id);
					if($productDetails['type'] != 'simple') {
						$checking = 'no';
					}
				}

				if($checking == 'yes') {

					$get_response  	= 	@admin::nuevejet_getrequest('/merchant-skus/'.$sku);

					if( ($get_response != INVALID_LOGIN) && ($get_response != API_ERROR) ) {
						$get_result = json_decode($get_response);		
						$inventory = 0;
						if($get_result->is_archived) {
							$cArchived++;
							if($woo_id!='') {	
								$this->nuevejet_InventoryChange($woo_id,$inventory);
								update_post_meta($woo_id,'JetProductStatus','Archived');
							}										
						} 	else {
							$cClosed++;
							$archive_type = 'archive'; 	
							$archive_response = @admin::ChangeProductStatus($sku,$archive_type);
							if($archive_response == 'success') {
								if($woo_id!='') {	
									$this->nuevejet_InventoryChange($woo_id,$inventory);
									update_post_meta($woo_id,'JetProductStatus','Archived');
								}
							} else {
								echo $archive_response;
								exit;
							}
						}
					} else {
						echo $get_response;
						exit;
					}
				}				
			}

			if($cClosed > 0 || $cArchived > 0) {

				if($cClosed>0){						
					echo $cClosed.' product(s) is archived successfully';
					exit;	
				}

				if($cArchived>0) {						
					echo $cArchived.' product(s) is already archived';
					exit;
				}
			} else {					
				echo 'product(s) can not be archived';
				exit;				
			}
		}
	}

	public function nuevejet_ounarchiveAction($productIdsChunks) {

				
		$ids = $productIdsChunks[0];
		
		if(!is_array($ids) && $ids!='')	{
			$ids=array($ids);
		}
		
		if(!is_array($ids))	{
			echo  'Please select product id(es)';
			exit;
		} else	{

			$cunArchived=0;
			
			foreach ($ids as $id) 		{

				$pids = explode('/',$id);

				$sku = $pids[0];
				$woo_id = $pids[1];
				$checking = 'yes';
				if($woo_id!='') {
					$productDetails	=	@admin::fetchProductDetail($woo_id);
					if($productDetails['type'] != 'simple') {
						$checking = 'no';
					}
				}
				
				if($checking == 'yes') {

					$cunArchived++;
					$archive_type = 'unarchive'; 
					$inventory = 0;
					$unarchive_response = @admin::ChangeProductStatus($sku,$archive_type);
				
					if($unarchive_response == 'success') {
						if($woo_id!='') {								
							$this->nuevejet_InventoryChange($woo_id,$inventory);
							$this->nuevejet_UpdateSingleSkuStatus($woo_id);
						}						
					} else {
						echo $unarchive_response;
						exit;							
					}
				}
			}

			if($cunArchived>0) 	{
				echo $cunArchived.' product(s) is unarchived successfully';
				exit;
			} else	{
				echo 'product(s) can not unarchive';
				exit;
			}		
		}
	}

	
	public function nuevejet_upload_product() {
		
		if(check_admin_referer('jet_upload_products_nonce_check','jet_upload_products_secure_key')){
		
			$validate = @admin::nuevejet_validateUserData();

			if($validate) {
				if(isset( $_POST['upload_type'] ) ) {
					$upload_type =   sanitize_text_field( esc_attr($_POST['upload_type']));		
					$selectedProductIDs	=  $_POST['all_product_ids'];
					if(count($selectedProductIDs)	==	0) 	{
						echo "Please Select product\'s to perform Action.";
						exit;
					} else {
						$productIdsChunks	= (array_chunk($selectedProductIDs,30));
						if($upload_type	== 'upload') {					
							$this->nuevejet_uploadAction($productIdsChunks);
						} else if($upload_type	==	'archive'){				
							$this->nuevejet_archiveAction($productIdsChunks);
						} else if($upload_type	==	'unarchive'){				
							$this->nuevejet_unarchiveAction($productIdsChunks);
						}
					}
				}
			} else {
				echo 'Please add all the Jet Configuration details';
				exit;
			}
		}
	}

	public function nuevejet_archiveAction($productIdsChunks){
		
		$ids = $productIdsChunks[0];
		
		if(!is_array($ids) && $ids!='')	{
			$ids=array($ids);
		}
		
		if(!is_array($ids)) {
			echo 'Please select product id(es)';
			exit;
		} else	{

			$cArchived=0;$cClosed=0;

			foreach ($ids as $id) {
				$productDetails	=	@admin::fetchProductDetail($id);

				//echo json_encode($productDetails).'<br/>';
								
				if($productDetails['type'] == 'simple') {
					$sku =	$productDetails['JetSKU'];

					//echo $sku.'<br/>';

					$get_response  	= 	@admin::nuevejet_getrequest('/merchant-skus/'.$sku);

					//echo $get_response.'<br/>';

					if( ($get_response != INVALID_LOGIN) && ($get_response != API_ERROR) ) {
						$get_result = json_decode($get_response);		
						$inventory = 0;

						//echo $id.'<br/>';
						if($get_result->is_archived) {
							$cArchived++;
							$this->nuevejet_InventoryChange($id,$inventory);
							update_post_meta($id,'JetProductStatus','Archived');
							//echo 'archiveds'.'<br>';										
						} 	else {
							$cClosed++;
							$archive_type = 'archive'; 	
							$archive_response = @admin::ChangeProductStatus($sku,$archive_type);
							//echo $archive_response.'<br/>';
							if($archive_response == 'success') {
								//echo 'suc1'.'<br/>';
								update_post_meta($id,'JetProductStatus','Archived');
								$this->nuevejet_InventoryChange($id,$inventory);
								//echo 'suc2'.'<br/>';
							} else {
								//echo $archive_response;
								exit;
							}
						}
					} else {
						echo $get_response;
						exit;
					}
				}

				//sleep(5);
			}


			if($cClosed > 0 || $cArchived > 0) {

				if($cClosed>0){						
					echo $cClosed.' product(s) is archived successfully';
					exit;	
				}

				if($cArchived>0) {						
					echo $cArchived.' product(s) is already archived';
					exit;
				}
			} else {					
				echo 'product(s) can not be archived';
				exit;				
			}
		}
	}

	public function nuevejet_unarchiveAction($productIdsChunks) {
			
		$ids = $productIdsChunks[0];
		
		if(!is_array($ids) && $ids!='')	{
			$ids=array($ids);
		}
		
		if(!is_array($ids))	{
			echo  'Please select product id(es)';
			exit;
		} else	{

			$cunArchived=0;
			
			foreach ($ids as $id) 		{
				$productDetails	=	@admin::fetchProductDetail($id);
				
				if($productDetails['type'] == 'simple') {

					$cunArchived++;
					$sku =	$productDetails['JetSKU'];
					$archive_type = 'unarchive'; 
					$inventory = 0;

					//echo $sku.'<br/>';
					$unarchive_response = @admin::ChangeProductStatus($sku,$archive_type);

					//echo $unarchive_response.'<br/>';
				
					if($unarchive_response == 'success') {		
					  // echo 'suc1<br/>';					
						$this->nuevejet_InventoryChange($id,$inventory);
						//echo 'suc2<br/>';
						$this->nuevejet_UpdateSingleSkuStatus($id);
						//echo 'suc3<br/>';
					} else {
						echo $unarchive_response;
						exit;							
					}
				}
			}

			if($cunArchived>0) 	{
				echo $cunArchived.' product(s) is unarchived successfully';
				exit;
			} else	{
				echo 'product(s) can not unarchive';
				exit;
			}			
		}	
	}

	public function nuevejet_InventoryChange($id,$inventory) {
		$stocktype  = get_post_meta($id,'Jet_StockSelect',true);		
		if(empty($stocktype))
			$stocktype = 'central';

		$stocktype	= trim($stocktype);

		$inventory = (int)$inventory;
		if($stocktype == 'central')
			update_post_meta($id,'_stock',$inventory);
				
		if($stocktype == 'other')
			update_post_meta($id,'Jet_Stock',$inventory);

		//echo 'stocktype:'.$stocktype;
	}

	public function nuevejet_PriceChange($id,$price) {
		$stocktype  = get_post_meta($id,'Jet_PriceSelect',true);		
		if(empty($stocktype))
			$stocktype = 'main_price';

		$stocktype	= trim($stocktype);

		$price = (float)$price;

		if($stocktype == 'main_price')
			update_post_meta($id,'_regular_price',$price);

		if($stocktype == 'sale_price')
			update_post_meta($id,'_sale_price',$price);
				
		if($stocktype == 'otherPrice')
			update_post_meta($id,'Jet_Price',$price);
	}

	public function nuevejet_uploadAction($productIdsChunks) {
		$counter = 0;
		$wpuploadDir	=	wp_upload_dir();
		$baseDir		=	$wpuploadDir['basedir'];
		$uploadDir		=	$baseDir . '/jet_uploads';

		if (! is_dir($uploadDir)) {
			mkdir( $uploadDir, 0777 ,true);
		}

		$skuArray		=	array();
		$priceArray		=	array();
		$inventArray	=	array();
		$productArray = array();
		$noticeArray = array();

		$commaseperatedids = '';
		foreach($productIdsChunks as  $productIDs) 	{
			$this->commaseperatedids = implode(",", $productIDs);

			foreach($productIDs as $pid) {
				$productDetails	=	@admin::fetchProductDetail($pid);
				if($productDetails['type']	==	'simple') {
					$productFiles	=	array();
					$productFiles	=	@admin::create_file_formatted_array($productDetails);

					if( isset($productFiles['product_data']) ) {
						$productArray[]		=	$productFiles['product_data'];	
						$skuArray[]			=	$productFiles['sku'];						
						$priceArray[]		=	$productFiles['price'];
						$inventArray[]		=	$productFiles['inventory'];
					} else {
						$noticeArray[] = $productFiles;
					}
				}
			}
		}
		

		if(count($noticeArray) > 0) {
			echo json_encode($noticeArray);
		} else {
			$finalskuarray	=	array();
			foreach($skuArray as $tmpindx => $skuval) {
				foreach($skuval as $tmpskuid	=>	$all_data_value) {
					$finalskuarray[$tmpskuid]	=	$all_data_value;
				}
			}
			
			$finalpricearray	=	array();
			foreach($priceArray as $tmppriceindx => $priceval) {
				foreach($priceval as $tmppriceid	=>	$all_price_data_value) 	{ 
					$finalpricearray[$tmppriceid]	=	$all_price_data_value;
				}
			}
			
			$finalinventarray	=	array();
			foreach($inventArray as $tmpinvntindx => $invntval) {
				foreach($invntval as $tmpinvntid	=>	$all_invent_data_value) {
					$finalinventarray[$tmpinvntid]	=	$all_invent_data_value;
				}
			}

			$upload_file = false;
			$t=time();

			if(!empty($finalskuarray) && count($finalskuarray)>0) {
				$finalskujson		= 	json_encode($finalskuarray);
				$file_path 			= 	$uploadDir . '/skus'.$t.".json";
				$file_type 			= 	"MerchantSKUs";
				$file_name			=	"skus".$t.".json";
				$myfile 			= 	fopen($file_path, "w") ;

				fwrite($myfile, $finalskujson);
				fclose($myfile);
				if(fopen($file_path.".gz","r") == false) {
					@admin::gzCompressFile($file_path,9);
					$upload_file = true;
				}
			}
			
			if(!empty($finalpricearray) && count($finalpricearray)>0) {
				
				$finalpricejson		= 	json_encode($finalpricearray);
				$file_path1			= 	$uploadDir . '/prices'.$t.".json";
				$file_type1			=	"Price";
				$file_name1			=	"prices".$t.".json";
				$myfile1 			= 	fopen($file_path1, "w") ;

				fwrite($myfile1, $finalpricejson);
				fclose($myfile1);
				if(fopen($file_path1.".gz","r") == false) {
					@admin::gzCompressFile($file_path1,9);
				}
			}
			
			if(!empty($finalinventarray) && count($finalinventarray)>0) {
				$finalinventoryjson		=	json_encode($finalinventarray);
				$file_path2 			= 	$uploadDir . '/inventrys'.$t.".json";
				$file_type2				=	"Inventory";
				$file_name2				=	"inventrys".$t.".json";
				$myfile2 				= 	fopen($file_path2, "w") ;

				fwrite($myfile2, $finalinventoryjson);
				fclose($myfile2);
				if(fopen($file_path2.".gz","r") == false){
					@admin::gzCompressFile($file_path2,9);
				}
			}
			
			if($upload_file==false) {
				echo 'Product information was incomplete so they are not prepared for upload';  
			} else {
				$compressed_file_path 	=	$file_path.".gz";
				$compressed_file_path1 	=	$file_path1.".gz";
				$compressed_file_path2 	=	$file_path2.".gz";

				if(fopen($compressed_file_path,"r")!=false) {
					$sku_status = $this->nuevejet_UploadSkuFile($compressed_file_path,$file_name,$file_type);
					if($sku_status == 'Acknowledged'){
						$product_status = $this->nuevejet_after_sku_status_acknowledge();
						echo $product_status.'<br/>';
						if($product_status == 'Acknowledged' || $product_status == 'Processing' || $product_status  == 'Processed successfully') {
							echo 'haixdvgf'.'<br/>';
							if(fopen($compressed_file_path1,"r")!=false) {
								$price_status = $this->nuevejet_UploadPriceFile($compressed_file_path1,$file_name1,$file_type1);
								if($price_status == 'Acknowledged'){
									$product_price_status = $this->nuevejet_after_price_status_acknowledge();
									//echo $product_price_status.'<br/>';
									//exit;
									if($product_price_status == 'Acknowledged' || $product_price_status == 'Processing' || $product_price_status  == 'Processed successfully') {

										if(fopen($compressed_file_path2,"r")!=false){
											$inventory_status = $this->nuevejet_UploadInventoryFile($compressed_file_path2,$file_name2,$file_type2);
											echo $inventory_status.'<br/>';
											if($inventory_status == 'Acknowledged') {
												$product_inventory_status = $this->nuevejet_after_inventory_status_acknowlegde();
												echo $product_inventory_status.'<br/>';
												if($product_inventory_status == 'Acknowledged' || $product_inventory_status == 'Processing' || $product_inventory_status  == 'Processed successfully') {
													$product_details = json_encode($productArray);
													$jet_sku_upload = @admin::JetUploadSKUDetails($product_details);
													echo 'Uploaded Successfully';		
												} else {
													echo $product_inventory_status;
												}
											} else {
												echo $inventory_status;
											}										
										} 	
									} else {
										echo $product_price_status;
									}			
								} else {
									echo $price_status;
								}
							}
						} else {
							echo $product_status;
						}
					} else {
						echo $sku_status;
					}
				}
			}
		}
		exit;
	}

	
	public function nuevejet_UploadSkuFile($compressed_file_path,$file_name,$file_type) {
			
		$response = @admin::nuevejet_getrequest('/files/uploadToken');

		if( ($response != INVALID_LOGIN) && ($response != API_ERROR) ) {	
		
			$data 	  = json_decode($response);
			$fileid	  = $data->jet_file_id;
			$this->uploadfileid = $fileid; 
			$tokenurl =	$data->url;		
			$commaseperatedids = $this->commaseperatedids;		
					
			global $wpdb;

			$status = 'unprocessed';
			$table_name 	= 	@$wpdb->prefix.'jetfileinfo';
			
			@$wpdb->prepare(
				@$wpdb->insert(
					$table_name, 
					array( 
						'woocommerce_batch_info' => $commaseperatedids, 'jet_file_id' => $fileid, 'token_url' => $tokenurl, 'file_name' => $file_name, 'file_type' => $file_type, 'status' => $status
					),
					array('%s', '%s', '%s', '%s', '%s', '%s')
				)
			); 	
			
			$currentid = @$wpdb->insert_id;
			$this->currentid = $currentid;
			$upload_response = @admin::uploadFile($compressed_file_path,$data->url);
			$postFields='{"url":"'.$data->url.'","file_type":"'.$file_type.'","file_name":"'.$file_name.'"}';
			
			$file_upload_response = @admin::nuevejet_postrequest('/files/uploaded',$postFields);

			if( ($file_upload_response != INVALID_LOGIN) && ($file_upload_response != API_ERROR) ) {
				$uploadskudata  = json_decode($file_upload_response);
				return $uploadskudata->status;	
			} else {
				return $file_upload_response;
			}
		}  else {
			return $response;
		}		
	}
	

	public function nuevejet_UploadPriceFile($compressed_file_path1,$file_name1,$file_type1) {		
		$response 		= 	@admin::nuevejet_getrequest('/files/uploadToken');
		if( ($response != INVALID_LOGIN) && ($response != API_ERROR) ) {	
			$data 			= 	json_decode($response);
			$fileid			=	$data->jet_file_id;
			$this->uploadfileid = $fileid;
			$tokenurl		=	$data->url;
			$commaseperatedids = $this->commaseperatedids;
			
			$this->errorflag = 'false';
			
			global $wpdb;
			$status = 'unprocessed';
			$table_name 	= 	@$wpdb->prefix.'jetfileinfo';
			
			@$wpdb->prepare(
				@$wpdb->insert(
					$table_name, 
					array( 
						'woocommerce_batch_info' => $commaseperatedids, 'jet_file_id' => $fileid, 'token_url' => $tokenurl, 'file_name' => $file_name1, 'file_type' => $file_type1, 'status' => $status
					),
					array('%s', '%s', '%s', '%s', '%s', '%s')
				)
			); 	
			
			$currentid			= 	@$wpdb->insert_id;
			$this->currentid	= 	$currentid;
			
			$reponse 			= 	@admin::uploadFile($compressed_file_path1,$data->url);
			$postFields			=	'{"url":"'.$data->url.'","file_type":"'.$file_type1.'","file_name":"'.$file_name1.'"}';
			$responseprice 		= 	@admin::nuevejet_postrequest('/files/uploaded',$postFields);

			if( ($responseprice != INVALID_LOGIN) && ($responseprice != API_ERROR) ) {
				$pricedata  = json_decode($responseprice);
				return $pricedata->status;	
			} else {
				return $responseprice;
			}	
		} else {
			return $response;
		}
	}
	
	
	public function nuevejet_UploadInventoryFile($compressed_file_path2,$file_name2,$file_type2) {		
		$response 	= 	@admin::nuevejet_getrequest('/files/uploadToken');

		if( ($response != INVALID_LOGIN) && ($response != API_ERROR) ) {			
			$data  = json_decode($response);
			$fileid		=	$data->jet_file_id;
			$this->uploadfileid = $fileid;
			$tokenurl	=	$data->url;
			$commaseperatedids = $this->commaseperatedids;
			
			global $wpdb;
			$status 		= 	'unprocessed';
			$table_name 	= 	@$wpdb->prefix.'jetfileinfo';
			
			@$wpdb->prepare(
				@$wpdb->insert(
					$table_name, 
					array( 
						'woocommerce_batch_info' => $commaseperatedids, 'jet_file_id' => $fileid, 'token_url' => $tokenurl, 'file_name' => $file_name2, 'file_type' => $file_type2, 'status' => $status
					),
					array('%s', '%s', '%s', '%s', '%s', '%s')
				)
			); 		
			
			$currentid			= 	@$wpdb->insert_id;
			$this->currentid	= 	$currentid;
			$reponse			= 	@admin::uploadFile($compressed_file_path2,$data->url);
			$postFields			=	'{"url":"'.$data->url.'","file_type":"'.$file_type2.'","file_name":"'.$file_name2.'"}';
			$responseinventry 	= 	@admin::nuevejet_postrequest('/files/uploaded',$postFields);
			
			if( ($responseinventry != INVALID_LOGIN) && ($responseinventry != API_ERROR) ) {
				$invetrydata  = json_decode($responseinventry);
				return $invetrydata->status;	
			} else {
				return $responseinventry;
			}
		} else {
			return $response;
		}
	}
	

	public function nuevejet_after_sku_status_acknowledge() {

		$this->errorflag = 'true';
		$status = 'Acknowledged';
		$currentid = $this->currentid;
		global $wpdb;
		$table_name = @$wpdb->prefix.'jetfileinfo';
		$qry = "UPDATE `$table_name` SET `status`= '$status' WHERE id = '$currentid';";
		@$wpdb->query( @$wpdb->prepare( $qry ) );
		
		$fileid 	=	$this->uploadfileid;
		$jdata['jet_file_id'] = $fileid;
		$responsesku = @admin::nuevejet_getrequest('/files/'.$jdata['jet_file_id']);
		if( ($responsesku != INVALID_LOGIN) && ($responsesku != API_ERROR) ) {
			$resvaluesku = json_decode($responsesku);		
			if(isset($resvaluesku->error_excerpt) || ($resvaluesku->status == 'Processed with errors') ) 	{
				$jetfileid = $resvaluesku->jet_file_id;
				$jetfilename = $resvaluesku->file_name;
				$jetfiletype = $resvaluesku->file_type;
				$jetfilestatus = $resvaluesku->status;
				$errorexcerpt = $resvaluesku->error_excerpt;

				if(is_array($errorexcerpt))	{
					foreach($errorexcerpt as $array_index=>$error_reason) {
						$error_reasons[] = $error_reason;
					}
				}
				
				$jetfileerror = addslashes(json_encode($error_reasons));

				global $wpdb;
				$table_name = @$wpdb->prefix.'jeterrorfileinfo';

				@$wpdb->prepare(
					@$wpdb->insert(
						$table_name, 
						array( 
							'jet_file_id' => $jetfileid, 'file_name' => $jetfilename,'file_type' => $jetfiletype, 'status' => $jetfilestatus, 'error' => $jetfileerror
						),
						array('%s', '%s', '%s', '%s', '%s')
					)
				); 	
				
				$error_result = 'Error in Uploading SKU file, Please check and fix the issues';
				return $error_result;	
			} else {
				return $resvaluesku->status;
			}
		} else {
			return $responsesku;
		}
	}


	public function nuevejet_after_price_status_acknowledge() {
		
		$status 	= 	'Acknowledged';
		global $wpdb;
		$currentid		= 	$this->currentid;
		$table_name 	= 	@$wpdb->prefix.'jetfileinfo';
		$qry 			= 	"UPDATE `$table_name` SET `status`= '$status' WHERE id = '$currentid';";
		@$wpdb->query( @$wpdb->prepare( $qry ) );

		$fileid 				=	$this->uploadfileid;
		$jdata['jet_file_id'] 	= $fileid;
		$responseprices 			= @admin::nuevejet_getrequest('/files/'.$jdata['jet_file_id']);	
		if( ($responseprices != INVALID_LOGIN) && ($responseprices != API_ERROR) ) {
			$resvalueprices 			= json_decode($responseprices);		
			if(isset($resvalueprices->error_excerpt) || ($resvalueprices->status == 'Processed with errors') ) 	{		

				$jetfileid 		= 	$resvalueprices->jet_file_id;
				$jetfilename 	= 	$resvalueprices->file_name;
				$jetfiletype 	= 	$resvalueprices->file_type;
				$jetfilestatus 	= 	$resvalueprices->status;
				$errorexcerpt 	= 	$resvalueprices->error_excerpt;

				if(is_array($errorexcerpt)) {
					foreach($errorexcerpt as $array_index=>$error_reason) {
						$error_reasons[] = $error_reason;
					}
				}

				$jetfileerror = addslashes(json_encode($error_reasons));

				global $wpdb;
				$table_name 	= 	@$wpdb->prefix.'jeterrorfileinfo';
				
				@$wpdb->prepare(
					@$wpdb->insert(
						$table_name, 
						array( 
							'jet_file_id' => $jetfileid, 'file_name' => $jetfilename,'file_type' => $jetfiletype, 'status' => $jetfilestatus, 'error' => $jetfileerror
						),
						array('%s', '%s', '%s', '%s', '%s')
					)
				); 	
		
				$error_result = 'Error in Uploading Price file, Please check and fix the issues';
				return $error_result;	
			} else {
				return $resvalueprices->status;
			}	
		} else {
			return $responseprices;
		}	 	
	}
	

	public function nuevejet_after_inventory_status_acknowlegde() {

		$status 		= 	'Acknowledged';
		global $wpdb;
		$currentid   	= 	$this->currentid;
		$table_name 	= 	@$wpdb->prefix.'jetfileinfo';
		$qry 			= 	"UPDATE `$table_name` SET `status`= '$status' WHERE id = '$currentid';";
		@$wpdb->query( @$wpdb->prepare( $qry ) );

		$fileid 				=	$this->uploadfileid;
		$jdata['jet_file_id'] 	= 	$fileid;
		$responseinvent 		= 	@admin::nuevejet_getrequest('/files/'.$jdata['jet_file_id']);	
		if( ($responseprices != INVALID_LOGIN) && ($responseprices != API_ERROR) ) {
			$resvalueinvent 		= 	json_decode($responseinvent);
			if(isset($resvalueinvent->error_excerpt) || ($resvalueinvent->status == 'Processed with errors') ) {
				$jetfileid 		= 	$resvalueinvent->jet_file_id;
				$jetfilename 	= 	$resvalueinvent->file_name;
				$jetfiletype 	= 	$resvalueinvent->file_type;
				$jetfilestatus 	= 	$resvalueinvent->status;
				$errorexcerpt 	= $resvalueinvent->error_excerpt;
				if(is_array($errorexcerpt))	{
					foreach($errorexcerpt as $array_index=>$error_reason){
						$error_reasons[] = $error_reason;
					}
				}

				$jetfileerror = addslashes(json_encode($error_reasons));

				global $wpdb;
				$table_name 	= 	@$wpdb->prefix.'jeterrorfileinfo';
			
				@$wpdb->prepare(
					@$wpdb->insert(
						$table_name, 
						array( 
							'jet_file_id' => $jetfileid, 'file_name' => $jetfilename,'file_type' => $jetfiletype, 'status' => $jetfilestatus, 'error' => $jetfileerror
						),
						array('%s', '%s', '%s', '%s', '%s')
					)
				); 	

				$error_result = 'Error in Uploading Inventory file, Please check and fix the issues';
				return $error_result;	
			}	else {
				return $resvalueinvent->status;	
			}
		} else {
			return $responseprices;
		}	
	}

	public function nuevejet_update_product_status() {

		if(check_admin_referer('jet_product_status_nonce_check','jet_product_status_secure_key')){
		
			$map_ids = $this->nuevejet_get_mapped_products();

			$product_ids = is_array($map_ids) ? $map_ids : array();
			
			if(count($product_ids) > 100) {			
				$product_ids_array = array_chunk($product_ids,100);			
				foreach($product_ids_array as $productIDs){
					$this->nuevejet_updateSkuStatus($productIDs);
				}
			} else {			
				$this->nuevejet_updateSkuStatus($product_ids);
			}	
		}	
		exit;
	}

	
	public function nuevejet_updateSkuStatus($product_ids) {
		foreach($product_ids as $index=> $pid) {
			$this->nuevejet_UpdateSingleSkuStatus($pid);			
		}
	}

	public function nuevejet_UpdateSingleSkuStatus($pid) {

		if(WC()->version < "3.0.0") {
	 		$_product = get_product($pid);   	 		
   	 	} else  {
   	 		$_product = wc_get_product($pid);
   	 	}

		$sku = $_product->get_sku();	
	   	 	
   	 	if(!empty($sku)) {
   	 		$result	=	@admin::nuevejet_getrequest('/merchant-skus/'.$sku);
			
			if( ($result != INVALID_LOGIN) && ($result != API_ERROR)  ) {				
				$response=json_decode($result);
				if(!empty($response->status)) {
					$product_status = $response->status;
					@admin::UpdateProductStatus($sku,$product_status);				
					update_post_meta($pid,'JetProductStatus',$product_status);
				}else{
					update_post_meta($pid,'JetProductStatus','Not Uploaded');
				}
			}
   	 	}
	}

	public function nuevejet_get_mapped_products() {

		global $wpdb;

		$all_woo_cat = array();
		$product_ids = array();

		$mappedCategories = get_option('NueveWooJetMapping',false);
		if(!empty($mappedCategories)){
			foreach($mappedCategories as $mappedwoocat => $mappedjetcat) {
				$all_woo_cat[] = $mappedwoocat;
			}
		}
		
		if(count($all_woo_cat)) {
			$mapped_woo_cat = implode(',',$all_woo_cat);
			$query = 'SELECT '.@$wpdb->prefix.'posts.ID FROM '.@$wpdb->prefix.'posts INNER JOIN '.@$wpdb->prefix.'term_relationships ON ('.@$wpdb->prefix.'posts.ID = '.@$wpdb->prefix.'term_relationships.object_id) WHERE 1=1  AND (
				'.@$wpdb->prefix.'term_relationships.term_taxonomy_id IN ('.$mapped_woo_cat.')
				) AND '.@$wpdb->prefix.'posts.post_type = "product" AND ('.@$wpdb->prefix.'posts.post_status = "publish") GROUP BY '.@$wpdb->prefix.'posts.ID ORDER BY '.@$wpdb->prefix.'posts.post_date DESC';

				//echo $query;

			$result =  @$wpdb->get_results( @$wpdb->prepare( $query ) );

			$product_ids = array();
			if(!empty($result) && is_array($result)) {

				foreach($result as $key => $productID) {
					$pro_id 	=	$productID->ID;
					$_product 	= 	get_product($pro_id);
					if(!empty($_product) && $_product->is_type('variable')) {
						foreach($variations as $key => $variation)	{
							$product_ids[]   = $variation['variation_id'];
						}
					}elseif(!empty($_product) && $_product->is_type('simple')){
						$product_ids[] = $_product->id;
					}
				}
			}
		}

		return $product_ids;
		wp_die();
	}
	

	public function nuevejet_activation() {
		$this->nuevejet_createTables();
	}

	public function nuevejet_createTables() {		
		global $wpdb;
		$attribute_table_name 	=	 @$wpdb->prefix.'nueve_jet_attributes_table';
		$errorfile_table_name 	= 	 @$wpdb->prefix.'jeterrorfileinfo';
		$file_table_name 		=	 @$wpdb->prefix.'jetfileinfo';

		$charset_collate = '';
		
		if ( ! empty( @$wpdb->charset ) ) {
			$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
		}
			
		if ( ! empty( @$wpdb->collate ) ) {
			$charset_collate .= " COLLATE {$wpdb->collate}";
		}

		$tbl1 = "CREATE TABLE IF NOT EXISTS `$attribute_table_name` ( 
			`id` int(11) NOT NULL auto_increment,
		    `jet_node_id` int(11) default NULL,
			`jet_attr_id` bigint(20) NOT NULL, 
			`woocommerce_attr_id` int(11) NOT NULL,
			`freetext` int(4) NOT NULL, 
			`name` text NOT NULL, 
			`values` text NULL, 
			`pre_value` int(11) NOT NULL, 
			`variant` int(1) NOT NULL default 0, 
			`variant_pair` int(1) NOT NULL default 0, 
			`unit` text NULL,
				 PRIMARY KEY (`id`),
				 UNIQUE KEY `attr_id` (`jet_attr_id`) 
			);";

		$tbl2 = "
		CREATE TABLE IF NOT EXISTS `$errorfile_table_name` (
		`id` int(11) NOT NULL  auto_increment,
		`jet_file_id` varchar(70) NOT NULL,
		`file_name` varchar(70) NOT NULL,
		`file_type` varchar(70) NOT NULL,
		`status` varchar(60) NOT NULL,
		`error` text NOT NULL,
		PRIMARY KEY (`id`)
		);";

		$tbl3 = "
		CREATE TABLE IF NOT EXISTS `$file_table_name` (
		`id` int(10) NOT NULL  auto_increment,
		`woocommerce_batch_info` varchar(900) NOT NULL,
		`jet_file_id` varchar(400) NOT NULL,
		`token_url` varchar(200) NOT NULL,
		`file_name` varchar(100) NOT NULL,
		`file_type` varchar(100) NOT NULL,
		`status` varchar(50) NOT NULL default 'unprocessed',
		PRIMARY KEY (`id`)
		) ;";

		//ENGINE=InnoDB $charset_collate;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		dbDelta( @$wpdb->prepare($tbl1) );
		dbDelta( @$wpdb->prepare($tbl2) );
		dbDelta( @$wpdb->prepare($tbl3) );
		
		update_option('attr_table_updated','attr_table_done_updated');
	}


}
?>