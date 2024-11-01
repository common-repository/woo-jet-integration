<?php 
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $wpdb;

// woocommerce categories

$taxonomy     = 'product_cat';
$orderby      = 'name';
$empty        = 0;

$args = array(
	'taxonomy'     => $taxonomy,
	'orderby'      => $orderby,
	'hide_empty'   => $empty
	);

$all_categories = get_categories($args);
//jet categories
$get_jetcategories = @admin::get_jetcategories();
$get_jetcategories = json_decode($get_jetcategories,true);

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';

$jet_map_category_adding_nonce_check = wp_create_nonce('jet_map_category_adding_nonce_check');
$jet_map_category_list_nonce_check = wp_create_nonce('jet_map_category_list_nonce_check');
$jet_map_category_delete_nonce_check = wp_create_nonce('jet_map_category_delete_nonce_check');
?>

<input type="hidden" name="jet_map_category_adding_secure_key" 
value="<?php _e($jet_map_category_adding_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
id="jet_map_category_adding_secure_key">
<input type="hidden" name="jet_map_category_list_secure_key" 
value="<?php _e($jet_map_category_list_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
id="jet_map_category_list_secure_key">
<input type="hidden" name="jet_map_category_delete_secure_key" 
value="<?php _e($jet_map_category_delete_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
id="jet_map_category_delete_secure_key">

<div id="map_category_div" style="display:none;">

	<table class="table table-bordered category_tbl">

		<tr class="cat_row">
			<th class="cat_header text-center"><?php _e('Product Categories','nueve-woocommerce-jet-integration'); ?></th>
			<th class="cat_header text-center"><?php _e('Jet Categories','nueve-woocommerce-jet-integration'); ?></th>
		</tr>

		<tr class="cat_row2">
			<td class="cat_row_divs text-center"> 
				<select class="selectpicker" id="woo_category" data-live-search="true">
					<option data-tokens="" value=""><?php _e('Select Product Category','nueve-woocommerce-jet-integration'); ?></option>
					<?php 
					$categoriesArray = array();
					foreach($all_categories as $woo_category) {
						$categoriesArray[$woo_category->term_id] =	$woo_category->cat_name;
						$cat_name = $woo_category->cat_name;
						$term_id = $woo_category->term_id;
					?>
					 	<option data-tokens="<?php _e($cat_name,'nueve-woocommerce-jet-integration'); ?>"  value="<?php _e($term_id,'nueve-woocommerce-jet-integration'); ?>" > 
					 		<?php _e($cat_name,'nueve-woocommerce-jet-integration'); ?>
					 	</option>
					<?php
					}
					?>
				</select>
			</td>

			<td class="cat_row_divs"> 

				<div id="mapped_div1">
				    
				    <div id="map_cat1">
    					<select class="selectpicker" id="jet_cat_id" data-live-search="true">
    						<option data-tokens="" value=""> </option>
    					</select>
					</div>

					<br/> 

					<select class="selectpicker" id="jet_category" data-live-search="true">
						<option data-tokens="" value=""><?php _e('Select Jet Category','nueve-woocommerce-jet-integration'); ?></option>
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
					
					<br/> <br/>

				</div>

				<div id="mapped_div2">

                    <img height="40px" width="40px" id="cat_img_loader" 
                    src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?>" >
                     
					<button  class="button button-primary" id="map_btn"><?php _e('MAP','nueve-woocommerce-jet-integration'); ?></button>
				</div>

			</td>
		</tr>
	</table>	

	<img height="30px" width="30px" id="cat_list_img_loader"
	src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">

	<div id="catlisting">  </div>
		
</div>


