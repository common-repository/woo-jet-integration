<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$nuevejet_url = nuevejet_url;
$img_loading_link =  $nuevejet_url.'images/loading.gif';
$jet_woo_plugin_url = jet_wordpress_plugin_url;

$jet_get_returns_list_nonce_check = wp_create_nonce('jet_get_returns_list_nonce_check');

if(isset($_REQUEST['return_type']) && ($_REQUEST['return_type']!='') ) {
	$return_type = $_REQUEST['return_type'];
} else {
	$return_type = 'created';
}

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

#returns_list {
	padding-right:10px;
}


#refresh_returns_list, #jetloading, #no-rep, #returns_list, #paginate_div, .first_column {
	display:none;
}

#return_header div {
	display:inline;
}

#return_type_label {
	font-size: 18px;
    font-weight: 700;
    position: relative;
}

#return_type {
	height: 35px;
    margin-left: 10px;
    padding-left: 5px;
    border: 1px solid #999;
    font-weight: 600;
    font-size: 16px;
    border-radius: 5px;
    margin-right: 10px;
}

#jetloading {
	margin-left: 10px;
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

</style>

<br/> 

<div id="return_header">

	<div class="returnstatus">
	    <label class="return-label" id="return_type_label" for="return_type"><?php _e('Return Type','nueve-woocommerce-jet-integration');?></label>
        <select id="return_type" name="return_type" class= "return_type">
            <option value="all" <?php if($return_type == 'all'){ echo 'selected';}?> ><?php _e('All','nueve-woocommerce-jet-integration');?></option>
            <option value="created" <?php if($return_type == 'created'){ echo 'selected';}?> ><?php _e('Created','nueve-woocommerce-jet-integration');?></option>
            <option value="acknowledged" <?php if($return_type == 'acknowledged'){ echo 'selected';}?> ><?php _e('Acknowledged','nueve-woocommerce-jet-integration');?></option>
            <option value="inprogress" <?php if($return_type == 'inprogress'){ echo 'selected';}?> ><?php _e('In Progress','nueve-woocommerce-jet-integration');?></option>
            <option value="completedbymerchant" <?php if($return_type == 'completedbymerchant'){ echo 'selected';}?> ><?php _e('Completed By  Merchant','nueve-woocommerce-jet-integration');?></option>
        </select>
    </div>

    <div id="return_refresh_div">
		<button type="submit" id="refresh_returns_list" class="btn btn-primary"><?php _e('Refresh Returns List','nueve-woocommerce-jet-integration');?></button>	
	</div>

	<div id="load_img_div">
		<img height="50px" width="50px" id="jetloading"  src="<?php esc_url( _e($img_loading_link,'nueve-woocommerce-jet-integration') ); ?> ">
	</div>

</div>

<input type="hidden" value="<?php _e($jet_woo_plugin_url,'nueve-woocommerce-jet-integration'); ?>"
  id="jet_woo_plugin_url">

<input type="hidden" name="jet_get_returns_list_secure_key"
 value="<?php _e($jet_get_returns_list_nonce_check,'nueve-woocommerce-jet-integration'); ?>"
  id="jet_get_returns_list_secure_key">
  

<input type="hidden" name="cur_page" value="<?php echo $cur_page;?>"  id="cur_page">
<input type="hidden" name="page_limit" value="<?php echo $page_limit;?>"  id="page_limit">

<br/>

<div class="alert">
	<a href="#" class="close">&times;</a>
	<span class="alert-text"></span>
</div>

<br/>

<div id="no-rep"><?php _e('No Returns Available','nueve-woocommerce-jet-integration');?></div>

<div id="returns_list">
	<table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="manage-column column-name sortable first_column" id="jet_return_list_id" scope="col"><?php _e('ID','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-name sortable" id="jet_return_date" scope="col"><?php _e('Return Date','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-name sortable" id="jet_return_authorization_id" scope="col"><?php _e('Return Authorization ID','nueve-woocommerce-jet-integration');?></th>				
				<th class="manage-column column-name sortable" id="order_id" scope="col"><?php _e('Order ID','nueve-woocommerce-jet-integration');?></th>
				<th class="manage-column column-price sortable" id="jet_return_status" scope="col"><?php _e('Return Status','nueve-woocommerce-jet-integration');?></th>	
				<th class="manage-column column-qty sortable no-sort" id="action" scope="col"><?php _e('Action','nueve-woocommerce-jet-integration');?></th> 
			</tr>
		</thead>
		<tbody id="dataTable_row"></tbody>
	</table>
</div>

<div id="paginate_div"></div>

