<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// drop a custom database table

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}nueve_jet_attributes_table");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jeterrorfileinfo" );
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jetfileinfo" );

// for site options in Multisite

delete_option('jetwebservicesapiurl');
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

$jetmappedArray	=	get_option('NueveWooJetMapping',false);

foreach($jetmappedArray as $wooid => $jetCatId) {
	delete_option($jetCatId.'_NueveJetAttributes');
}

delete_option('NueveWooJetMapping');

// Clear any cached data that has been removed
wp_cache_flush();
?>
