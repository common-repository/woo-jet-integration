<?php

require_once(dirname(__FILE__) . '/tabs/nuevejet_settings.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_category_mapping.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_woo_products.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_products.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_product_details.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_orders.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_order_details.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_ship_order.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_returns.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_return_details.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_complete_return.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_refunds.php');
require_once(dirname(__FILE__) . '/tabs/nuevejet_refund_details.php');


class admin {
	
    function nuevejet_manage_tabs() {
		include_once(__DIR__.'/../views/nuevejet_main_menu.php');		
    }

	function nuevejet_get_content() {

		if ( isset ( $_GET['tab'] ) ) {			
		    $url = admin_url();
			
			if($_GET['tab'] =='settings' ) 	{
				$set_settings=nuevejet_settings::nuevejet_setSetings();
				echo $set_settings;
			} else if($_GET['tab'] =='mapping-categories')	{				
				$map_categories=nuevejet_category_mapping::nuevejet_mappingCategories();
				echo $map_categories;
			} else if($_GET['tab'] =='products') {
				$products_list=nuevejet_wooproducts::nuevejet_getwooProducts();
				echo $products_list;
			} else if($_GET['tab'] =='jet-products') {
				$jetproducts=nuevejet_products::nuevejet_getJetProducts();
				echo $jetproducts;
			} else if($_GET['tab'] =='jet-product-view') {
				$jetproductview = nuevejet_product_details::nuevejet_getJetProductdetails();
				echo $jetproductview;
			} else if($_GET['tab'] =='jet-orders')	{
				$orders_list =  nuevejet_orders::nuevejet_getJetOrders();
				echo $orders_list;
			} else if($_GET['tab'] == 'jet-order-view') {
				$jetorderview = nuevejet_order_details::nuevejet_getJetOrderdetails();
				echo $jetorderview;
			} else if($_GET['tab'] == 'jet-ship-order') {				
				$jetshiporder = nuevejet_ship_order::nuevejet_shipJetOrder();
				echo $jetshiporder;
			} else if($_GET['tab'] =='jet-returns')	{
				$returns_list = nuevejet_returns::nuevejet_getJetReturns();
				echo $returns_list;
			} else if($_GET['tab'] == 'jet-return-view') {
				$jetreturnview = nuevejet_return_details::nuevejet_getJetReturndetails();
				echo $jetreturnview;
			} else if($_GET['tab'] == 'jet-complete-return') {
				$jetcompletereturn = nuevejet_complete_return::nuevejet_completeJetReturn();
				echo $jetcompletereturn;
			} else if($_GET['tab'] =='jet-refunds')	{
				$refunds_list = nuevejet_refunds::nuevejet_getJetRefunds();
				echo $refunds_list;
			} else if($_GET['tab'] == 'jet-refund-view') {
				$jetrefundview = nuevejet_refund_details::nuevejet_getJetRefunddetails();
				echo $jetrefundview;
			}		
		} else {
			$set_settings=nuevejet_settings::nuevejet_setSetings();
			echo $set_settings;			
		}
	}


	function get_jetcategories() {
		$jetwebservicesapiurl = get_option('jetwebservicesapiurl',true);
		$api_url  = $jetwebservicesapiurl.'/get_jetcategories';

		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;    
	}

	function get_jetproducttaxcodes() {
		$jetwebservicesapiurl = get_option('jetwebservicesapiurl',true);
		$api_url  = $jetwebservicesapiurl.'/get_jetproducttaxcodes';

		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;    
	}

