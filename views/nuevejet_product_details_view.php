<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';
$jet_woo_plugin_url = jet_wordpress_plugin_url;

$jet_get_product_details_nonce_check = wp_create_nonce('jet_get_product_details_nonce_check');
$jet_get_category_attributes_nonce_check = wp_create_nonce('jet_get_category_attributes_nonce_check');
$jet_update_product_details_nonce_check = wp_create_nonce('jet_update_product_details_nonce_check');

$get_jetcategories = @admin::get_jetcategories();
$get_jetcategories = json_decode($get_jetcategories,true);

$get_jetproducttaxcodes = @admin::get_jetproducttaxcodes();
$get_jetproducttaxcodes = json_decode($get_jetproducttaxcodes,true);

?>


<style type="text/css">

#no-rep, #no-result, #product_header {
	font-size: 26px;
    font-weight: 700;
    text-transform: uppercase;
    text-align: center;
    padding:0px;
    margin-top:20px;
}

#product_details, #jetloading, #no-rep, #no-result,  #attributes_divs {
	display:none;
}

#product_header {
	text-align:left;
	margin: 10px 0px 10px;
    text-transform: capitalize;
}

#product_div {
	background: #fff;
	padding:20px;
	border: 1px solid #ddd;
	margin-right:10px;
}

.product_data {
	font-size: 16px;
    padding: 0px 0px 20px;
    color: #23282d;
}

.product_label {
	font-weight:600;
	margin-right:10px;
	margin-top:6px;
	float:left;
	width:25%;
	text-transform:uppercase;
}

.product_text {
	width:65%;
	float:right;
}

.pdt_text {
	float: right;
    width: 30%;
    margin-right: 35%;
}

.pdt_text_inputs {
	color: #000 !important;
    width: 100% !important;
    padding: 5px 10px !important;
}

.img_inputs {
	width:65% !important;
	font-size: 15px;
}

#jetloading {
	margin: 20px 0px;
}

.image-label {
    padding-top: 30px !important;
}

.non-image-label {
	padding-top: 0px !important;
}

.thumbnail_image {
    max-width: 80px;
    max-height: 80px;
    margin:10px 10px 10px 20px;
    display:none;
}

#attributes_div {
    border: 1px solid #ccc;
    margin-bottom: 10px;
    padding: 0px 20px 0px;
    margin: 10px 0px 20px;
}

#attributes_header {
    font-weight: 700;
    margin: 10px 0px 20px;
    font-size: 24px;
}

.check_labels {
	margin-top: 10px;
    font-size: 18px;
    font-weight: 500;
    margin-left: 10px;
}

.desc_div, .bullets_div, .safety_div, .legal_div {
    margin-right: 0%;
    width: 65%;
}

.bootstrap-select {
	width:100% !important;
}

.attrs_div .product_label {
	margin-top:10px;
	font-size:16px;
}

#cat_loading {
	margin-left:100px;
	display:none;
}

.attrs_div .pdt_text_inputs {
	padding: 10px !important;
    height: 40px;
    line-height: 30px;
    color: #000 !important;
    font-size: 15px !important;
}

.update_product_btn {
	float:right;
	margin: 0px 40px 0px 0px;
}

.req {
	color: #ff0000;
    margin-left: 5px;
    font-size: 18px;
    font-weight: 700;
}

.alert{
	display:none;
	width: 98%;
    color: #000 !important;
    background-color: #eae4e4 !important;
}

.bootstrap-select.btn-group .dropdown-toggle .filter-option {
	font-size:16px;
}


</style>

