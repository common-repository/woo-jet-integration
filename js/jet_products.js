var $ = jQuery.noConflict();

$(window).load(function(e) {
	console.log('jet products');

    clear_msg();

	var plugin_path_link = $('#plugin_path_link').html();
    var jet_path_res = $('#jet_path_res').html();
    var settings_link = $('#settings_link').val();

    $("#jet-loading" ).show();

    $('#refresh_products_list').click(function(e)  { 
        clear_msg(); 
        e.preventDefault();        
        $("#jet-loading" ).show();        
        var jet_refresh_data_secure_key = $('#jet_refresh_data_secure_key').val();
        var cron_type = 'products';

        $.post( ajaxurl, {
                'action' : 'jet_refresh_data',
                'cron_type' : cron_type,
                'jet_refresh_data_secure_key' : jet_refresh_data_secure_key
            },
            function(res) {
                $("#jet-loading" ).hide();
                console.log(res);
                var cron_response = 'We just added your request to our queue. Your '+cron_type+' will updated in 10-15 minutes.';
                pageTop();
                show_alert(cron_response); 
                setTimeout(clear_msg, 10000);                            
            }
        );
    });

   
	$.getScript(plugin_path_link+'js/checkapiaccess.js', function () {          
	    var response = checkaccess();
		if(response != "success") {
			alert(jet_path_res);
			window.location.href = settings_link;
		} else {
			$("#jet-loading" ).hide();
			getallproducts();
		} 
	}); 

    $('.upld_btns').click(function() {
        clear_msg();
        var btn_type = $(this).attr('btn_type');
        console.log('btn_type:'+btn_type);
        if(btn_type == 'archive' || btn_type == 'unarchive') {
            var all_products = getproductids();
            console.log(all_products);
            if(all_products.length == 0){
                var alert_text = 'Please Select any Product To ';
                if(btn_type == 'archive'){
                    alert_text+= 'Archive';
                } else if(btn_type == 'unarchive'){
                    alert_text+= 'UnArchive';
                }
                alert(alert_text);
            } else {
                $("#jet-loading" ).show();   
                var jet_oupload_products_secure_key = $('#jet_oupload_products_secure_key').val();

                $.post( ajaxurl,{
                    'action' : 'jet_oupload_product',
                    'upload_type':btn_type,
                    'all_product_ids':all_products,
                    'jet_oupload_products_secure_key':jet_oupload_products_secure_key
                    },
                    function(response){
                        console.log(response);
                        $("#jet-loading").hide();
                        pageTop();
                        show_alert(response);                        
                        getallproducts();                       
                    }
                );
            }
        }
    });	

    $('.close').click(function(e){
        e.preventDefault();
        $('.alert').hide();
    });
});


function getproductids() {
    var all_upload_product = new Array();
    var i = 0;

    $('.product_row').each(function(){
        if($(this).find('.unique_check').is(':checked')) {
            var unique_check = $(this).find('.unique_check');
            all_upload_product[i] = unique_check.val()+'/'+unique_check.attr('wooproductid');
            console.log(all_upload_product);
            i++;
        }
    });

    return all_upload_product;
}