	function nuevejet_getattrdetails($mappedAttributes) {

		if(isset($mappedAttributes)){
			
			$allAttrInfo	=	array();
			foreach($mappedAttributes as $jetAttrID){
				
				global $wpdb;
				$table_name 	= 	@$wpdb->prefix.'nueve_jet_attributes_table';	

				$attr_qry = "select * from `$table_name` where `jet_attr_id` = $jetAttrID";

				$attrInfo =  @$wpdb->get_results(@$wpdb->prepare($attr_qry) );

				if(!empty($attrInfo)){
					$allAttrInfo[]	=	$attrInfo;
				}
			}
			return $allAttrInfo;
		}
	}

	
	function nuevejet_insertAttributeData($jetCatID) {
		
		$linkedAttrArray	=	array();		
		$attr_Detail = @admin::get_category_attributes($jetCatID);

		if( !empty($attr_Detail) && ($attr_Detail != INVALID_LOGIN) && ($response != API_ERROR)  ) {

			$all_attr_Detail = $attr_Detail['attributes'];		
			$mappedAttrIDS = array();		
			if(! empty($all_attr_Detail)) {
				foreach($all_attr_Detail as $index=> $attr){
					if( !empty($attr) ) {

						$attr_id					=	$attr['attribute_id'];
						$attr_info->id 			=	$attr_id;
						$attr_info->attr_value	=   $attr['values'];
						$attr_info->free_text	=	$attr['free_text'];
						$attr_info->name		=	$attr['attribute_description'];	
						$attr_info->units		=	$attr['units'];
						$attr_info->variant		=	$attr['variant'];
						
						$attr_id = isset($attr_info->id) ? absint($attr_info->id) : 0;
						//$attr_id = isset($attr_info->id) ? number_format($attr_info->id, 0, '', '') : 0;
						$mappedAttrIDS[] 		= 	$attr_id;

						$values = isset($attr_info->attr_value) ? json_encode($attr_info->attr_value) : '';

						if(isset($values) && !empty($values) && count($attr_info->attr_value)>1){
							$pre_value = 1;
						} else {
							$pre_value = 0;
						}

						$free_text = isset($attr_info->free_text) ? absint($attr_info->free_text) : 0;	
						if($free_text == 0 && $pre_value== 0)
							$free_text = 1;
						if($free_text == 1 && $attr_id == 50) 
							$free_text = 0;
									
						$name = isset($attr_info->name) ? $attr_info->name : '';
						$units = isset($attr_info->units) ? json_encode($attr_info->units) : '';
						$variant	=	isset($attr_info->variant) ? $attr_info->variant : '';
						
						global $wpdb;
						$table_name = @$wpdb->prefix.'nueve_jet_attributes_table';
						
						$attr_qry = "select * from `$table_name` where `jet_attr_id` = $attr_id";
						$resultdata =  @$wpdb->get_results(@$wpdb->prepare($attr_qry) );
						
						$attr_name = addslashes($name);

						if(empty($resultdata) || $resultdata == null){
							
							@$wpdb->prepare(
								@$wpdb->insert(
									$table_name, 
									array( 
										'jet_attr_id' => $attr_id,'freetext' => $free_text,'name' => $attr_name, 'values' => $values, 'pre_value' => $pre_value, 'unit' => $units, 'variant' => $variant
									),
									array('%d','%d', '%s', '%s', '%d', '%d', '%s')
								)
							); 		
									
						} else {

						  	@$wpdb->prepare(
							  	@$wpdb->update(
									$table_name, 
									array( 
										'freetext' => $free_text, 'name' => $attr_name, 'values' => $values, 'pre_value' => $pre_value,	'variant' => $variant,'unit' => $units
									), 
									array('jet_attr_id' => $attr_id), 
									array('%d', '%s', '%s', '%d', '%d', '%s')
								)
						    ); 
						}
					 }
				}
				//update attributes values on category index
				update_option($jetCatID.'_NueveJetAttributes',json_encode($mappedAttrIDS));
			} 
		}
	}

	function jet_get_category_attributes($jet_category) {
		$response 	= 	@admin::nuevejet_getrequest('/taxonomy/nodes/'.$jet_category.'/attributes');	
		return $response;		
    }

    function get_category_attributes($CatID) {

		$response	=	"";
		$response 	= 	@admin::nuevejet_getrequest('/taxonomy/nodes/'.$CatID.'/attributes');
		if( ($response != INVALID_LOGIN) && ($response != API_ERROR)  ) {
			$attributes	=	json_decode($response,true);		
			return $attributes;
		} else {
			return $response;
		}
    }
    
   
	function nuevejet_getrequest($method) {
		$token_result = @admin::nuevejet_token_authorisation();
		if( ($token_result != INVALID_LOGIN) && ($token_result != API_ERROR)  ) {
			$apirecord  = @admin::getoptions();
			$api_url  = $apirecord['apiUrl'].'/getRequest';
			$postFields = array('id_token'=>$token_result,'method'=>$method);
			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $response = curl_exec($curl);
	        curl_close($curl);
			return $response;	
        } else {
        	return $token_result;
        }
	}

	function nuevejet_postrequest($method, $post_field) {
		$token_result = @admin::nuevejet_token_authorisation();

        if( ($token_result != INVALID_LOGIN) && ($token_result != API_ERROR)  ) {

			$apirecord  = @admin::getoptions();
			$api_url  = $apirecord['apiUrl'].'/PostRequest';
			$postFields = array('id_token'=>$token_result,'method'=>$method,'form_data'=>$post_field);		
			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $response = curl_exec($curl);
	        curl_close($curl);
			return $response;	
        } else {
        	return $token_result;
        }
	}

	function nuevejet_putrequest($method, $post_field) {

        $token_result = @admin::nuevejet_token_authorisation();

        if( ($token_result != INVALID_LOGIN) && ($token_result != API_ERROR)  ) {

        	$apirecord  = @admin::getoptions();
			$api_url  = $apirecord['apiUrl'].'/PutRequest';		
			$postFields = array('id_token'=>$token_result,'method'=>$method,'form_data'=>$post_field);				
			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $response = curl_exec($curl);
	        curl_close($curl);
			return $response;
        } else {
        	return $token_result;
        }
	}

