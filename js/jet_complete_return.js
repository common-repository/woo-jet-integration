var $ = jQuery.noConflict();

$(window).load(function(e) {
     console.log('jet return view');

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
               getreturndetails();
          } 
     });

    // complete_return
    $('#complete_return_btn').click(function() {

        clearflash();

        var return_authorization_id = $("#merchant_return_authorization_id").html(); 
        var merchant_order_id = $("#merchant_order_id").html(); 
        var alt_order_id = $("#alt_order_id").html();             
        var agree_to_return_charge = $("#agree_to_return_charge").val();   
        var return_charge_feedback = $('#return_charge_feedback').val(); 
        var refund_type = $('#refund_type').val();    

        var return_refund_feedback = '';
        $('.return_refund_feedback').each(function(){
            var val = $(this).val();
            if(val!='') {
                return_refund_feedback+=$(this).val()+','; 
            }
        });   
        return_refund_feedback = return_refund_feedback.slice(0,-1); 

        var order_item_id = '';
        $('.order_item_id').each(function(){
            order_item_id+=$(this).html()+','; 
        });   
        order_item_id = order_item_id.slice(0,-1);  

        var total_quantity_returns = '';
        $('.total_quantity_returns').each(function(){
            total_quantity_returns+=$(this).val()+','; 
        });   
        total_quantity_returns = total_quantity_returns.slice(0,-1);   

        var order_returns_refund_qtys = '';
        $('.order_returns_refund_qtys').each(function(){
            order_returns_refund_qtys+=$(this).val()+','; 
        });   
        order_returns_refund_qtys = order_returns_refund_qtys.slice(0,-1); 

        var refund_amount_principal = '';
        $('.refund_amount_principal').each(function(){
            refund_amount_principal+=$(this).val()+','; 
        });   
        refund_amount_principal = refund_amount_principal.slice(0,-1);   

        var refund_amount_tax = '';
        $('.refund_amount_tax').each(function(){
            refund_amount_tax+=$(this).val()+','; 
        });   
        refund_amount_tax = refund_amount_tax.slice(0,-1);  

        var refund_amount_shipping_cost = '';
        $('.refund_amount_shipping_cost').each(function(){
            refund_amount_shipping_cost+=$(this).val()+','; 
        });   
        refund_amount_shipping_cost = refund_amount_shipping_cost.slice(0,-1);   

        var refund_amount_shipping_tax = '';
        $('.refund_amount_shipping_tax').each(function(){
            refund_amount_shipping_tax+=$(this).val()+','; 
        });   
        refund_amount_shipping_tax = refund_amount_shipping_tax.slice(0,-1);

        $('#jet-loading').show(); 
        var jet_get_return_complete_secure_key = $('#jet_get_return_complete_secure_key').val(); 

        var return_data = {'action' : 'jet_return_complete', 'jet_get_return_complete_secure_key' : jet_get_return_complete_secure_key,
                    'return_authorization_id': return_authorization_id,'refund_type':refund_type,'merchant_order_id': merchant_order_id,'alt_order_id':alt_order_id,'agree_to_return_charge': agree_to_return_charge,'return_charge_feedback':return_charge_feedback,'order_item_id':order_item_id,'return_refund_feedback':return_refund_feedback,'total_quantity_returned':total_quantity_returns,'order_return_refund_qty':order_returns_refund_qtys,'refund_amount_principal':refund_amount_principal,'refund_amount_tax':refund_amount_tax,'refund_amount_shipping_cost':refund_amount_shipping_cost,'refund_amount_shipping_tax':refund_amount_shipping_tax};
        //console.log(return_data);

        $.post( ajaxurl, return_data,
            function(response) {    
                //console.log('response:'+response);
                $('#jet-loading').hide();
                pageTop();
                
                if(response == 'success') {
                    alert('Return Completed Successfully'); 
                    var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();
                    window.location.href =  jet_woo_plugin_url+'&tab=jet-return-view&return_id='+return_authorization_id;
                } else {
                   setflash(response);
                   setTimeout(clearflash, 10000);                   
                }
            }
        );
    }); 

});

