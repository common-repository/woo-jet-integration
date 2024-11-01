
jQuery(document).ready(function() {
	setTimeout(clearflash, 3000);

	jQuery('#Jet_PriceSelect').change(function() {
		var selected = jQuery(this).val();
		console.log('price selected:'+selected);
		if(selected == 'main_price'){
			jQuery('#JetPriceField').hide();
		} else if(selected == 'main_price') {
			jQuery('#JetPriceField').hide();
		} else if(selected == 'otherPrice')	{
			jQuery('#JetPriceField').show();
		}
	});
	
	jQuery('#Jet_StockSelect').change(function() {
		var selected = jQuery(this).val();
		console.log('stock selected:'+selected);
		if(selected == 'central')	{
			jQuery('#JetStockField').hide();
		}	else if(selected == 'other') {
			jQuery('#JetStockField').show();
		}
	});

	jQuery(".expand-image").click(function(){
		var divId	=	jQuery(this).attr("value");
		console.log('divId:'+divId);
		jQuery("#"+divId).toggle();
	});

	jQuery('select#product-type').change( function () {

		var select_val = jQuery( this ).val();		
		if(	'simple'	===	select_val	){
			jQuery('.custom_tab').show();
			jQuery('#jet_attribute_settings').show();
			jQuery('#jet_extra_attribute_settings').show();
		} else {
			jQuery('.custom_tab').hide();
			jQuery('#jet_attribute_settings').hide();
			jQuery('#jet_extra_attribute_settings').hide();
		}

	}).change();

});

function clearflash() {
    jQuery('#success_message').html('');
}