function getallproducts() {
    var cur_page = $('#cur_page').val();    
    var page_limit = $('#page_limit').val();
	var product_type = $('#product_type').val();
	console.log('product_type:'+product_type+'&cur_page='+cur_page+'&page_limit='+page_limit);

	$('#jetloading').show();
	$('#refresh_products_list').hide();
    $('.upld_btns').hide();

	var jet_get_products_list_secure_key = $('#jet_get_products_list_secure_key').val();
	var jet_path_res = $('#jet_path_res').html();
    var settings_link = $('#settings_link').val();
    var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();

	$.post(	ajaxurl, {
			'action' : 'jet_get_products_list',
			'product_type': product_type,
            'cur_page' : cur_page,
            'page_limit' : page_limit,
			'jet_get_products_list_secure_key' : jet_get_products_list_secure_key
		},
		function(response) {
            //console.log(response);
			if(response!= '') {
				if(response == 'invalid login details') {                    
                    $('#refresh_products_list').hide();
                    hide_details();
					alert(jet_path_res);
					window.location.href = settings_link;
				} else {
					var p_datas = $.parseJSON(response);
					//console.log('products:'+p_datas);
                    var products_count = p_datas.products_count;                  

					if(products_count == 0)  {
                       show_hide();
                	} else {
                        var product_data = p_datas.products_data;
                        //console.log('products length:'+product_data.length);
                        var p_data = '';        
                		for(i=0;i<product_data.length;i++)	{ 
                            if(i == 0){
                                $('#no-rep').hide();
                                $('#products_list').show();
                            }                			
                            var product_id = product_data[i]['product_id'];    
                			var merchant_sku = product_data[i]['merchant_sku'];                                                 
                            var parent_sku = product_data[i]['parent_sku'];
                            var product_title = product_data[i]['product_title'];
                            var product_status = product_data[i]['product_status'];
                            var price = product_data[i]['price'];
                            var inventory = product_data[i]['inventory'];
                            var main_image_url = product_data[i]['main_image_url'];
                            var jet_sku = product_data[i]['jet_sku'];
                            var woo_product_id = product_data[i]['woo_product_id'];
                            var product_source = product_data[i]['product_source'];
                            

                            var status_color ='#000';
                            var jet_view = '';
                            var quantity = 0;
                			var pdt_status = 'Archived';  

                            if(product_type == 'active') {

                				quantity = inventory;
                				pdt_status = product_status;                				

                				if(pdt_status == 'Under Jet Review')  {
                                	status_color ='#580079';
	                            } else if(pdt_status == 'Available for Purchase')   {
	                                status_color ='#0a0';
	                                if(jet_sku!='') {
	                                    jet_view = '<br/><a class="jet_view_link" target="_blank" href="https://jet.com/search?term='+jet_sku+'">View on Jet</a>';
	                                }
	                            }  
                			}                            

                            var imgdiv = '<img src="'+main_image_url+'" class="product_image">';
                            var prdt_status = '<span style="font-weight:700;color:'+status_color+'">'+pdt_status+jet_view+'</span>';
                		
                            var product_select_div = '<span class="product_row"><input type="checkbox"  value="'+merchant_sku+'" wooproductid = "'+woo_product_id+'"  class="unique_check" name="unique_post[]" id="cb-select-'+merchant_sku+'"></span>';
    
                            var product_view_link;
                            if(product_source == 'wordpress' && woo_product_id!=''){
                                var post_url = $('#post_url').html();
                                product_view_link = post_url+woo_product_id+'&action=edit';
                            } else {
                              product_view_link = jet_woo_plugin_url+'&tab=jet-product-view&product_sku='+merchant_sku;
                            }
                			var product_actions ='<a href="'+product_view_link+'" title="view" class="view_data">View Details</a>&nbsp;'; 
                			
                            var price_div = '<input type="number" step="0.01" class="form-control form-input pdt_price"  id="'+product_id+'price" value="'+price+'">';
                                price_div += '<button class="btn btn-primary btn-sm price_update" pid="'+product_id+'" psku="'+merchant_sku+'" wooproductid = "'+woo_product_id+'">Update</button>';
                                price_div += '<div id="'+product_id+'ps" class="pdt_msg_status">Price Updated</div>';

                            var inv_div = '<input type="number" step="1" class="form-control form-input pdt_inventory"  id="'+product_id+'inventory" value="'+quantity+'">';
                                inv_div += '<button class="btn btn-primary btn-sm inventory_update" pid="'+product_id+'" psku="'+merchant_sku+'" wooproductid = "'+woo_product_id+'">Update</button>';
                                inv_div += '<div id="'+product_id+'is" class="pdt_msg_status">Inventory Updated</div>';

                            p_data+='<tr>';
                                p_data+='<td>'+product_select_div+'</td>';
                                p_data+='<td>'+imgdiv+'</td>';
                                p_data+='<td>'+merchant_sku+'</td>';
                                p_data+='<td>'+parent_sku+'</td>';
                                p_data+='<td>'+product_title+'</td>';
                                p_data+='<td>'+price_div+'</td>';
                                p_data+='<td>'+inv_div+'</td>';
                                p_data+='<td>'+prdt_status+'</td>';
                                p_data+='<td>'+product_actions+'</td>';
                            p_data+='</tr>';

                			if(i == (product_data.length - 1)) {
                                $('#jetloading').hide();
                                $('#refresh_products_list').show();
                                $('.upld_btns').show();
                                $('#products-select-all').prop('checked', false);
                            }
                    	}

                        //console.log(p_data);

                        $('#dataTable_row').html('');
                        $('#dataTable_row').append(p_data);

                        getpagination(products_count);

                        $("#products-select-all").change(function(){  
                            $(".unique_check").prop('checked', $(this).prop("checked"));
                        });

                        $('.inventory_update').click(function() {
                            clear_msg();
                            var jet_pdt_inventory_update_secure_key = $('#jet_pdt_inventory_update_secure_key').val();
                            var wooproductid = $(this).attr('wooproductid');
                            var psku = $(this).attr('psku');
                            var pid = $(this).attr('pid');                            
                            var inventory = $("#"+pid+"inventory").val();
                            console.log(pid+'/'+psku+'/'+inventory+'/'+jet_pdt_inventory_update_secure_key+'/'+wooproductid);
                            if(inventory == '') {                                
                                $("#"+pid+"inventory").focus();
                            } else {
                                $('#jetloading').show();
                                $.post( ajaxurl,{
                                    'action' : 'jet_product_update_inventory',
                                    'psku': psku,
                                    'wooproductid': wooproductid,
                                    'inventory' : inventory,
                                    'jet_pdt_inventory_update_secure_key':jet_pdt_inventory_update_secure_key
                                    },
                                    function(response){
                                        console.log(response);
                                        if(response!= 'success') {
                                            pageTop();
                                            show_alert(response);
                                        } else {
                                            $("#"+pid+"is").show();
                                            setTimeout(clearmsg, 3000); 
                                        }                                        
                                        $('#jetloading').hide();
                                    }
                                );
                            }                           
                        });

                        $('.price_update').click(function() {
                            clear_msg();
                            var jet_pdt_price_update_secure_key = $('#jet_pdt_price_update_secure_key').val();
                            var wooproductid = $(this).attr('wooproductid');
                            var psku = $(this).attr('psku');
                            var pid = $(this).attr('pid');
                            var price = $("#"+pid+"price").val();
                            console.log(pid+'/'+psku+'/'+price+'/'+jet_pdt_price_update_secure_key+'/'+wooproductid);
                            if(price == '' || price == 0) {
                                $("#"+pid+"price").focus();
                            } else {
                                $('#jetloading').show();
                                $.post( ajaxurl,{
                                    'action' : 'jet_product_update_price',
                                    'psku': psku,
                                    'wooproductid': wooproductid,
                                    'price' : price,
                                    'jet_pdt_price_update_secure_key':jet_pdt_price_update_secure_key
                                    },
                                    function(response){
                                        console.log(response);
                                        if(response!= 'success') {
                                            pageTop();
                                            show_alert(response);
                                        } else {
                                            $("#"+pid+"ps").show();
                                            setTimeout(clearmsg, 3000); 
                                        }                                        
                                        $('#jetloading').hide();                     
                                    }
                                );
                            }                           
                        });

                	}
				}	
			} else {
                show_hide();
			}
		}
	);
}

