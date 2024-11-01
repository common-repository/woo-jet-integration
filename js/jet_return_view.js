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

});

function getreturndetails() {
    var return_id = $('#return_id').val();
    var return_id_length = $.trim(return_id).length;
    //console.log('return_id:'+return_id);
    if(return_id_length > 0) {
      //console.log('return_id:'+return_id);
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

            if(return_data.length > 0)  {
                var return_details = return_data[0].return_details;
                var refund_without_return = return_data[0].refund_without_return;
                var return_charge = return_data[0].return_charge;
                var return_status = return_details.return_status;
                
                $('#merchant_return_authorization_id').html(return_details.merchant_return_authorization_id);
                $('#reference_return_authorization_id').html(return_details.reference_return_authorization_id);
                $('#return_status').html(return_status);
                $('#return_date').html(return_details.return_date);
                $('#refund_without_return').html(refund_without_return);
                $('#merchant_order_id').html(return_details.merchant_order_id);
                $('#reference_order_id').html(return_details.reference_order_id);
                $('#shipping_carrier').html(return_details.shipping_carrier);
                $('#tracking_number').html(return_details.tracking_number);
                $('#merchant_return_charge').html(return_details.merchant_return_charge);
                $('#return_charge').html(return_charge);

                if(return_status == "created") {
                  var return_btns = '<button return_id="'+return_id+'" id="complete_return_btn">Complete Return</button>';
                  $('#return_btns').html(return_btns);
                }
                      
                var returned_items = return_details.return_merchant_SKUs;
                var returned_items_count = returned_items.length;

                var return_items_list = '';
                if(returned_items_count > 0) { 
                    var return_header_text = 'RETURNED ITEMS ('+returned_items_count+')';
                    $('#return_header').html(return_header_text);

                    return_items_list+= '<table id="refund_items_list_tbl" cellpadding="10" cellspacing="0">';

                        return_items_list+= '<thead>';
                            return_items_list+= '<tr><th>ITEM ID</th><th>MERCHANT SKU</th><th>RETURNED QUANTITY</th><th style="width:15%;">REQUESTED REFUND</th><th>REASON</th></tr>';
                        return_items_list+= '</thead>';

                        return_items_list+='<tbody>';
                            for(i=0;i<returned_items_count;i++) {
                                var order_item_id = returned_items[i].order_item_id;
                                var merchant_sku = returned_items[i].merchant_sku;
                                var return_quantity = returned_items[i].return_quantity;
                                var returned_reason = returned_items[i].reason;

                                var request_refund_principal = returned_items[i].requested_refund_amount.principal;
                                var request_refund_tax = returned_items[i].requested_refund_amount.tax;
                                var request_refund_shipping_cost = returned_items[i].requested_refund_amount.shipping_cost;
                                var request_refund_shipping_tax = returned_items[i].requested_refund_amount.shipping_tax;

                                if(request_refund_principal == '') {request_refund_principal == 0; }
                                if(request_refund_tax == '') {request_refund_tax == 0; }
                                if(request_refund_shipping_cost == '') {request_refund_shipping_cost == 0; }
                                if(request_refund_shipping_tax == '') {request_refund_shipping_tax == 0; }

                                var request_refund_amount_div = '';
                                request_refund_amount_div+= '<div class="refunds_rows"><span><b>Base Price:</b><span>&nbsp;&nbsp;<span>'+request_refund_principal+'</span></div>';
                                request_refund_amount_div+= '<div class="refunds_rows"><span><b>Tax:</b><span>&nbsp;&nbsp;<span>'+request_refund_tax+'</span></div>';
                                request_refund_amount_div+= '<div class="refunds_rows"><span><b>Shipping Cost:</b><span>&nbsp;&nbsp;<span>'+request_refund_shipping_cost+'</span></div>';
                                request_refund_amount_div+= '<div class="refunds_rows"><span><b>Shipping Tax:</b><span>&nbsp;&nbsp;<span>'+request_refund_shipping_tax+'</span></div>';                                                

                               
                                return_items_list+= '<tr>';
                                    return_items_list+= '<td>'+order_item_id+'</td>';
                                    return_items_list+= '<td>'+merchant_sku+'</td>';
                                    return_items_list+= '<td>'+return_quantity+'</td>';
                                    return_items_list+= '<td>'+request_refund_amount_div+'</td>';                                    
                                    return_items_list+= '<td>'+returned_reason+'</td>';
                                return_items_list+= '</tr>';
                            }   
                        return_items_list+='</tbody>';

                    return_items_list+='</table>';
                }                   
                $('#return_items_list').html(return_items_list);

                if(return_status == "completed by merchant") {
                    if(return_charge == 'False') {
                        $('#return_charge_feedback').html(return_details.return_charge_feedback);
                        $('#return_charge_feedback_div').show();
                    }

                    $('#completed_date').html(return_details.completed_date);                        
                    $('#completed_date_div').show();

                    var refund_items = return_details.items;
                    var refunded_items_count = refund_items.length;

                    var refund_items_list = '';
                    if(refunded_items_count > 0) {
                        var refund_header_text = 'REFUNDED ITEMS ('+refunded_items_count+')';
                        $('#refund_header').html(refund_header_text);

                        refund_items_list+= '<table id="refund_items_list_tbl" cellpadding="10" cellspacing="0">';

                            refund_items_list+= '<thead>';
                                refund_items_list+= '<tr><th>ITEM ID</th><th>MERCHANT SKU</th><th>RETURNED QUANTITY</th><th>REFUNDED QUANTITY</th><th style="width:15%;">REFUND AMOUNT</th><th>RETURN FEEDBACK</th></tr>';
                            refund_items_list+= '</thead>';

                            refund_items_list+='<tbody>';
                                for(i=0;i<refunded_items_count;i++) {
                                    var order_item_id = refund_items[i].order_item_id;
                                    var merchant_sku = returned_items[i].merchant_sku;
                                    var total_quantity_returned = refund_items[i].total_quantity_returned;
                                    var order_return_refund_qty = refund_items[i].order_return_refund_qty;
                                    
                                    var return_refund_feedback ='';
                                    if(refund_items[i].return_refund_feedback) {
                                        return_refund_feedback = refund_items[i].return_refund_feedback;
                                    }
                                   

                                    var principal = refund_items[i].refund_amount.principal;
                                    var tax = refund_items[i].refund_amount.tax;
                                    var shipping_cost = refund_items[i].refund_amount.shipping_cost;
                                    var shipping_tax = refund_items[i].refund_amount.shipping_tax;

                                    if(principal == '') {principal == 0; }
                                    if(tax == '') {tax == 0; }
                                    if(shipping_cost == '') {shipping_cost == 0; }
                                    if(shipping_tax == '') {shipping_tax == 0; }

                                    var refund_amount_div = '';
                                    refund_amount_div+= '<div class="refunds_rows"><span><b>Base Price:</b><span>&nbsp;&nbsp;<span>'+principal+'</span></div>';
                                    refund_amount_div+= '<div class="refunds_rows"><span><b>Tax:</b><span>&nbsp;&nbsp;<span>'+tax+'</span></div>';
                                    refund_amount_div+= '<div class="refunds_rows"><span><b>Shipping Cost:</b><span>&nbsp;&nbsp;<span>'+shipping_cost+'</span></div>';
                                    refund_amount_div+= '<div class="refunds_rows"><span><b>Shipping Tax:</b><span>&nbsp;&nbsp;<span>'+shipping_tax+'</span></div>';                                                

                                   
                                    refund_items_list+= '<tr>';
                                        refund_items_list+= '<td>'+order_item_id+'</td>';
                                        refund_items_list+= '<td>'+merchant_sku+'</td>';
                                        refund_items_list+= '<td>'+total_quantity_returned+'</td>';
                                        refund_items_list+= '<td>'+order_return_refund_qty+'</td>';
                                        refund_items_list+= '<td>'+refund_amount_div+'</td>';                                    
                                        refund_items_list+= '<td>'+return_refund_feedback+'</td>';
                                    refund_items_list+= '</tr>';
                                }   
                            refund_items_list+='</tbody>';

                        refund_items_list+='</table>';
                    }

                    $('#refund_items_list').html(refund_items_list);
                }  

                // complete_return
                $('#complete_return_btn').click(function(e) {
                    //e.preventDefault();
                    var return_id = $(this).attr('return_id');  
                    window.location.href =  jet_woo_plugin_url+'&tab=jet-complete-return&return_id='+return_id;
                });                                 

                $('#jetloading').hide();
                $('#return_div').show();
                $('#return_view_header').show();
                $('#no-rep').hide();
            } else {
               $('#jetloading').hide();
               $('#return_div').hide();
               $('#return_view_header').hide();
               $('#no-rep').show();
            }
          }
      );
    }     
}



