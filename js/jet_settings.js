var $ = jQuery.noConflict();

$(window).load(function(e) {
       
   	$('#save_api_configuration').click(function(e) {
   		e.preventDefault();
         clearflash();
   		var jet_save_configuration_settings_secure_key = $('#jet_save_configuration_settings_secure_key').val();
   		var api_url = $('#api_url').val();
   		var api_user = $('#api_user').val();
   		var secret_key = $('#secret_key').val();
   		var fulfillment_id = $('#fulfillment_id').val();
   		var email_address = $('#email_address').val();
   		var store_name = $('#store_name').val();
   		var return_id = $('#return_id').val();
   		var first_address = $('#first_address').val();
   		var second_address = $('#second_address').val();
   		var city = $('#city').val();
   		var state = $('#state').val();
   		var zip_code = $('#zip_code').val();

   		if(api_url == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#api_url').css({'border':"1px solid #ff0000"});
   			$('#api_url').focus();
   		} else if(api_user == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#api_user').css({'border':"1px solid #ff0000"});
   			$('#api_user').focus();
   		} else if(secret_key == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#secret_key').css({'border':"1px solid #ff0000"});
   			$('#secret_key').focus();
   		} else if(fulfillment_id == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#fulfillment_id').css({'border':"1px solid #ff0000"});
   			$('#fulfillment_id').focus();
   		} else if(email_address == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#email_address').css({'border':"1px solid #ff0000"});
   			$('#email_address').focus();
   		} else if(store_name == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#store_name').css({'border':"1px solid #ff0000"});
   			$('#store_name').focus();
   		} else if(return_id == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#return_id').css({'border':"1px solid #ff0000"});
   			$('#return_id').focus();
   		} else if(first_address == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#first_address').css({'border':"1px solid #ff0000"});
   			$('#first_address').focus();
   		} else if(city == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#city').css({'border':"1px solid #ff0000"});
   			$('#city').focus();
   		} else if(state == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#state').css({'border':"1px solid #ff0000"});
   			$('#state').focus();
   		} else if(zip_code == '') {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});
   			$('#zip_code').css({'border':"1px solid #ff0000"});
   			$('#zip_code').focus();
   		} else {
   			$('.settings_form_input').css({'border':"1px solid #ddd"});

   			var ajax_data = {'action':'jet_save_configuration_settings', 'save_api_configuration': 'yes',
	   		'jet_save_configuration_settings_secure_key':jet_save_configuration_settings_secure_key,
	   		'api_url':api_url, 'api_user':api_user, 'secret_key':secret_key,
	   			'fulfillment_id':fulfillment_id, 'email_address':email_address, 'store_name':store_name,
	   			'return_id':return_id,'first_address':first_address, 'second_address':second_address,
	   			'city':city, 'state':state, 'zip_code':zip_code	};

	   		console.log(ajax_data);
	   		$("#jetloading" ).show();

	   		$.post( ajaxurl, ajax_data,
				function(response) {
					$("#jetloading" ).hide();
					console.log(response);
					pageTop();
					if(response == "success") {
                  var messagediv = 'success_message';
                  var message = 'Updated Successfully';
                  setflash(messagediv,message);               
                  setTimeout(function() {
                     clearflash();
                  }, 5000);

					} else {
                  var messagediv = 'failure_message';
                  if(response!='') {
                     var message = response;
                  } else  {
                     var message = 'Failed to save the details';
                  }
                  setflash(messagediv,message);               
                  setTimeout(function() {
                     clearflash();
                  }, 5000);

					}
				}
			);
   		}
   	});

    $('#reset_api_configuration').click(function(e) {
   		e.preventDefault();
         clearflash();
   		var jet_reset_configuration_settings_secure_key = $('#jet_reset_configuration_settings_secure_key').val();
     		var ajax_data = {'action':'jet_reset_configuration_settings', 'reset_api_configuration': 'yes',
   		'jet_reset_configuration_settings_secure_key':jet_reset_configuration_settings_secure_key};
   		console.log(ajax_data);
   		$("#jetloading" ).show();
   		$.post( ajaxurl, ajax_data,
			function(response) {
				$("#jetloading" ).hide();
				console.log(response);
				pageTop();
				if(response == "success") {
					$('.settings_form_input').val('');
					$('#api_url').val('https://merchant-api.jet.com/api/');
               var messagediv = 'success_message';
               var message = 'Resetted Successfully';
					setflash(messagediv,message);               
					setTimeout(function() {
			        	clearflash();
			    	}, 5000);
				} else {				
               var messagediv = 'failure_message';
               var message = 'Failed to reset the details';
               setflash(messagediv,message);
					setTimeout(function() {
			        	clearflash();
			    	}, 5000);
				}
			}
		);
   	});

});


function pageTop() {
   $('html, body').animate({
      'scrollTop' : $('#settings_div').position().top
   });
}

function setflash(messagediv,message) { 
   $('#'+messagediv).html(message);
   $('#'+messagediv).show();
}

function clearflash() {  
   $('.flash_messages').html('');
   $('.flash_messages').hide();
}