function getreturndetails() {
    var return_id = $('#return_id').val();
    var return_id_length = $.trim(return_id).length;

    if(return_id_length > 0) {
      console.log('return_id:'+return_id);
      $('#jetloading').show();

      var jet_get_return_details_secure_key = $('#jet_get_return_details_secure_key').val();
      var jet_path_res = $('#jet_path_res').html();
      var settings_link = $('#settings_link').val();
      var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();

      $.post(ajaxurl,{
            'action' : 'get_jet_return_details',
            'return_id': return_id,
            'jet_get_return_details_secure_key' : jet_get_return_details_secure_key
          },
          function(response) {                    
           // console.log(response);
            var return_data = $.parseJSON(response);
           // console.log('returns length:'+return_data.length);

            if(return_data.length == 0)  {
               $('#jetloading').hide();
               $('#return_div').hide();
               $('#return_view_header').hide();
               $('#no-rep').show();
            } else {
                var return_details = return_data[0].return_details;
                var return_status = return_details.return_status;

                if(return_status == "created") {
                    var return_charge = return_data[0].return_charge;
                    if(return_charge == 'False') {
                        $('#return_charge_feedback_div').show();
                    }

                    $('#return_charge').html(return_charge);
                    $('#alt_order_id').html(return_details.alt_order_id);
                    $('#agree_to_return_charge').html(return_details.agree_to_return_charge);

                    $('#merchant_return_authorization_id').html(return_details.merchant_return_authorization_id);
                    $('#merchant_order_id').html(return_details.merchant_order_id);

                    var returned_items = return_details.return_merchant_SKUs;
                    var returned_items_count = returned_items.length;

                    var return_items_list = '';
                    if(returned_items_count > 0) { 
                        var return_header_text = 'RETURNED ITEMS ('+returned_items_count+')';
                        $('#return_header').html(return_header_text);

                        return_items_list+= '<table id="refund_items_list_tbl" cellpadding="10" cellspacing="0">';

                            return_items_list+= '<thead>';
                                return_items_list+= '<tr><th>ORDER ITEM ID</th><th>MERCHANT SKU</th><th>QTY RETURNED BY CUSTOMER</th><th>QTY YOU REFUND</th><th>REFUND AMOUNT</th><th id="return_refund_feedback_header">RETURN REFUND FEEDBACK</th></tr>';
                            return_items_list+= '</thead>';

                            return_items_list+='<tbody>';
                                for(i=0;i<returned_items_count;i++) {
                                    var order_item_id = returned_items[i].order_item_id;
                                    var merchant_sku = returned_items[i].merchant_sku;
                                    var return_quantity = returned_items[i].return_quantity;

                                    var total_quantity_returns = '<input type="number" step="1" min="0" max="'+return_quantity+'" class="total_quantity_returns qty_returned'+order_item_id+'" value="'+return_quantity+'" />';
                                    var order_returns_refund_qtys = '<input type="number" step="1" min="0" max="'+return_quantity+'" class="order_returns_refund_qtys qty_refunded'+order_item_id+'" value="'+return_quantity+'" />';
                                                       
                                    var principal = returned_items[i].requested_refund_amount.principal;
                                    var tax = returned_items[i].requested_refund_amount.tax;
                                    var shipping_cost = returned_items[i].requested_refund_amount.shipping_cost;
                                    var shipping_tax = returned_items[i].requested_refund_amount.shipping_tax;

                                    if(principal == '') {principal == 0; }
                                    if(tax == '') {tax == 0; }
                                    if(shipping_cost == '') {shipping_cost == 0; }
                                    if(shipping_tax == '') {shipping_tax == 0; }

                                    var principal_div ='<input type="number" step="0.01" min="0" max="'+principal+'" class="refund_amount_inputs refund_amount_principal" id="refund_amount_principal'+order_item_id+'" value="'+principal+'" />';
                                    var tax_div ='<input type="number" step="0.01" min="0" max="'+tax+'" class="refund_amount_inputs refund_amount_tax" id="refund_amount_tax'+order_item_id+'" value="'+tax+'" />';
                                    var shipping_cost_div ='<input type="number" step="0.01" min="0" max="'+shipping_cost+'" class="refund_amount_inputs refund_amount_shipping_cost" id="refund_amount_shipping_cost'+order_item_id+'" value="'+shipping_cost+'" />';
                                    var shipping_tax_div ='<input type="number" step="0.01" min="0" max="'+shipping_tax+'" class="refund_amount_inputs refund_amount_shipping_tax" id="refund_amount_shipping_tax'+order_item_id+'" value="'+shipping_tax+'" />';

                                    var refund_amount_div = '';
                                    refund_amount_div+= '<div class="refunds_rows"><span><b>Base Price:</b><span><br/><span>'+principal_div+'</span></div>';
                                    refund_amount_div+= '<div class="refunds_rows"><span><b>Tax:</b><span><br/><span>'+tax_div+'</span></div>';
                                    refund_amount_div+= '<div class="refunds_rows"><span><b>Shipping Cost:</b><span><br/><span>'+shipping_cost_div+'</span></div>';
                                    refund_amount_div+= '<div class="refunds_rows"><span><b>Shipping Tax:</b><span><br/><span>'+shipping_tax_div+'</span></div>';                                                
                                   
                                    var return_refund_feedback_div = '<select class="form-control form-input return_refund_feedback" data-show-subtext="true" data-live-search="true">';
                                        return_refund_feedback_div+= '<option value="Item is missing parts/accessories">Item is missing parts/accessories</option>';
                                        return_refund_feedback_div+= '<option value="Wrong Item">Wrong Item</option>';
                                        return_refund_feedback_div+= '<option value="Item damaged">Item damaged</option>';
                                        return_refund_feedback_div+= '<option value="Returned outside window">Returned outside window</option>';
                                        return_refund_feedback_div+= '<option value="Restocking fee">Restocking fee</option>';
                                        return_refund_feedback_div+= '<option value="Not shipped in original packaging">Not shipped in original packaging</option>';
                                        return_refund_feedback_div+= '<option value="Rerouting fee">Rerouting fee</option>';
                                        return_refund_feedback_div+= '</select>';

                                    return_items_list+= '<tr>';
                                        return_items_list+= '<td class="order_item_id">'+order_item_id+'</td>';
                                        return_items_list+= '<td>'+merchant_sku+'</td>';
                                        return_items_list+= '<td>'+total_quantity_returns+'</td>';
                                        return_items_list+= '<td>'+order_returns_refund_qtys+'</td>';
                                        return_items_list+= '<td>'+refund_amount_div+'</td>'; 
                                        return_items_list+= '<td class="return_refund_feedback_div">'+return_refund_feedback_div+'</td>';                                       
                                    return_items_list+= '</tr>';
                                }   
                            return_items_list+='</tbody>';

                        return_items_list+='</table>';

                    }                   
                    $('#return_items_list').html(return_items_list);
                    
                    $('#jetloading').hide();
                    $('#return_div').show();
                    $('#return_view_header').show();
                    $('#no-rep').hide();

                    $('#refund_type').on('change', function()  {
                       var value = $(this).val();
                       console.log('refund_type_val:'+value);
                       
                       var return_refund_feedback_header = $('#return_refund_feedback_header');
                       var return_refund_feedback_div =$('.return_refund_feedback_div');
                       
                        if(value == "refund_full_price")  {
                            return_refund_feedback_header.hide();
                            return_refund_feedback_div.hide();
                        }  else  {
                            return_refund_feedback_header.show();
                            return_refund_feedback_div.show();
                        }       
                    }); 
                } else  {
                    window.location.href =  jet_woo_plugin_url+'&tab=jet-return-view&return_id='+return_id;
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
        'scrollTop' : $('#return_div').position().top
    });
}

