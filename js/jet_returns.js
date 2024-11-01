var $ = jQuery.noConflict();

$(window).load(function(e) {
	console.log('jet returns');

	var plugin_path_link = $('#plugin_path_link').html();
    var jet_path_res = $('#jet_path_res').html();
    var settings_link = $('#settings_link').val();

    $("#jet-loading" ).show();

    $('#refresh_returns_list').click(function(e)  { 
        clear_msg(); 
        e.preventDefault();        
        $("#jet-loading" ).show();        
        var jet_refresh_data_secure_key = $('#jet_refresh_data_secure_key').val();
        var cron_type = 'returns';

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

    $('#return_type').change(function(e)  {  
        e.preventDefault();
        $('#cur_page').val(1);
        getallreturns();
    });

	$.getScript(plugin_path_link+'js/checkapiaccess.js', function () {          
	    var response = checkaccess();
		if(response != "success") {
			alert(jet_path_res);
			window.location.href = settings_link;
		} else {
			$("#jet-loading" ).hide();
			getallreturns();
		} 
	}); 

    $('.close').click(function(e){
        e.preventDefault();
        $('.alert').hide();
    });
	
});

function getallreturns() {
	var cur_page = $('#cur_page').val();    
    var page_limit = $('#page_limit').val();
	var return_type = $('#return_type').val();
	console.log('return_type:'+return_type);

	if(return_type!= '') {

		if (history.pushState) {
          	var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?page=Jet-Integration&tab=jet-returns&return_type='+return_type;
          	window.history.pushState({path:newurl},'',newurl);
        }

		$('#jetloading').show();
		$('#refresh_returns_list').hide();

		var jet_get_returns_list_secure_key = $('#jet_get_returns_list_secure_key').val();
		var jet_path_res = $('#jet_path_res').html();
	    var settings_link = $('#settings_link').val();
	    var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();

		$.post(	ajaxurl, {
				'action' : 'get_jet_returns_list',
				'return_type': return_type,
				'cur_page' : cur_page,
            	'page_limit' : page_limit,
				'jet_get_returns_list_secure_key' : jet_get_returns_list_secure_key
			},
			function(response) {
				//console.log(response);

				if(response!= '') {
					if(response == 'invalid login details') {                    
	                    $('#refresh_returns_list').hide();
	                    hide_details();
						alert(jet_path_res);
						window.location.href = settings_link;
					} else {
						var rt_datas = $.parseJSON(response);
						//console.log('returns:'+rt_datas);
	                    var returns_count = rt_datas.returns_count;
	                    
						if(returns_count == 0)  {
	                       show_hide();
	                	} else {
	                		var return_data = rt_datas.returns_data;
							//console.log('returns length:'+return_data.length);
	                		var rt_data = '';  
	                		for(i=0;i<return_data.length;i++)	{ 
	                            if(i == 0){
	                                $('#no-rep').hide();
	                                $('#returns_list').show();
	                            }

	                           	var id = return_data[i]['id'];
		                        var return_id = return_data[i]['merchant_return_authorization_id'];
		                        var return_date = return_data[i]['return_date'];
		                        var merchant_order_id = return_data[i]['merchant_order_id'];
		                        var return_status = return_data[i]['return_status'];
		                        var return_status_div = '<span style="text-transform:capitalize;">'+return_status+'</span>';
		                       	                        
		                        var return_view_link =   jet_woo_plugin_url+'&tab=jet-return-view&return_id='+return_id;
	                            var return_actions ='<a href="'+return_view_link+'" title="view" class="view_data">View Details</a>&nbsp;'; 
	      	                                                                       
                				rt_data+='<tr>';
	                                rt_data+='<td class="first_column">'+id+'</td>';
	                                rt_data+='<td>'+return_date+'</td>';
	                                rt_data+='<td>'+return_id+'</td>';
	                                rt_data+='<td>'+merchant_order_id+'</td>';
	                                rt_data+='<td>'+return_status_div+'</td>';
	                                rt_data+='<td>'+return_actions+'</td>';
	                            rt_data+='</tr>';

	                			if(i == (return_data.length - 1)) {
	                                $('#jetloading').hide();
	                                $('#refresh_returns_list').show();
	                            }
	                        }

	                        $('#dataTable_row').html('');
	                        $('#dataTable_row').append(rt_data);

	                        getpagination(returns_count);
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
    $('#returns_list').hide();
    $('#paginate_div').html('');
}

function show_hide() {
    hide_details();
    $('#refresh_returns_list').show();
}

function getpagination(returns_count) {

    var page_limit = $('#page_limit').val();    

    var rt_count;
    var rt_data='';
    if(returns_count > page_limit) {
        var rt_count = Math.ceil(returns_count/page_limit);
        //console.log(page_limit+'/'+rt_count);

        var cur_page = $('#cur_page').val();
        var previous_count = parseInt(parseInt(cur_page)-parseInt(1));      
        var previous_page_class = '';
        if(cur_page == 1) {
            previous_page_class = 'disabled';
        }

        var next_count = parseInt(parseInt(cur_page)+parseInt(1)); 
        var next_page_class = '';
        if(cur_page == rt_count) {
            next_page_class = 'disabled';
        }

        rt_data+='<ul class="pagination">';

            rt_data+='<li cur_page="'+previous_count+'" class="page_li paginate_button '+previous_page_class+' ">Previous</li>';
            for(j=1;j<=rt_count;j++){   
                var page_lid_id = 'page_li'+j;
                rt_data+='<li cur_page="'+j+'" class="page_li" id="'+page_lid_id+'">'+j+'</li>';
            }        
            rt_data+='<li cur_page="'+next_count+'" class="page_li paginate_button '+next_page_class+' ">Next</li>';

        rt_data+='</ul>';
    }

    $('#paginate_div').html('');
    $('#paginate_div').html(rt_data);
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

            getallreturns();
        }
    });

    //console.log(rt_data);
   //console.log(returns_count);
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