<?php 
	if(!isset($_REQUEST['product_sku']) || empty($_REQUEST['product_sku']) ){
	?>
		<div id="no-result" style="display:block;"><?php _e('Product SKU is Required','nueve-woocommerce-jet-integration');?></div>
	<?php
	exit;
	} else if(isset($_REQUEST['product_sku']) && !empty($_REQUEST['product_sku']) ){
		$product_sku = $_REQUEST['product_sku'];
	?>

		<img height="50px" width="50px" id="jetloading"  src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">

		<input type="hidden" value="<?php _e($jet_woo_plugin_url,'nueve-woocommerce-jet-integration'); ?>"  id="jet_woo_plugin_url">

		<input type="hidden" value="<?php _e($product_sku,'nueve-woocommerce-jet-integration'); ?>"  id="product_sku">

		<input type="hidden" name="jet_get_product_details_secure_key"
		 value="<?php _e($jet_get_product_details_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_get_product_details_secure_key">

		<input type="hidden" name="jet_get_category_attributes_secure_key"
		 value="<?php _e($jet_get_category_attributes_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_get_category_attributes_secure_key">

		  <input type="hidden" name="jet_update_product_details_secure_key"
		 value="<?php _e($jet_update_product_details_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
		  id="jet_update_product_details_secure_key">
		  		  					
		<div id="no-rep"><?php _e('No Product Details Found','nueve-woocommerce-jet-integration');?></div>

		<div id="product_details">

			<div id="product_header"><?php _e('View Product Details','nueve-woocommerce-jet-integration');?></div>

			<div class="alert">
				<a href="#" class="close">&times;</a>
				<span class="alert-text"></span>
			</div>

			<div id="product_div">

				<div class="product_data">
					<button type="submit" class="btn btn-lg btn-primary  update_product_btn"><?php _e('Update Product','nueve-woocommerce-jet-integration');?></button>
					<div class="clearfix"></div>
				</div>

				<div class="clearfix"></div>

				
				<div class="product_data">
		            <span class="product_label"><?php _e('Jet Merchant SKU:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <!--<span class="product_text" id="merchant_sku" style="display:none;"><?php _e($product_sku,'nueve-woocommerce-jet-integration');?></span>-->

		            <span class="pdt_text">
		            	<input type="text" id="merchant_sku" class="pdt_text_inputs" readonly value="<?php _e($product_sku,'nueve-woocommerce-jet-integration');?>" placeholder="Merchant SKU" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Jet Parent SKU:','nueve-woocommerce-jet-integration');?></span>
		            <!-- <span class="product_text" id="parent_sku"></span> -->
		            <span class="pdt_text">
		            	<input type="text" id="parent_sku" class="pdt_text_inputs" placeholder="Parent SKU" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Product Title:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <!--<span class="product_text" id="product_title"></span>-->
		            <span class="pdt_text">
		            	<input type="text" id="product_title" class="pdt_text_inputs" placeholder="Product Title" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Price:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <!--<span class="product_text" id="product_price"></span> -->
		            <span class="pdt_text">
		            	<input type="number" step="1" id="product_price" class="pdt_text_inputs" placeholder="Price" />
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Inventory:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <!--<span class="product_text" id="product_quantity"></span> -->
		            <span class="pdt_text">
		            	<input type="number" step="1" id="product_quantity" class="pdt_text_inputs" placeholder="Inventory" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Multipack Quantity:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <!-- <span class="product_text" id="multipack_quantity"></span> -->

		            <span class="pdt_text">
		            	<input type="number" step="1" id="multipack_quantity" class="pdt_text_inputs" placeholder="Multipack Quantity" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('MAP Price:','nueve-woocommerce-jet-integration');?></span>
		            <!-- <span class="product_text" id="map_price"></span> -->
		            <span class="pdt_text">
		            	<input type="number" step="0.01" id="map_price" class="pdt_text_inputs" placeholder="MAP Price" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Map Implementation:','nueve-woocommerce-jet-integration');?></span>
		            <!-- <span class="product_text" id="map_implementation"></span> -->

		            <span class="pdt_text">
		            	<select class="pdt_text_inputs" id="map_implementation">
		            		<option value="101">101</option>
		            		<option value="102">102</option>
		            		<option value="103">103</option>
		            	</select>
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('MSRP:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="msrp"></span> -->
		            <span class="pdt_text">
		            	<input type="number" step="0.01" id="msrp" class="pdt_text_inputs" placeholder="MSRP" />
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Brand:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <!--<span class="product_text" id="brand"></span> -->
		            <span class="pdt_text">
		            	<input type="text" id="brand" class="pdt_text_inputs" placeholder="Brand" />
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Standard Product Code Type:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="standard_product_code_type"></span> -->
		            <span class="pdt_text">
		            	<select class="pdt_text_inputs" id="standard_product_code_type">
		            		<option value="GTIN-14">GTIN-14</option>
                            <option value="EAN">EAN</option>
                            <option value="ISBN-10">ISBN-10</option>
                            <option value="ISBN-13">ISBN-13</option>
                            <option value="UPC">UPC</option>
                            <option value="ASIN">ASIN</option>		    
                        </select>
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Standard Product Code:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <!--<span class="product_text" id="standard_product_code"></span> -->
		            <span class="pdt_text" id="spc">
		            	<input type="text"  id="standard_product_code" class="pdt_text_inputs" placeholder="UPC code" maxlength="12" />
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Shipping Weight (LBS):','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="shipping_weight_pounds"></span> -->

		            <span class="pdt_text">
		            	<input type="number" step="0.01" id="shipping_weight_pounds" class="pdt_text_inputs" placeholder="Shipping weight (lbs)" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>
		      
		        <div class="product_data">
		            <span class="product_label"><?php _e('Package Width (INCHES):','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="package_width_inches"></span>-->

		            <span class="pdt_text">
		            	<input type="number" step="0.01" id="package_width_inches" class="pdt_text_inputs" placeholder="Package width (inches)" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Package Height (INCHES):','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="package_height_inches"></span>-->

		            <span class="pdt_text">
		            	<input type="number" step="0.01" id="package_height_inches" class="pdt_text_inputs" placeholder="Package height (inches)" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Package Length (INCHES):','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="package_length_inches"></span> -->

		            <span class="pdt_text">
		            	<input type="number" step="0.01" id="package_length_inches" class="pdt_text_inputs" placeholder="Package length (inches)" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		          <div class="product_data">
		            <span class="product_label"><?php _e('Display Width (INCHES):','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="display_width_inches"></span> -->

		            <span class="pdt_text">
		            	<input type="number" step="0.01" id="display_width_inches" class="pdt_text_inputs" placeholder="Display width (inches)" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Display Height (INCHES):','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="display_height_inches"></span>-->

		            <span class="pdt_text">
		            	<input type="number" step="0.01" id="display_height_inches" class="pdt_text_inputs" placeholder="Display height (inches)" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Display Length (INCHES):','nueve-woocommerce-jet-integration');?></span>
		           <!-- <span class="product_text" id="display_length_inches"></span> -->

		            <span class="pdt_text">
		            	<input type="number" step="0.01" id="display_length_inches" class="pdt_text_inputs" placeholder="Display length (inches)" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Country Of Origin:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="country_of_origin"></span> -->

		            <span class="pdt_text">
		            	<input type="text" id="country_of_origin" class="pdt_text_inputs" placeholder="Country of origin" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Manufacturer:','nueve-woocommerce-jet-integration');?></span>
		            <!-- <span class="product_text" id="manufacturer"></span> -->

		            <span class="pdt_text">
		            	<input type="text" id="manufacturer" class="pdt_text_inputs" placeholder="Manufacturer" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Mfr Part Number:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="mfr_part_number"></span> -->

		            <span class="pdt_text">
		            	<input type="text" id="mfr_part_number" class="pdt_text_inputs" placeholder="Mfr Part Number" />
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="main_image_div">
		            <span class="product_label image-label" id="main_image_label"><?php _e('Main Image:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <span class="product_text">
		            	<input type="text" id="main_image_url" class="pdt_text_inputs img_inputs" placeholder="Main Image URL" />
		            	<img src="" id="main_image" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="swatch_image_div">
		            <span class="product_label image-label" id="swatch_image_label"><?php _e('Swatch Image:','nueve-woocommerce-jet-integration');?></span>
		            <span class="product_text">
		            	<input type="text" id="swatch_image_url" class="pdt_text_inputs img_inputs" placeholder="Swatch Image URL" />
		            	<img src="" id="swatch_image" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="alternate_image1_div">
		            <span class="product_label image-label" id="alternate_image1_label"> <?php _e('Alternate Image 1:','nueve-woocommerce-jet-integration');?></span>
		            <span class="product_text">
		            	<input type="text" id="alternate_image1_url" class="pdt_text_inputs img_inputs" placeholder="Image URL" />
		            	<img src="" id="alternate_image1" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="alternate_image2_div">
		            <span class="product_label image-label" id="alternate_image2_label"><?php _e('Alternate Image 2:','nueve-woocommerce-jet-integration');?></span>
		            <span class="product_text">
		            	<input type="text" id="alternate_image2_url" class="pdt_text_inputs img_inputs" placeholder="Image URL" />
		            	<img src="" id="alternate_image2" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="alternate_image3_div">
		            <span class="product_label image-label" id="alternate_image3_label"><?php _e('Alternate Image 3:','nueve-woocommerce-jet-integration');?></span>
		            <span class="product_text">
		            	<input type="text" id="alternate_image3_url" class="pdt_text_inputs img_inputs" placeholder="Image URL" />
		            	<img src="" id="alternate_image3" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="alternate_image4_div">
		            <span class="product_label image-label" id="alternate_image4_label"><?php _e('Alternate Image 4:','nueve-woocommerce-jet-integration');?></span>
		            <span class="product_text">
		            	<input type="text" id="alternate_image4_url" class="pdt_text_inputs img_inputs" placeholder="Image URL" />
		            	<img src="" id="alternate_image4" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="alternate_image5_div">
		            <span class="product_label image-label" id="alternate_image5_label"><?php _e('Alternate Image 5:','nueve-woocommerce-jet-integration');?></span>
		            <span class="product_text">
		            	<input type="text" id="alternate_image5_url" class="pdt_text_inputs img_inputs" placeholder="Image URL" />
		            	<img src="" id="alternate_image5" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="alternate_image6_div">
		            <span class="product_label image-label" id="alternate_image6_label"><?php _e('Alternate Image 6:','nueve-woocommerce-jet-integration');?></span>
		            <span class="product_text">
		            	<input type="text" id="alternate_image6_url" class="pdt_text_inputs img_inputs" placeholder="Image URL" />
		            	<img src="" id="alternate_image6" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="alternate_image7_div">
		            <span class="product_label image-label" id="alternate_image7_label"><?php _e('Alternate Image 7:','nueve-woocommerce-jet-integration');?></span>
		            <span class="product_text">
		            	<input type="text" id="alternate_image7_url" class="pdt_text_inputs img_inputs" placeholder="Image URL" />
		            	<img src="" id="alternate_image7" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data" id="alternate_image8_div">
		            <span class="product_label image-label" id="alternate_image8_label"><?php _e('Alternate Image 8:','nueve-woocommerce-jet-integration');?></span>
		            <span class="product_text">
		            	<input type="text" id="alternate_image8_url" class="pdt_text_inputs img_inputs" placeholder="Image URL" />
		            	<img src="" id="alternate_image8" class="thumbnail_image">
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Jet Category:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <!--<span class="product_text" id="jet_category"></span> -->
		            <span class="pdt_text" id="jet_category_div">
		            	<select class="selectpicker pdt_text_inputs" id="jet_category"  data-live-search="true">
						<?php
						foreach($get_jetcategories as $get_jetcategory) {
							if( !empty($get_jetcategory['category_name']) ) {
								$category_name = $get_jetcategory['category_name'];
								$category_id = $get_jetcategory['category_id'];
								?>
								<option data-tokens="<?php _e($category_name,'nueve-woocommerce-jet-integration'); ?>" value="<?php _e($category_id,'nueve-woocommerce-jet-integration'); ?>" > 
									<?php _e($category_name,'nueve-woocommerce-jet-integration'); ?>
								</option>
							<?php
							}
						}
						?>
					</select>

					<img height="40px" width="40px" id="cat_loading"  src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">

		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div id="attributes_div">
		        	<div id="attributes_header"><?php _e('Attributes','nueve-woocommerce-jet-integration');?></div>
		        	<div id="attributes_list"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Product Tax Code:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="product_tax_code"></span> -->
		            <span class="pdt_text" id="product_tax_code_div">
		            	<select class="selectpicker pdt_text_inputs" id="jet_product_tax_code" data-live-search="true">
							<?php
							foreach($get_jetproducttaxcodes as $get_jetproducttaxcode) {
								if( !empty($get_jetproducttaxcode['taxcode_value']) ) {
									$taxcode_value = $get_jetproducttaxcode['taxcode_value'];
									$taxcode_id = $get_jetproducttaxcode['taxcode_id'];
									?>
									<option data-tokens="<?php _e($taxcode_value,'nueve-woocommerce-jet-integration'); ?>" value="<?php _e($taxcode_value,'nueve-woocommerce-jet-integration'); ?>" > 
										<?php _e($taxcode_value,'nueve-woocommerce-jet-integration'); ?>
									</option>
								<?php
								}
							}
							?>
						</select>
		            </span>
		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Product Description:','nueve-woocommerce-jet-integration');?><span class="req">*</span></span>
		            <!--<span class="product_text" id="product_description"></span> -->

		            <span class="pdt_text desc_div">
		            	<textarea id="product_description" class="pdt_text_inputs" placeholder="Product Description" rows="8" ></textarea>
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Bullets:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="bullets"></span> -->

		            <span class="pdt_text bullets_div">
		            	<input type="text" id="bullet1" name="bullets[]" class="pdt_text_inputs bullets_inputs"  placeholder="Bullet1"  /> <br/>  <br/> 
		            	<input type="text" id="bullet2" name="bullets[]" class="pdt_text_inputs bullets_inputs" placeholder="Bullet2" /> <br/>  <br/> 
		            	<input type="text" id="bullet3" name="bullets[]" class="pdt_text_inputs bullets_inputs" placeholder="Bullet3" /> <br/>  <br/> 
		            	<input type="text" id="bullet4" name="bullets[]" class="pdt_text_inputs bullets_inputs" placeholder="Bullet4" /> <br/>  <br/> 
		            	<input type="text" id="bullet5" name="bullets[]" class="pdt_text_inputs bullets_inputs" placeholder="Bullet5" /> <br/>  <br/> 
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Legal Disclaimer Description:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="legal_disclaimer_description"></span> -->

		            <span class="pdt_text legal_div">
		            	<textarea id="legal_disclaimer_description" class="pdt_text_inputs" placeholder="Legal disclaimer" rows="3" ></textarea>
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Safety Warning:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="safety_warning"></span> -->
		            <span class="pdt_text safety_div">
		            	<textarea id="safety_warning" class="pdt_text_inputs" placeholder="Saftey Warning" rows="3" ></textarea>
		            </span>

		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Proposition 65:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="prop65"></span> -->

		            <span class="pdt_text">
		            	<input type="checkbox" id="prop65">
		            </span>


		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
		            <span class="product_label"><?php _e('Cautionary Statements:','nueve-woocommerce-jet-integration');?></span>
		            <!--<span class="product_text" id="cpsia"></span> -->

		            <span class="pdt_text">
	            	   <input type="checkbox" class="checkbox-inline" name="cpsia_cautionary_statements[]" value="choking hazard small parts" id="cpsia1" > <label class="check_labels" for="cpsia1">choking hazard small parts</label>

                       <br/><input type="checkbox" class="checkbox-inline" name="cpsia_cautionary_statements[]" value="choking hazard is a small ball" id="cpsia2" > <label class="check_labels"  for="cpsia2">choking hazard is a small ball</label>

                       <br/><input type="checkbox" class="checkbox-inline" name="cpsia_cautionary_statements[]" value="choking hazard is a marble" id="cpsia3" > <label class="check_labels"  for="cpsia3">choking hazard is a marble</label>

                       <br/><input type="checkbox" class="checkbox-inline" name="cpsia_cautionary_statements[]" value="choking hazard contains a small ball" id="cpsia4" > <label class="check_labels"  for="cpsia4">choking hazard contains a small ball</label>

                       <br/><input type="checkbox" class="checkbox-inline" name="cpsia_cautionary_statements[]" value="choking hazard contains a marble" id="cpsia5" > <label class="check_labels"  for="cpsia5">choking hazard contains a marble</label>

                       <br/><input type="checkbox" class="checkbox-inline" name="cpsia_cautionary_statements[]" value="choking hazard balloon" id="cpsia6" > <label class="check_labels"  for="cpsia6">choking hazard balloon</label>

		            </span>


		            <div class="clearfix"></div>
		        </div>

		        <div class = "clearfix"></div>

		        <div class="product_data">
					<button type="submit" class="btn btn-lg btn-primary update_product_btn"><?php _e('Update Product','nueve-woocommerce-jet-integration');?></button>
					<div class="clearfix"></div>
				</div>

				<div class="clearfix"></div>
			</div>
			
		</div>
	<?php
	}
?>