	function nuevejet_token_authorisation() {
    	$api_record = @admin::getoptions();	
    	$api_url = $api_record['apiUrl'].'/generateToken';

    	$user = $api_record['apiUser'];
    	$pass = $api_record['apiPass'];

		$postFields = array('user'=>$user,'pass'=>$pass);

		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postFields
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $token_data  = json_decode($response);

		if(is_object($token_data) && isset($token_data->id_token)){
			return $token_data->id_token;			
		} else if($response == 'failed') {
			return INVALID_LOGIN;
		} else {
			return API_ERROR;
		}
    }

	function UpdateProductStatus($sku,$product_status) {
		$apirecord  = @admin::getoptions();		
		$api_url  = $apirecord['apiUrl'].'/UpdateProductStatus';
		$postFields = array('sku'=>$sku,'product_status'=>$product_status);	

		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postFields
        ));
        $response = curl_exec($curl);
        curl_close($curl);
		return $response;
	}

	function nuevejet_update_inventory($sku, $inventory) {
		$apirecord  = @admin::getoptions();
		$user = $apirecord['apiUser'];
		$pass = $apirecord['apiPass'];		
		$api_url  = $apirecord['apiUrl'].'/JetProduct_Inventory_Update';
		$postFields = array('user'=>$user,'pass'=>$pass,'sku'=>$sku,'inventory'=>$inventory);
		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postFields
        ));
        $response = curl_exec($curl);
        curl_close($curl);
		return $response;
	}

	function nuevejet_update_price($sku, $price) {
		$apirecord  = @admin::getoptions();
		$user = $apirecord['apiUser'];
		$pass = $apirecord['apiPass'];		
		$api_url  = $apirecord['apiUrl'].'/JetProduct_Price_Update';
		$postFields = array('user'=>$user,'pass'=>$pass,'sku'=>$sku,'price'=>$price);
		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postFields
        ));
        $response = curl_exec($curl);
        curl_close($curl);
		return $response;
	}

	function ChangeProductStatus($sku,$archive_type) {
		$apirecord  = @admin::getoptions();
		$user = $apirecord['apiUser'];
		$pass = $apirecord['apiPass'];		
		$api_url  = $apirecord['apiUrl'].'/ChangeProductStatus';
		$postFields = array('user'=>$user,'pass'=>$pass,'sku'=>$sku,'archive_type'=>$archive_type);	
		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postFields
        ));
        $response = curl_exec($curl);
        curl_close($curl);
		return $response;
	}

	function jet_update_product_details($pdt_data) {
		$result ='';
		if(!empty($pdt_data)) {
			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$pdt_data = json_encode($pdt_data);
			$api_url  = $apirecord['apiUrl'].'/jet_update_product_details';
			$postFields = array('user'=>$user,'pass'=>$pass,'pdt_data'=>$pdt_data);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}
		echo $result;
		exit;
	}

	function jet_get_product_details($product_sku) {
		$result = '';
		if(!empty($product_sku)) {
			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/get_product_details';
			$postFields = array('user'=>$user,'pass'=>$pass,'product_sku'=>$product_sku);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}
		echo $result;
		exit;
	}


	function jet_get_products_list($product_type, $cur_page, $page_limit) {

		$result = '';

		if(!empty($product_type)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];

			$api_url  = $apirecord['apiUrl'].'/get_jetproducts_list';
			$postFields = array('user'=>$user,'pass'=>$pass,'product_type'=>$product_type,'cur_page'=>$cur_page, 'page_limit'=>$page_limit);

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function jet_refresh_data($cron_type) {

		$result = '';

		$apirecord  = @admin::getoptions();
		$user = $apirecord['apiUser'];
		$pass = $apirecord['apiPass'];

		$api_url  = $apirecord['apiUrl'].'/Refresh_JetData';
		$postFields = array('user'=>$user,'pass'=>$pass,'cron_type'=>$cron_type);

		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postFields
        ));
        $result = curl_exec($curl);
        curl_close($curl);

		echo $result;
		exit;
	}

	function jet_refresh_product_details($pdt_skus) {

		$result = '';

		$apirecord  = @admin::getoptions();
		$user = $apirecord['apiUser'];
		$pass = $apirecord['apiPass'];

		$pdt_skus = implode('&&',$pdt_skus);

		//echo $pdt_skus;

		//exit;

		$api_url  = $apirecord['apiUrl'].'/refresh_jetproduct_details';
		$postFields = array('user'=>$user,'pass'=>$pass,'pdt_skus'=>$pdt_skus);

		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postFields
        ));
        $result = curl_exec($curl);
        curl_close($curl);

		echo $result;
		exit;
	}


	function jet_get_orders_list($order_type, $cur_page, $page_limit) {

		$result = '';

		if(!empty($order_type)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/get_jetorders_list';
			$postFields = array('user'=>$user,'pass'=>$pass,'order_type'=>$order_type,'cur_page'=>$cur_page, 'page_limit'=>$page_limit);

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function jet_get_order_details($order_id) {

		$result = '';

		if(!empty($order_id)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/get_order_details';
			$postFields = array('user'=>$user,'pass'=>$pass,'order_id'=>$order_id);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function jet_acknowledge_order($order_id, $ack_type) {

		$result = '';

		if(!empty($order_id) && !empty($ack_type) ) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/acknowledge_order';
			$postFields = array('user'=>$user,'pass'=>$pass,'order_id'=>$order_id,'ack_type'=>$ack_type);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}


	function jet_order_cancel($order_id) {

		$result = '';

		if(!empty($order_id)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/cancel_order';
			$postFields = array('user'=>$user,'pass'=>$pass,'order_id'=>$order_id);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function jet_ship_order($order_id,$ship_order_array)  {

		$result = '';

		if(!empty($order_id)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/ship_order';
			$ship_order_array = json_encode($ship_order_array);
			$postFields = array('user'=>$user,'pass'=>$pass,'order_id'=>$order_id, 'ship_order_array'=>$ship_order_array);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function jet_request_refund_order($order_id, $refund_array) {

		$result = '';

		if(!empty($order_id)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/request_refund';
			$refund_array = json_encode($refund_array);
			$postFields = array('user'=>$user,'pass'=>$pass,'order_id'=>$order_id, 'refund_array'=>$refund_array);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function jet_get_returns_list($return_type, $cur_page, $page_limit) {

		$result = '';

		if(!empty($return_type)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/get_jetreturns_list';

			$postFields = array('user'=>$user,'pass'=>$pass,'return_type'=>$return_type,'cur_page'=>$cur_page, 'page_limit'=>$page_limit);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function get_return_details($return_id) {

		$result = '';

		if(!empty($return_id)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/get_return_details';

			$postFields = array('user'=>$user,'pass'=>$pass,'return_id'=>$return_id);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function jet_return_complete($return_id,$return_array) {

		$result = '';

		if(!empty($return_id)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/jet_return_complete';
			$return_array = json_encode($return_array);
			$postFields = array('user'=>$user,'pass'=>$pass,'return_id'=>$return_id, 'return_array'=>$return_array);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function jet_get_refunds_list($refund_type,$cur_page, $page_limit) {

		$result = '';

		if(!empty($refund_type)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/get_jetrefunds_list';
			
			$postFields = array('user'=>$user,'pass'=>$pass,'refund_type'=>$refund_type,'cur_page'=>$cur_page, 'page_limit'=>$page_limit);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function get_refund_details($refund_id) {

		$result = '';

		if(!empty($refund_id)) {

			$apirecord  = @admin::getoptions();
			$user = $apirecord['apiUser'];
			$pass = $apirecord['apiPass'];		
			$api_url  = $apirecord['apiUrl'].'/get_refund_details';

			$postFields = array('user'=>$user,'pass'=>$pass,'refund_id'=>$refund_id);	

			$curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $api_url,
	          CURLOPT_SSL_VERIFYPEER => false,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => $postFields
	        ));
	        $result = curl_exec($curl);
	        curl_close($curl);
    	}

		echo $result;
		exit;
	}

	function uploadFile($localfile ,$url) {	
		$headers = array();
		$headers[] = "x-ms-blob-type:BlockBlob";
	
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_PUT, 1);
		$fp = fopen ($localfile, 'r');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_INFILE, $fp);
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localfile));
	
		$http_result = curl_exec($ch);
		$error = curl_error($ch);
		$http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
	
		curl_close($ch);
		fclose($fp);	
	}
	   
    function CheckApiAccess() {
		$apirecord  = @admin::getoptions();

		$user = $apirecord['apiUser'];
		$pass = $apirecord['apiPass'];
		
		$api_url  = $apirecord['apiUrl'].'/CheckApiAccess';
		$postFields = array('user'=>$user,'pass'=>$pass);

		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postFields
        ));
        $response = curl_exec($curl);
        curl_close($curl);

		return $response; 
	}

	function JetUploadSKUDetails($skudata) {
		$apirecord  = @admin::getoptions();
		$user = $apirecord['apiUser'];
		$pass = $apirecord['apiPass'];	
		$api_url  = $apirecord['apiUrl'].'/JetUploadSKUDetails';
		$postFields = array('user'=>$user,'pass'=>$pass,'skudata'=>$skudata);	

		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postFields
        ));
        $response = curl_exec($curl);
        curl_close($curl);
	}
	

	function getoptions() {
		$apiHost =	esc_url(get_option('jetapiurl',true));
		$apiUser 	=   get_option('jetapiuser',true);
		$apiPass 	= 	get_option('jetsecretkey',true);
		$apiUrl =	esc_url(get_option('jetwebservicesapiurl',true));

		$array = array('apiHost'=>$apiHost, 'apiUser'=>$apiUser, 'apiPass' => $apiPass, 'apiUrl' => $apiUrl );

		return $array;
	}

	function StockDetails($_product,$variation_id = null) {
		
		if($variation_id != null){
			$_product->id = $variation_id;
		}	

		$stocktype  = get_post_meta($_product->id,'Jet_StockSelect',true);		
		if(empty($stocktype))
			$stocktype = 'central';

		$stocktype	= trim($stocktype);
		
		if($stocktype == 'central')
			$appliedStock		= 	get_post_meta($_product->id,'_stock',true);
				
		if($stocktype == 'other')
			$appliedStock		= 	get_post_meta($_product->id,'Jet_Stock',true);
				
		return (float)$appliedStock;
	}

	function PriceDetails($_product,$variation_id = null){

		if($variation_id != null){
			$_product->id = $variation_id;
		}

		$priceType		=	get_post_meta($_product->id,'Jet_PriceSelect',true);

		if($priceType == 'sale_price')
			$appliedPrice	=	get_post_meta($_product->id, '_sale_price', true) ? get_post_meta($_product->id, '_sale_price', true): get_post_meta($_product->id, '_regular_price', true);;

		if($priceType	==	'main_price')
			$appliedPrice	=	get_post_meta($_product->id, '_regular_price', true);

		if($priceType	==	'otherPrice')
			$appliedPrice	=	get_post_meta($_product->id, 'Jet_Price',true);

		return (float)$appliedPrice;
	}

	
    function nuevejet_validateUserData() {	

		$jet_api_url = get_option('jetapiurl',true);
		$jet_api_user = get_option('jetapiuser',true);
		$jet_secret_key = get_option('jetsecretkey',true);
		$jet_fulfillment_id = get_option('jetfulfillmentid',true);

		if(empty($jet_api_url) || empty($jet_api_user) || empty($jet_secret_key) || empty($jet_fulfillment_id)) {
			return false;
		} else {			
			return true;
		}
	}
 	

    function fetchProductDetail($pid) {
   	  	if(WC()->version < "3.0.0") {
   	 		$_product = get_product($pid);   	 		
   	 	} else  {
   	 		$_product = wc_get_product($pid);
   	 	}

   	 	if(isset($_product)) {

   	 		$product_type = $_product->get_type();

   	 		$productData	=	array();  	 		

			if($product_type == 'variable'){
				$VariationData			=	@admin::VariationProductDetails($_product,$productData,$pid);
				if(!empty($VariationData)){
					$productData = $VariationData;
					$productData['type']	=	'variable';
				}
			} else if($product_type == 'simple'){
				$simpleData			=	@admin::SimpleProductDetails($_product,$productData);

				if(!empty($simpleData)){
					$productData = $simpleData;
					$productData['type']	=	'simple';
				}
			} 

			$commonDetails	=	@admin::CommonProductDetails($_product,$productData);
			if(!empty($commonDetails))
				$productData = array_merge($commonDetails,$productData);

			return $productData;

   	 	} else {
   	 		return false;
   	 	} 	
    }   


    function CommonProductDetails($_product,$productData) {
		// start fetching the gallery images if any
		$attachment_ids 			= 	$_product->get_gallery_attachment_ids();
		$alternate_image_urls 		= 	array();
		$image_counter				=	1;

		if(count($attachment_ids)) 	{
			foreach( $attachment_ids as $attachment_id ) 		{
				if($image_counter < 9) 			{
						//Get URL of Gallery Images - default wordpress image sizes
					$alternate_image_urls[] = wp_get_attachment_url( $attachment_id );
				}
				$image_counter++;
			}
		}
		if(count($alternate_image_urls)) {
			$productData['gallery_images']	=	$alternate_image_urls;
		}

	 	return $productData;
  	}

    function SimpleProductDetails($_product,$productData) {
    	if(WC()->version < "3.0.0"){
			$product_id = $_product->id;
		} else	{
			$product_id = $_product->get_id();			
		}

		$productData	=	@admin::ProductDetails($product_id, $productData);

		$productData['id']						=	 $_product->id;
		$productData['name']					=	$_product->get_title();

		$image_link_url							=	wp_get_attachment_image_src( get_post_thumbnail_id( $_product->id ), 'single-post-thumbnail' );
		$productData['jet_product_image_link']	=	$image_link_url[0];
		$productData['desc']		=	substr($_product->post->post_content, 0,1998);

		$productData['JetSKU']          =    $_product->get_sku();
		$productData['Jet_Price']		=	@admin::PriceDetails($_product);
		$productData['Jet_Stock']		=	@admin::StockDetails($_product);

		$productData['Shipping_Weight_Pounds'] 	=  get_post_meta($_product->id, '_weight', true);	
		$productData['weight_lbs']	= 	wc_get_weight($_product->get_weight(), 'lbs');
		$productData['height_in']	= 	wc_get_weight($_product->height, 'lbs');
		$productData['widht_in']	= 	wc_get_weight($_product->width, 'lbs');
		$productData['length_in']	= 	wc_get_weight($_product->length, 'lbs');

		return $productData;		
    }

    function VariationProductDetails($_product,$productData) {
    	$result = '';
    	return $result;
    }

    function ProductDetails($pid,$productData,$variable=null,$variation=array()) {
    	
		if($variable) {
			$selectedNodeID		=	get_post_meta($pid,$pid.'_JetSelectedCatAttr',true);
		} else{
			$selectedNodeID		=	get_post_meta($pid,'JetSelectedCatAttr',true);
		}

		if(!empty($selectedNodeID)) {
			$mappedAttributes		=	get_option($selectedNodeID.'_NueveJetAttributes',false);
			// print_r($mappedAttributes);
			if($mappedAttributes) {
				$mappedAttributes	=	json_decode($mappedAttributes);
				if(is_array($mappedAttributes)){
					$jetAttrInfo[$selectedNodeID]	=	@admin::nuevejet_getattrdetails($mappedAttributes);
				}
			}
		}

		$productData['jet_cat_id']		=	$selectedNodeID;

		$attributesData	=	array();
		foreach($jetAttrInfo as $jetNode => $mappedCAT) {
			foreach($mappedCAT as $attrARRAY) {
				$attrObject = $attrARRAY[0];
				if($variable){
					$tempName	= $pid."_".$jetNode."_".$attrObject->jet_attr_id;
				}else{
					$tempName	= $jetNode."_".$attrObject->jet_attr_id;
				}
				$tempID		= $attrObject->jet_attr_id;

				if($attrObject->freetext == 2 || ($attrObject->freetext == 0 && !empty($attrObject->unit))) {	
					$attributesData[$tempID]			=	get_post_meta($pid,$tempName,true);
					$attributesData[$tempID.'_unit']	=	get_post_meta($pid,$tempName.'_unit',true);
				}

				$attributesData[$tempID]	=	get_post_meta($pid,$tempName,true);		
			}
		}

		$productData['all_attributes']						=	 $attributesData;
					
		$productData['JetParentSKU']		=	get_post_meta($pid,'JetParentSKU',true);		
		$productData['JetStandardProductCodeType']		= get_post_meta($pid,'JetStandardProductCodeType',true);
		$productData['JetStandardProductCode']		=	get_post_meta($pid,'JetStandardProductCode',true);		
		$productData['JetMultiPackQuantity']		  =         get_post_meta($pid,'JetMultiPackQuantity',true);
		$productData['JetMapPrice']					 		= 	 get_post_meta($pid, 'JetMapPrice', true);
		$productData['JetMapImplementation']					= 	 get_post_meta($pid, 'JetMapImplementation', true);
		$productData['JetMSRP']					 			= 	 get_post_meta($pid, 'JetMSRP', true);
		$productData['JetProductBrand']	 						=	 get_post_meta($pid,'JetProductBrand',true);
		$productData['JetCountry']				= 	 get_post_meta($pid, 'JetCountry', true);		
		$productData['JetProductManufacturer']			 	= 	 get_post_meta($pid, 'JetProductManufacturer', true);
		$productData['JetMFR']				= 	 get_post_meta($pid, 'JetMFR', true);
		$productData['JetPackageLength']						= 	 get_post_meta($pid, 'JetPackageLength', true);
		$productData['JetPackageWidth']						= 	 get_post_meta($pid, 'JetPackageWidth', true);
		$productData['JetPackageHeight']						= 	 get_post_meta($pid, 'JetPackageHeight', true);	
		$productData['JetProductTaxCode']					= 	 get_post_meta($pid, 'JetProductTaxCode', true);
		$productData['JetSafetyWarning']					 	= 	 get_post_meta($pid, 'JetSafetyWarning', true);
		$productData['JetLegalDisc'] 					= 	 get_post_meta($pid, 'JetLegalDisc', true);		
		$productData['JetProp65']								= 	 get_post_meta($pid, 'JetProp65', true);	
		$productData['JetBullets']					 			= 	 get_post_meta($pid, 'JetBullets', true);
		$productData['JetCpsiaCautionaryStatements']	= 	 get_post_meta($pid, 'JetCpsiaCautionaryStatements', true);

		return $productData;
    }


    function create_file_formatted_array($product) {
    	$result = array();
    	$sku_array = array();
    	$product_id = $product['id'];   	

    	$unique_check_result = @admin::unique_check($product);

    	if( !empty($unique_check_result) ){
    		return $unique_check_result;    		
    	} else {
    		$jet_sku = $product['JetSKU'];
    		$jet_parent_sku = $product['JetParentSKU'];
    		$sku_array['product_title']   =   stripslashes($product['name']);
    		$sku_array['jet_browse_node_id']   =   intval($product['jet_cat_id']);
   			$sku_array['multipack_quantity']   =   intval($product['JetMultiPackQuantity']);
   			$sku_array['brand']   =   stripslashes($product['JetProductBrand']);
   			$sku_array['manufacturer']   =   stripslashes($product['JetProductManufacturer']);
   			$sku_array['mfr_part_number']   =   stripslashes($product['JetMFR']);
   			$sku_array['product_description']   =   stripslashes($product['desc']);

   			$standard_product_code_type = trim($product['JetStandardProductCodeType']);
    		$standard_product_code = trim($product['JetStandardProductCode']);

    		if($standard_product_code_type == 'ASIN') {
    			$sku_array['ASIN'] = $standard_product_code;
    		} else {
    			$txt['standard_product_code'] = $standard_product_code;
 				$txt['standard_product_code_type'] = $standard_product_code_type;
 	 			$sku_array['standard_product_codes'][] = $txt;
    		}

   			$p_bullets = $product['JetBullets'];
			$p_bullets = json_decode($p_bullets);

		   	$bullets = array();
   			for($i=0;$i<count($p_bullets);$i++) {
   				$bullets[] = stripslashes($p_bullets[$i]);
   			}  			
   			$sku_array['bullets']   =  $bullets;

   			if(!empty($product['weight_lbs'])){
				$sku_array['shipping_weight_pounds'] = (float) number_format( (float) $product['weight_lbs'], 2, '.', '');
			}

			if(!empty($product['JetPackageLength']) && !empty($product['JetPackageWidth']) && !empty($product['JetPackageHeight'])){

				$sku_array['package_length_inches'] 			= (float) number_format( (float) $product['JetPackageLength'], 2, '.', '');
				$sku_array['package_width_inches'] 			= (float) number_format( (float) $product['JetPackageWidth'], 2, '.', '');
				$sku_array['package_height_inches'] 			= (float) number_format( (float) $product['JetPackageHeight'], 2, '.', '');
			}

			if(!empty($product['length_in']) && !empty($product['widht_in']) && !empty($product['height_in'])){

				$sku_array['display_length_inches'] 			= (float) number_format( (float) $product['length_in'], 2, '.', '');
				$sku_array['display_width_inches'] 			= (float) number_format( (float) $product['widht_in'], 2, '.', '');
				$sku_array['display_height_inches'] 			= (float) number_format( (float) $product['height_in'], 2, '.', '');
			}

			$prop_65 = 	$product['JetProp65'];
			if($prop_65 == 'true') 	{
				$prop_65 = true;
			}	else {
				$prop_65 = false;
			}


			$sku_array['prop_65'] = 	$prop_65;

			$sku_array['legal_disclaimer_description'] = stripslashes($product['JetLegalDisc']);
			$sku_array['safety_warning'] = stripslashes($product['JetSafetyWarning']);
			$sku_array['country_of_origin'] = stripslashes($product['JetCountry']);
			$sku_array['msrp'] = (float)($product['JetMSRP']);
			$sku_array['map_price'] = (float)($product['JetMapPrice']);
			$sku_array['map_implementation'] = $product['JetMapImplementation'];
			$sku_array['product_tax_code'] = $product['JetProductTaxCode'];	
			
			$cpsia_cautionary_statements = $product['JetCpsiaCautionaryStatements'];
			$cpsia_cautionary = array();
			if( !empty($cpsia_cautionary_statements) )	{
				$cpsia_cautionary = json_decode($cpsia_cautionary_statements);
			}
			$sku_array['cpsia_cautionary_statements'] = $cpsia_cautionary;   			
   		
			$sku_array['main_image_url'] = $product['jet_product_image_link'];

			$alternate_image 	=	$product['gallery_images'];

			if(count($alternate_image)) 	{			
				foreach($alternate_images as $tmp_image){
					if($tmp_image !== $image){
						$alternate_image[] = $tmp_image;
					}
				}
			} 
		
			$Alternate_images	=	array();
			$alt_img_urls		=	array();
			$start_count		=	1;
			if(count($alternate_image)) 	{
				foreach($alternate_image as $slot_id => $alt_img_url){
					$Alternate_images[]	=	array('image_slot_id'=>$start_count,'image_url'=>$alt_img_url);
					$start_count++;
				}
				$sku_array['alternate_images']	=	$Alternate_images;
			}

			$attributes = @admin::create_attribute_array($product);
			if($attributes) {
				$sku_array['attributes_node_specific'] = $attributes;
			}
		
			$result['sku'][$jet_sku] = $sku_array;

			$jet_fulfillment_id = get_option('jetfulfillmentid',true);			
			$node1['fulfillment_node_id'] = $jet_fulfillment_id;

			$quantity = (int)$product['Jet_Stock'];
			$node1['quantity'] = $quantity;
			$inventory[$jet_sku]['fulfillment_nodes'][] = $node1;
		    $result['inventory']	=	$inventory;
			
			$product_price = (float)$product['Jet_Price'];

			$node2['fulfillment_node_id'] = $jet_fulfillment_id;
			$node2['fulfillment_node_price'] = $product_price;

			$price[$jet_sku]['price'] = $product_price;
			$price[$jet_sku]['fulfillment_nodes'][] = $node2;
          	$result['price']	=	$price;

          	$jet_sku_details = array('jet_sku'=>$jet_sku,'jet_parent_sku'=>$jet_parent_sku,'product_price'=>$product_price,'quantity'=>$quantity, 'woo_product_id'=>$product_id);
          	
          	$sku_details = array_merge($jet_sku_details,$sku_array); 
          	$result['product_data'] = array('sku_details'=>$sku_details);

    		return $result;
    	}    	
    }
   

    function create_attribute_array($product) {

		$attribute	=	$product['all_attributes'];

		$attribute_array = array();

		if(count($attribute))	{
			$counter 	= 	0;
			$empty		=	false;

			foreach ($attribute as $att_id => $att_val) {
				if(!empty($att_val) && $att_val != 'none') {					
					$explode_check	=	explode('_', $att_id);
					if($explode_check[count($explode_check)-1] == 'unit') {
						continue;
					}

					if(empty($att_val))	{
						$empty	=	true;
					}

					$attr_unit	=	$attribute[$att_id.'_unit'];
					if(!empty($attr_unit))	{
						$attribute_array[$counter] = array(
							'attribute_id'=> (float)$att_id,
							'attribute_value'=>$att_val,
							'attribute_value_unit' =>$attr_unit,
							);
					} else {
						$attribute_array[$counter] = array(
							'attribute_id'=> (float)$att_id,
							'attribute_value'=>$att_val,
							);
					}
					$counter++;
				}
			}
		}

		if($empty) {
			return $empty;
		}
		else {
			return $attribute_array;
		}
	}

    function unique_check($product) {
    	$product_title = $product['name'];
    	$standard_product_code_type = trim($product['JetStandardProductCodeType']);
    	$standard_product_code = trim($product['JetStandardProductCode']);
        $standard_value_count	=  	strlen($standard_product_code);
     
     	$result ='';

        if(empty($product['JetSKU'])) {
    		$result = 'Product SKU value must not be empty and unique for product: '.$product_title;
    	} else if(empty($product['jet_cat_id'])) {
    		$result = 'Category value is missing for product: '.$product_title.'. please set product category and reupload';
    	} else if(empty($product['JetMultiPackQuantity'])) {
    		$result =  'MultiPack Quantity value is  Missing for product: '.$product_title;
    	} else if(empty($product['JetProductBrand'])) {
    		$result =  'Brand value is Missing for product: '.$product_title;
    	} else  if(empty($standard_product_code)) {
        	$result = 'Standard code value is missing for product: '.$product_title;
        } else	if($standard_product_code_type == 'UPC' && $standard_value_count != 12) {
    		$result = 'UPC value must be of 12 charcater for product: '.$product_title;
    	} else if($standard_product_code_type == 'GTN-14' && $standard_value_count != 14) {
    		$result =  'GTN-14 value must be of 14 charcater for product: '.$product_title;
    	} else if($standard_product_code_type == 'ISBN-10' && $standard_value_count != 10) {
    		$result = 'ISBN-10 value must be of 10 charcater for product: '.$product_title;
    	} else if($standard_product_code_type == 'ISBN-13' && $standard_value_count != 13) {
    		$result = 'ISBN-13 value must be of 13 charcater for product: '.$product_title;
    	} else if($standard_product_code_type == 'EAN' && $standard_value_count != 13) {
    		$result = 'EAN value must be of 13 charcater for product: '.$product_title;
    	} else if($standard_product_code_type == 'ASIN' && $standard_value_count != 10) {
    		$result = 'ASIN value must be of 10 charcater for product: '.$product_title;
    	} else if(empty($product['jet_product_image_link']) ) {
    		$result =  'Product Image is required for product: '.$product_title;
    	} else if(empty($product['Jet_Price']) ) {
    		$result =  'Product Price is required for product: '.$product_title;
    	} else if(empty($product['Jet_Stock']) ) {
    		$result =  'Product Inventory is required for product: '.$product_title;
    	} 

    	return $result;
    }

    function gzCompressFile($source, $level = 9){
		$dest = $source . '.gz';
		$mode = 'wb' . $level;
		$error = false;
		if ($fp_out = gzopen($dest, $mode)) {
			if ($fp_in = fopen($source,'rb')) {
				while (!feof($fp_in))
					gzwrite($fp_out, fread($fp_in, 1024 * 512));
				fclose($fp_in);
			} else {
				$error = true;
			}
			gzclose($fp_out);
		} else {
			$error = true;
		}
		if ($error)
			return false;
		else
			return $dest;
	}

	
}
?>
