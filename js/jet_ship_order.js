var $ = jQuery.noConflict();

$(window).load(function(e) {
     console.log('jet order view');

     clearflash();

     var plugin_path_link = $('#plugin_path_link').html();
     var jet_path_res = $('#jet_path_res').html();
     var settings_link = $('#settings_link').val();
   
     $("#jet-loading" ).show();

     $.getScript(plugin_path_link+'js/checkapiaccess.js', function () {          
          var response = checkaccess();
          if(response != "success") {
               alert(jet_path_res);
               window.location.href = settings_link;
          } else {
               $("#jet-loading" ).hide();
               getorderdetails();
          } 
     });

     $('#ship_order_btn').click(function()    {

        clearflash();

        var order_id = $("#order_id").val();
        var carrier = $('#carrier').val();
        var response_shipment_method = $('#response_shipment_method').val();
        var response_shipment_date = $('#response_shipment_date').val();
        var carrier_pick_up_date = $('#carrier_pick_up_date').val();
        var expected_delivery_date = $('#expected_delivery_date').val();
        var tracking_number = $('#tracking_number').val();
        var ship_from_zip_code = $('#ship_from_zip_code').val();

        $('.ship_order_inputs').removeClass('ship_order_border');

        if(response_shipment_date == '') {            
            $('#response_shipment_date').addClass('ship_order_border');
            $('#response_shipment_date').focus();
        } else if(carrier_pick_up_date == '') {
            $('#carrier_pick_up_date').addClass('ship_order_border');
            $('#carrier_pick_up_date').focus();
        } else if(expected_delivery_date == '')  {
            $('#expected_delivery_date').addClass('ship_order_border');
            $('#expected_delivery_date').focus();
        } else if(tracking_number == '')    {
           $('#tracking_number').addClass('ship_order_border');
           $('#tracking_number').focus();
        }   else if(ship_from_zip_code == '')         {
           $('#ship_from_zip_code').addClass('ship_order_border');
           $('#ship_from_zip_code').focus();
        }  else  {

            $('#jet-loading').show();

            var jet_ship_order_secure_key = $('#jet_ship_order_secure_key').val();

            console.log('order_id:'+order_id+'&carrier:'+carrier+'&response_shipment_method:'+response_shipment_method
                +'&response_shipment_date:'+response_shipment_date+'&carrier_pick_up_date:'+carrier_pick_up_date
                +'&expected_delivery_date:'+expected_delivery_date+'&tracking_number:'+tracking_number
                +'&ship_from_zip_code:'+ship_from_zip_code);

           $.post( ajaxurl,    {
                    'action' : 'jet_ship_order',
                    'jet_ship_order_secure_key' : jet_ship_order_secure_key,
                    'order_id': order_id,
                    'carrier': carrier,
                    'response_shipment_method': response_shipment_method,
                    'response_shipment_date': response_shipment_date,
                    'carrier_pick_up_date': carrier_pick_up_date,
                    'expected_delivery_date': expected_delivery_date,
                    'tracking_number': tracking_number,
                    'ship_from_zip_code': ship_from_zip_code
                },
                function(response) {    
                    console.log('response:'+response);
                    $('#jet-loading').hide();
                    pageTop();
                    if(response == 'success') {
                        alert('Order Shipped Successfully');
                        var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();
                        window.location.href =   jet_woo_plugin_url+'&tab=jet-order-view&order_id='+order_id;
                    } else {
                       setflash(response);
                       setTimeout(clearflash, 10000);                      
                    }
                }
            );
        }
    });


});


function getorderdetails() {
     var order_id = $('#order_id').val();
     var order_id_length = $.trim(order_id).length;

     if(order_id_length > 0) {
          console.log('order_id:'+order_id);
          $('#jetloading').show();

          var jet_get_order_details_secure_key = $('#jet_get_order_details_secure_key').val();
          var jet_path_res = $('#jet_path_res').html();
          var settings_link = $('#settings_link').val();
          var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();

          $.post(ajaxurl, {
                    'action' : 'jet_get_order_details',
                    'order_id': order_id,
                    'jet_get_order_details_secure_key' : jet_get_order_details_secure_key
               },
               function(response) {                    
                    console.log(response);
                    var order_data = $.parseJSON(response);
                    console.log('orders length:'+order_data.length);

                    if(order_data.length == 0)  {
                         $('#jetloading').hide();
                         $('#order_div').hide();
                         $('#order_view_header').hide();
                         $('#no-rep').show();
                    } else {
                          
                          var order_ack_info_data = order_data[0].order_ack_info_data;
                          console.log('order_ack_info_data:'+order_ack_info_data);

                          if(order_ack_info_data == '') {
                              window.location.href =   jet_woo_plugin_url+'&tab=jet-order-view&order_id='+order_id;
                          } else {
                              var order_placed_date = order_ack_info_data.order_placed_date;
                              $('#order_placed_date').html(order_placed_date);

                              var order_acknowledge_date = order_ack_info_data.order_acknowledge_date;
                              $('#order_acknowledge_date').html(order_acknowledge_date);
                              
                              var response_shipment_method = order_ack_info_data.response_shipment_method;
                              $('#response_shipment_method').val(response_shipment_method);

                              var carrier = order_ack_info_data.carrier;
                              $('#carrier').val(carrier);

                             $('#jetloading').hide();
                             $('#order_div').show();
                             $('#order_view_header').show();
                             $('#no-rep').hide();
                          } 
                    }
               }
          );
     }     
}

function setflash(message) {
    $('#form-error-text').html(message);
    $('#form-error-text').show();
}

function clearflash() {
    $('#form-error-text').html('');
    $('#form-error-text').hide();
}

function pageTop() {
    $('html, body').animate({
        'scrollTop' : $('#order_div').position().top
    });
}

