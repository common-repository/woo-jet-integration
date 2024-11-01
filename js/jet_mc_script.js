var $ = jQuery.noConflict();

$(window).load(function(e) {
  
    var plugin_path_link = $('#plugin_path_link').html();
    var jet_path_res = $('#jet_path_res').html();
    var settings_link = $('#settings_link').val();

    $("#jet-loading" ).show();
	$.getScript(plugin_path_link+'js/checkapiaccess.js', function () {          
	    var response = checkaccess();
		if(response != "success") {
			alert(jet_path_res);
			$('#map_category_div').hide();	
			window.location.href = settings_link;	
		} else {
			$("#jet-loading" ).hide();
			$('#map_category_div').show();
			// get mapped category list
    		mapped_category_list();
		} 
	}); 

  

    $('.selectpicker').selectpicker();

	$('#jet_category').on("change", function()   {
		var cat_id = $(this).val();
		var cat_name = $('#jet_category').find('option:selected').text();

		console.log('cat_id:'+cat_id);
		console.log('cat_name:'+$.trim(cat_name) );

	    var jet_cat_id_val = "<select class='selectpicker' id='jet_cat_id' data-live-search='true'>";
	    
	    if(cat_id!='' && cat_name!='') {
	    	jet_cat_id_val +="<option data-tokens='"+cat_name+"' value='"+cat_id+"'>"+cat_name+"</option>";
	    } else {
	    	jet_cat_id_val +="<option data-tokens='' value=''> </option>";
	    }
		jet_cat_id_val +="</select>";

		$('#map_cat1').html(jet_cat_id_val);
		$('#jet_cat_id').selectpicker('refresh');
	});



	$('#map_btn').on("click", function()   {
	    
		var woo_category = $('#woo_category').val();
		var jet_cat_id = $('#jet_cat_id').val();
		var jet_category = $('#jet_category').val();
		var jet_map_category_adding_secure_key = $('#jet_map_category_adding_secure_key').val();

		//console.log('woo_category:'+woo_category+'&jet_cat_id:'+jet_cat_id+'&jet_category:'+jet_category+'&jet_map_category_adding_secure_key:'+jet_map_category_adding_secure_key);

		if(woo_category == '') {
			alert('Please Select Product Category');
			$('#woo_category').focus();
		}else if(jet_cat_id == '') {
			alert('Please Select Jet Category');
			$('#jet_category').focus();
		} else if(woo_category !='' && jet_cat_id!= '' ) {

			$('#cat_img_loader').show();

			$.post( ajaxurl, {
					'action' : 'mapped_add_category',
					'woo_category': woo_category,
					'jet_cat_id' : jet_cat_id,
					'jet_map_category_adding_secure_key' : jet_map_category_adding_secure_key
				},
				function(response) {
					//console.log(response);
					$('#cat_img_loader').hide();
					get_category_values(response);
				}
			);
		}

	});


	$('#jet_cat_id').on('mousedown', function(e) {
	   e.preventDefault();
	   this.blur();
	   window.focus();
	});
	

});



function mapped_category_list() {
	$('#cat_list_img_loader').show();
	var jet_map_category_list_secure_key = $('#jet_map_category_list_secure_key').val();
	$.post(	ajaxurl, {
			'action' : 'mapped_category_list',
			'jet_map_category_list_secure_key' : jet_map_category_list_secure_key
		},
		function(response) {
			//console.log(response);
			var res = $.parseJSON(response);
			var mapped_category_list = res['mapped_category_list'];
			var result = '';
			//console.log('ff:'+mapped_category_list.length);
			if(mapped_category_list.length > 0) {
				result +='<table  class="table table-bordered woocatlisting">';
					result +='<thead class="jet_categories_head">';
						result +='<tr class="map_cat_row1">';
							result +='<th class="map_cat_headers map_cat_header1 text-center">Product Category</th>';
							result +='<th class="map_cat_headers map_cat_header2 text-center">Mapped Jet Category ID</th>';
							result +='<th class="map_cat_headers map_cat_header3 text-center">Action</th>';						
						result +='</tr>';
					result +='</thead>';
					result +='<tbody class="jet_categories_list">';
						for(var i = 0;i<mapped_category_list.length;i++) {
							result += '<tr class="map_cat_row2">';
							result +='<td class="map_cat_data map_cat_data1">'+mapped_category_list[i]['woo_cat_name']+'</td>';
							result +='<td class="map_cat_data map_cat_data2">'+mapped_category_list[i]['jet_cat_id']+'</td>';
							result +='<td class="map_cat_data map_cat_data3">';							
							result +='<button value="'+mapped_category_list[i]['woo_cat_id']+'" class="button button-primary deletemapcat">Delete</button>';
							result +='</td>';
							result +='</tr>';
						}
					result +='</tbody>';
				result +='</table>';
			} else {
				result += '<div id="no_mapping"> No Category is Mapped </div>';
			}

			//console.log(result);
			$('#cat_list_img_loader').hide();
			$('#catlisting').html(result);

			$('.deletemapcat').click(function() {
				var value	=	$(this).val();
				deletemapcat(value);				
			});

			$('#woo_category').val('');
			$('#jet_category').val('');

			var jet_cat_id_val = "<select class='selectpicker' id='jet_cat_id' data-live-search='true'>";
	        	jet_cat_id_val +="<option data-tokens='' value=''> </option>";
				jet_cat_id_val +="</select>";
			$('#map_cat1').html(jet_cat_id_val);
			$('.selectpicker').selectpicker('refresh');
		}
	);
}

function deletemapcat(value) {
	if(confirm("Are you sure you want to delete this category?") ) {
		$('#cat_list_img_loader').show();
		console.log('product_category_id:'+value);
		var jet_map_category_delete_secure_key = $('#jet_map_category_delete_secure_key').val();
		$.post(	ajaxurl, {
				'action' : 'mapped_category_delete',
				'product_category_id': value,
				'jet_map_category_delete_secure_key' : jet_map_category_delete_secure_key
			},
			function(response) {
				//console.log(response);
				get_category_values(response);					
				alert('Category Deleted Successfully');				
			}
		);
	}
}



function get_category_values(response) {
	if(response!='') {
		var ajax_response = $.parseJSON(response);
		var ajax_res = ajax_response['response'];
		if(ajax_res != 'success') {
			alert(ajax_res);
		} else {
			mapped_category_list();
		}
	}	
}


