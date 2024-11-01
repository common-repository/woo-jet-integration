var $ = jQuery.noConflict();

$(window).load(function(e) {
	console.log('jet orders');

	clear_msg();

	var plugin_path_link = $('#plugin_path_link').html();
    var jet_path_res = $('#jet_path_res').html();
    var settings_link = $('#settings_link').val();

    $("#jet-loading" ).show();

    $('#refresh_orders_list').click(function(e)  { 
        clear_msg(); 
        e.preventDefault();        
        $("#jet-loading" ).show();        
        var jet_refresh_data_secure_key = $('#jet_refresh_data_secure_key').val();
        var cron_type = 'orders';

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


    $('#order_type').change(function(e)  {  
        e.preventDefault();
        $('#cur_page').val(1);
        getallorders();
    });

    
	$.getScript(plugin_path_link+'js/checkapiaccess.js', function () {          
	    var response = checkaccess();
		if(response != "success") {
			alert(jet_path_res);
			window.location.href = settings_link;
		} else {
			$("#jet-loading" ).hide();
			getallorders();
		} 
	}); 

	$('.close').click(function(e){
        e.preventDefault();
        $('.alert').hide();
    });
	
});

function getallorders() {
	var cur_page = $('#cur_page').val();    
    var page_limit = $('#page_limit').val();
	var order_type = $('#order_type').val();
	console.log('order_type:'+order_type);

	if(order_type!= '') {

		if (history.pushState) {
          	var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?page=Jet-Integration&tab=jet-orders&order_type='+order_type;
          	window.history.pushState({path:newurl},'',newurl);
        }

		$('#jetloading').show();
		$('#refresh_orders_list').hide();

		var jet_get_orders_list_secure_key = $('#jet_get_orders_list_secure_key').val();
		var jet_path_res = $('#jet_path_res').html();
	    var settings_link = $('#settings_link').val();
	    var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();

		$.post(	ajaxurl, {
				'action' : 'jet_get_orders_list',
				'order_type': order_type,
				'cur_page' : cur_page,
            	'page_limit' : page_limit,
				'jet_get_orders_list_secure_key' : jet_get_orders_list_secure_key
			},
			function(response) {
				//console.log(response);

				if(response!= '') {
					if(response == 'invalid login details') {                    
	                    $('#refresh_orders_list').hide();
	                    hide_details();
						alert(jet_path_res);
						window.location.href = settings_link;
					} else {
						var o_datas = $.parseJSON(response);
						//console.log('orders:'+o_datas);
	                    var orders_count = o_datas.orders_count;
	                    
						if(orders_count == 0)  {
	                       show_hide();
	                	} else {
	                		var order_data = o_datas.orders_data;
							//console.log('orders length:'+order_data.length);
	                		var o_data = '';  
	                		for(i=0;i<order_data.length;i++)	{ 
	                            if(i == 0){
	                                $('#no-rep').hide();
	                                $('#orders_list').show();
	                            }
	                            var id = order_data[i]['id'];
		                        var merchant_order_id = order_data[i]['merchant_order_id'];
		                        var reference_order_id = order_data[i]['reference_order_id'];
		                        var order_placed_date = order_data[i]['order_placed_date'];
		                        var status = order_data[i]['status'];
		                        var merchant_sku = order_data[i]['merchant_sku'];
		                        var ship_order_quantity = order_data[i]['ship_order_quantity'];
		                        var cancel_quantity = order_data[i]['cancel_order_quantity'];
		                        var order_item_id = order_data[i]['order_item_id'];
		                        var exception_state = order_data[i]['exception_state']; 
		                        var cancel_order_quantity = ship_order_quantity;

	                            var order_view_link =   jet_woo_plugin_url+'&tab=jet-order-view&order_id='+merchant_order_id;
	                            var order_actions ='<a href="'+order_view_link+'" title="view" class="view_data">View Details</a>&nbsp;'; 
	                			
	                			var exception_state_div = '';
		                        if(exception_state!='') {
		                           var exception_state_div = '<br/><span style="color:red;font-size:13px;">'+exception_state+'</span>';
		                        }  
		                        var order_status_div = '<span style="text-transform:capitalize;">'+status+'</span>';
		                        var order_status = order_status_div+exception_state_div;                 			

	                            o_data+='<tr>';
	                                o_data+='<td class="first_column">'+id+'</td>';
	                                o_data+='<td>'+order_placed_date+'</td>';
	                                o_data+='<td>'+order_status+'</td>';
	                                o_data+='<td>'+merchant_order_id+'</td>';
	                                o_data+='<td>'+reference_order_id+'</td>';
	                                o_data+='<td>'+merchant_sku+'</td>';
	                                o_data+='<td>'+ship_order_quantity+'</td>';
	                                o_data+='<td>'+cancel_quantity+'</td>';
	                                o_data+='<td>'+order_actions+'</td>';
	                            o_data+='</tr>';

	                			if(i == (order_data.length - 1)) {
	                                $('#jetloading').hide();
	                                $('#refresh_orders_list').show();
	                            }
	                        }

	                        $('#dataTable_row').html('');
	                        $('#dataTable_row').append(o_data);

	                        getpagination(orders_count);
	                	}
					}
				} else {
					show_hide();
				}
			}
		);
	}

}

function hide_details() {
    $('#jetloading').hide();
    $('#no-rep').show();
    $('#orders_list').hide();
    $('#paginate_div').html('');
}

function show_hide() {
    hide_details();
    $('#refresh_orders_list').show();
}

function  getpagination(orders_count) {

    var page_limit = $('#page_limit').val();    

    var o_count;
    var odt_data='';
    if(orders_count > page_limit) {
        var o_count = Math.ceil(orders_count/page_limit);
        //console.log(page_limit+'/'+o_count);

        var cur_page = $('#cur_page').val();
        var previous_count = parseInt(parseInt(cur_page)-parseInt(1));      
        var previous_page_class = '';
        if(cur_page == 1) {
            previous_page_class = 'disabled';
        }

        var next_count = parseInt(parseInt(cur_page)+parseInt(1)); 
        var next_page_class = '';
        if(cur_page == o_count) {
            next_page_class = 'disabled';
        }

        odt_data+='<ul class="pagination">';

            odt_data+='<li cur_page="'+previous_count+'" class="page_li paginate_button '+previous_page_class+' ">Previous</li>';
            for(j=1;j<=o_count;j++){   
                var page_lid_id = 'page_li'+j;
                odt_data+='<li cur_page="'+j+'" class="page_li" id="'+page_lid_id+'">'+j+'</li>';
            }        
            odt_data+='<li cur_page="'+next_count+'" class="page_li paginate_button '+next_page_class+' ">Next</li>';

        odt_data+='</ul>';
    }

    $('#paginate_div').html('');
    $('#paginate_div').html(odt_data);
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

            getallorders();
        }
    });

    //console.log(odt_data);
   //console.log(orders_count);
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

