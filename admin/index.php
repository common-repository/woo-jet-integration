<?php
if ( ! defined( 'ABSPATH' ) ) exit;
require_once(dirname(__FILE__) . '/functions.php');

function nuevejet_admin_tabs() {        
	update_option('jetwebservicesapiurl','https://jetintegration.co/panel/api');
	
 	@admin::nuevejet_manage_tabs();
 	@admin::nuevejet_get_content();   
}

add_action('admin_menu', 'nuevejet_dashboard');

function nuevejet_dashboard() {
	add_menu_page( 'Jet Integration', 'Jet Integration', 'manage_options', 'Jet-Integration', 'nuevejet_admin_tabs' );
}
?>