var $ = jQuery.noConflict();

$(window).load(function(e) {
	console.log('products');

	clear_msg();

	var plugin_path_link = $('#plugin_path_link').html();
    var jet_path_res = $('#jet_path_res').html();
    var settings_link = $('#settings_link').val();

    $("#jet-loading" ).show();
   
    var selectproducts = '<input type="checkbox" id="woo-products-select-all">';

    $('#dataTable').DataTable( {
        columns:[
            {title: selectproducts}, {title: 'ID'},{title: 'Image'},{title: 'Merchant SKU'},{title: 'Parent SKU'},{title: 'Product Title'},
            {title: 'Price'},{title: 'Inventory'}, {title: 'Category'},{title: 'Jet Product Status'},{title: 'Action'}
        ],
        "iDisplayLength": 100,
        "order": [[ 1, "desc" ]],  
        "columnDefs": [ {
            "targets": 'no-sort',
            "orderable": false
        }, {
            "targets": [ 1 ],
            "visible": false,
            "searchable": false
        }] 
    });

    $.getScript(plugin_path_link+'js/checkapiaccess.js', function () {          
	    var response = checkaccess();
		if(response != "success") {
			alert(jet_path_res);
			window.location.href = settings_link;
		} else {
			$("#jet-loading" ).hide();
			get_woo_products_list();
		} 
	});

	
    $("#woo-products-select-all").change(function(){  
	    $(".unique_check").prop('checked', $(this).prop("checked")); 
	});

	$('.upload_btns').click(function() {
		clear_msg();
		var btn_type = $(this).attr('btn_type');
		console.log('btn_type:'+btn_type);
		if(btn_type == 'upload' || btn_type == 'archive' || btn_type == 'unarchive') {

			var all_products = getproductids();

			//console.log('all_products:'+all_products);

		 	if(all_products.length == 0){

		 		var alert_text = 'Please Select any Product To ';

		 		if(btn_type == 'upload'){
		 			alert_text+= 'Upload';
		 		} else if(btn_type == 'archive'){
		 			alert_text+= 'Archive';
		 		} else if(btn_type == 'unarchive'){
		 			alert_text+= 'UnArchive';
		 		}
	 			alert(alert_text);
	 		} else {
	 			$("#jet-loading" ).show();	 
				var jet_upload_products_secure_key = $('#jet_upload_products_secure_key').val();
 				$.post(	ajaxurl,{
	 				'action' : 'jet_upload_product',
	 				'upload_type':btn_type,
	 				'all_product_ids':all_products,
	 				'jet_upload_products_secure_key':jet_upload_products_secure_key
		 			},
		 			function(response){
		 				console.log(response);
		 				$("#jet-loading").hide();
		 				show_alert(response);

	 					if(btn_type == 'upload') {
	 						get_product_status();
		 				} else {
		 					get_woo_products_list();
		 				}		 				
		 			}
 				);
	 		}
		} else if (btn_type == 'update_product_status') {
			get_product_status();
		}	
	});

	$('.close').click(function(e){
		e.preventDefault();
		$('.alert').hide();
	});
});

function get_woo_products_list() {

	$('#jet-loading').show();
	var jet_get_woo_products_secure_key = $('#jet_get_woo_products_secure_key').val();

	$.post(	ajaxurl, {
		'action' : 'jet_get_woo_products_list',
		'jet_get_woo_products_secure_key' : jet_get_woo_products_secure_key
		},
		function(response) {		
			//console.log(response);
			var table = $('#dataTable').DataTable(); 
            table.rows().remove().draw();

			if(response!= '') {
				var product_data = $.parseJSON(response);
				//console.log('products:'+product_data);
				//console.log('products length:'+product_data.length);

				if(product_data.length == 0)  {
					$('#jet-loading').hide();
	                $('#woo_products_list').hide();
	                $('.upload_btns').hide();
	                $('#no-rep').show();                
				} else {
					for(i=0;i<product_data.length;i++)	{ 

	                	$('#no-rep').hide();
	                	$('#woo_products_list').show();

	                	var product_id = product_data[i]['product_id'];
	                	var product_image = product_data[i]['product_image'];
	                	var product_sku = product_data[i]['product_sku'];
	                	var parent_sku = product_data[i]['parent_sku'];
	                	var product_title = product_data[i]['product_title'];
	                	var product_price = product_data[i]['product_price'];
	                	var product_stock = product_data[i]['product_stock'];
	                	var product_category = product_data[i]['product_category'];
	                	var product_status = product_data[i]['product_status'];
	                	var product_details_link = product_data[i]['product_details_link'];
	                	
	                	var product_select_div = '<span class="product_row"><input type="checkbox"  value="'+product_id+'" class="unique_check" name="unique_post[]" id="cb-select-'+product_id+'"></span>';
						var product_actions ='<a href="'+product_details_link+'" title="view" class="view_data">View Details</a>&nbsp;'; 
	       
	                	table.row.add([ product_select_div,
	                					product_id,
	                                    product_image,
	                                    product_sku,
	                                    parent_sku,
	                                    product_title,
	                                    product_price,
	                                    product_stock,
	                                    product_category,
	                                    product_status,
	                                    product_actions] ).draw();	

		                if(i == (product_data.length - 1)) {
		                    $('#jet-loading').hide();
		                    $('.upload_btns').show();
		                    $('#woo-products-select-all').prop('checked', false);
		                }
	                }
				}
			} else {
				$('#jet-loading').hide();
                $('#woo_products_list').hide();
                $('.upload_btns').hide();
                $('#no-rep').show(); 
			}
		}
	);
}


function get_product_status() {

	$("#jet-loading" ).show();
	var jet_product_status_secure_key = $('#jet_product_status_secure_key').val();

	$.post( ajaxurl, {
			'action' : 'jet_update_product_status',
			'jet_product_status_secure_key':jet_product_status_secure_key
		},
		function(response) {
			console.log('response:'+response);
			$("#jet-loading").hide();
			get_woo_products_list();
		}
	);
}


function getproductids() {
	var all_upload_product = new Array();
	var i = 0;

	$('.product_row').each(function(){
 		if($(this).find('.unique_check').is(':checked')) {
 			all_upload_product[i] = $(this).find('.unique_check').val();
 			console.log(all_upload_product);
 			i++;
 		}
 	});

 	return all_upload_product;
}


function show_alert(msg) {	
	$('.alert-text').html(msg);
	$('.alert').show();	
}


function clear_msg() {
	$('.alert').hide();
	$('.alert-text').html('');
}



