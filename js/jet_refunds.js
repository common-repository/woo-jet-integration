var $ = jQuery.noConflict();

$(window).load(function(e) {
	console.log('jet refunds');

	clear_msg();

	var plugin_path_link = $('#plugin_path_link').html();
    var jet_path_res = $('#jet_path_res').html();
    var settings_link = $('#settings_link').val();

    $("#jet-loading" ).show();

    $('#refresh_refunds_list').click(function(e)  { 
        clear_msg(); 
        e.preventDefault();        
        $("#jet-loading" ).show();        
        var jet_refresh_data_secure_key = $('#jet_refresh_data_secure_key').val();
        var cron_type = 'refunds';

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

    $('#refund_type').change(function(e)  {  
        e.preventDefault();
        $('#cur_page').val(1);
        getallrefunds();
    });

	$.getScript(plugin_path_link+'js/checkapiaccess.js', function () {          
	    var response = checkaccess();
		if(response != "success") {
			alert(jet_path_res);
			window.location.href = settings_link;
		} else {
			$("#jet-loading" ).hide();
			getallrefunds();
		} 
	}); 


    $('.close').click(function(e){
        e.preventDefault();
        $('.alert').hide();
    });
	
});

function getallrefunds() {

	var cur_page = $('#cur_page').val();    
    var page_limit = $('#page_limit').val();
	var refund_type = $('#refund_type').val();
	console.log('refund_type:'+refund_type);

	if(refund_type!= '') {

	    if (history.pushState) {
          	var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?page=Jet-Integration&tab=jet-refunds&refund_type='+refund_type;
          	window.history.pushState({path:newurl},'',newurl);
        }

		$('#jetloading').show();
		$('#refresh_refunds_list').hide();

		var jet_get_refunds_list_secure_key = $('#jet_get_refunds_list_secure_key').val();
		var jet_path_res = $('#jet_path_res').html();
	    var settings_link = $('#settings_link').val();
	    var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();

		$.post(	ajaxurl, {
				'action' : 'get_jet_refunds_list',
				'refund_type': refund_type,
				'cur_page' : cur_page,
            	'page_limit' : page_limit,
				'jet_get_refunds_list_secure_key' : jet_get_refunds_list_secure_key
			},
			function(response) {
				//console.log(response);				

				if(response!= '') {
					if(response == 'invalid login details') {
						$('#refresh_refunds_list').hide();
						hide_details();
						alert(jet_path_res);
						window.location.href = settings_link;
					} else {
						var rf_datas = $.parseJSON(response);
						//console.log('refunds:'+rf_datas);
	                    var refunds_count = rf_datas.refunds_count;
	                    
						if(refunds_count == 0)  {
	                       show_hide();
	                	} else {
	                		var refund_data = rf_datas.refunds_data;
							//console.log('refunds length:'+refund_data.length);
	                		var rf_data = '';  
	                		for(i=0;i<refund_data.length;i++)	{ 
	                            if(i == 0){
	                                $('#no-rep').hide();
	                                $('#refunds_list').show();
	                            }

	                            var id = refund_data[i]['id'];
		                        var refund_authorization_id = refund_data[i]['refund_authorization_id'];
		                        var merchant_order_id = refund_data[i]['merchant_order_id'];
		                        var refund_status = refund_data[i]['refund_status'];
		                        var refund_status_div = '<span style="text-transform:capitalize;">'+refund_status+'</span>';
		                       	                        
		                        var refund_view_link =   jet_woo_plugin_url+'&tab=jet-refund-view&refund_id='+refund_authorization_id;
	                            var refund_actions ='<a href="'+refund_view_link+'" title="view" class="view_data">View Details</a>&nbsp;'; 
	      	                      
	                                                  
	                			if(i == (refund_data.length - 1)) {
	                              	$('#jetloading').hide();
		                    	 	$('#refresh_refunds_list').show();
	                            }

                				rf_data+='<tr>';
	                                rf_data+='<td class="first_column">'+id+'</td>';
	                                rf_data+='<td>'+refund_authorization_id+'</td>';
	                                rf_data+='<td>'+merchant_order_id+'</td>';
	                                rf_data+='<td>'+refund_status_div+'</td>';
	                                rf_data+='<td>'+refund_actions+'</td>';
	                            rf_data+='</tr>';
	                        }

	                        $('#dataTable_row').html('');
	                        $('#dataTable_row').append(rf_data);

	                        getpagination(refunds_count);
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
    $('#refunds_list').hide();
    $('#paginate_div').html('');
}

function show_hide() {
    hide_details();
    $('#refresh_refunds_list').show();
}

function getpagination(refunds_count) {

    var page_limit = $('#page_limit').val();    

    var rf_count;
    var rf_data='';
    if(refunds_count > page_limit) {
        var rf_count = Math.ceil(refunds_count/page_limit);
        //console.log(page_limit+'/'+rf_count);

        var cur_page = $('#cur_page').val();
        var previous_count = parseInt(parseInt(cur_page)-parseInt(1));      
        var previous_page_class = '';
        if(cur_page == 1) {
            previous_page_class = 'disabled';
        }

        var next_count = parseInt(parseInt(cur_page)+parseInt(1)); 
        var next_page_class = '';
        if(cur_page == rf_count) {
            next_page_class = 'disabled';
        }

        rf_data+='<ul class="pagination">';

            rf_data+='<li cur_page="'+previous_count+'" class="page_li paginate_button '+previous_page_class+' ">Previous</li>';
            for(j=1;j<=rf_count;j++){   
                var page_lid_id = 'page_li'+j;
                rf_data+='<li cur_page="'+j+'" class="page_li" id="'+page_lid_id+'">'+j+'</li>';
            }        
            rf_data+='<li cur_page="'+next_count+'" class="page_li paginate_button '+next_page_class+' ">Next</li>';

        rf_data+='</ul>';
    }

    $('#paginate_div').html('');
    $('#paginate_div').html(rf_data);
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

            getallrefunds();
        }
    });

   //console.log(rf_data);
   //console.log(refunds_count);
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