function clearmsg() {
    $('.pdt_msg_status').hide();
}


function show_hide() {
    hide_details();
    $('#refresh_products_list').show();
}


function hide_details() {
    $('#jetloading').hide();
    $('#no-rep').show();
    $('#products_list').hide();
    $('.upld_btns').hide();
    $('#paginate_div').html('');
}

function  getpagination(products_count) {

    var page_limit = $('#page_limit').val();    

    var p_count;
    var pdt_data='';
    if(products_count > page_limit) {
        var p_count = Math.ceil(products_count/page_limit);
        //console.log(page_limit+'/'+p_count);

        var cur_page = $('#cur_page').val();
        var previous_count = parseInt(parseInt(cur_page)-parseInt(1));      
        var previous_page_class = '';
        if(cur_page == 1) {
            previous_page_class = 'disabled';
        }

        var next_count = parseInt(parseInt(cur_page)+parseInt(1)); 
        var next_page_class = '';
        if(cur_page == p_count) {
            next_page_class = 'disabled';
        }

        pdt_data+='<ul class="pagination">';

            pdt_data+='<li cur_page="'+previous_count+'" class="page_li paginate_button '+previous_page_class+' ">Previous</li>';
            for(j=1;j<=p_count;j++){   
                var page_lid_id = 'page_li'+j;
                pdt_data+='<li cur_page="'+j+'" class="page_li" id="'+page_lid_id+'">'+j+'</li>';
            }        
            pdt_data+='<li cur_page="'+next_count+'" class="page_li paginate_button '+next_page_class+' ">Next</li>';

        pdt_data+='</ul>';
    }

    $('#paginate_div').html('');
    $('#paginate_div').html(pdt_data);
    $('#paginate_div').show();

    var cur_page = $('#cur_page').val();
    $('.page_li').removeClass('active');
    $('#page_li'+cur_page).addClass('active');

    $('.page_li').click(function() {

        var disabled_class = $(this).hasClass("disabled");

        if(!disabled_class) {
            pageTop();

            var cur_page_li = $(this).attr('cur_page');
            $('.page_li').removeClass('active');
            $('#page_li'+cur_page_li).addClass('active');
            $('#cur_page').val(cur_page_li);
            console.log(cur_page_li);

            getallproducts();
        }
    });

    //console.log(pdt_data);
    //console.log(products_count);
}


function show_alert(msg) {  
    $('.alert-text').html(msg);
    $('.alert').show(); 
}


function pageTop()
{
    $('html, body').animate({
        'scrollTop' : $('.jetintgration_menus').position().top
    });
}


function clear_msg() {
    $('.alert').hide();
    $('.alert-text').html('');
}

