var $ = jQuery.noConflict();

$(window).load(function(e) {
     console.log('jet refund view');

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
               getrefunddetails();
          } 
     });

});

function getrefunddetails() {
    var refund_id = $('#refund_id').val();
    var refund_id_length = $.trim(refund_id).length;

    if(refund_id_length > 0) {
      console.log('refund_id:'+refund_id);
      $('#jetloading').show();

      var jet_get_refund_details_secure_key = $('#jet_get_refund_details_secure_key').val();
      var jet_path_res = $('#jet_path_res').html();
      var settings_link = $('#settings_link').val();
      var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();

      $.post(ajaxurl,{
            'action' : 'get_jet_refund_details',
            'refund_id': refund_id,
            'jet_get_refund_details_secure_key' : jet_get_refund_details_secure_key
          },
          function(response) {                    
            //console.log(response);
            var refund_data = $.parseJSON(response);
            //console.log('refunds length:'+refund_data.length);
               
            if(refund_data.length > 0) {
                var refund_details = refund_data[0].refund_details;
                console.log('refund_details:'+refund_details); 

                $('#refund_authorization_id').html(refund_details.refund_authorization_id);
                $('#reference_order_id').html(refund_details.reference_order_id);
                $('#merchant_refund_id').html(refund_details.refund_id);
                $('#merchant_order_id').html(refund_details.merchant_order_id);
                $('#refund_status').html(refund_details.refund_status);

                var refund_items = refund_details.items;
                var refund_items_count = refund_items.length;

                var refund_items_list = '';
                if(refund_items_count > 0) {
                    var refund_header_text = 'REFUNDED ITEMS ('+refund_items_count+')';
                    $('#refund_header').html(refund_header_text);
                    
                    refund_items_list+= '<table id="refund_items_list_tbl" cellpadding="10" cellspacing="0">';

                        refund_items_list+= '<thead>';
                            refund_items_list+= '<tr><th>ORDER ITEM ID</th><th>REFUND REASON</th><th>TOTAL QTY RETURNED</th><th>TOTAL QTY REFUNDED</th><th style="width:15%;">REFUND AMOUNT</th><th>REFUND FEEDBACK</th></tr>';
                        refund_items_list+= '</thead>';

                        refund_items_list+='<tbody>';
                            for(i=0;i<refund_items_count;i++) {
                                var order_item_id = refund_items[i].order_item_id;
                                var refund_reason = refund_items[i].refund_reason;
                                var total_quantity_returned = refund_items[i].total_quantity_returned;
                                var order_return_refund_qty = refund_items[i].order_return_refund_qty;

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

                                var  refund_feedback_div = '';
                                if(refund_items[i].refund_feedback) {
                                    refund_feedback_div+=refund_items[i].refund_feedback;
                                    if(refund_items[i].refund_feedback == 'other') {
                                        refund_feedback_div+='<br/><br/><strong>Notes:</strong><br/>'+refund_items[i].notes;
                                    }
                                }

                                refund_items_list+= '<tr>';
                                    refund_items_list+= '<td class="tbl_td">'+order_item_id+'</td>';
                                    refund_items_list+= '<td>'+refund_reason+'</td>';
                                    refund_items_list+= '<td>'+total_quantity_returned+'</td>';
                                    refund_items_list+= '<td>'+order_return_refund_qty+'</td>';
                                    refund_items_list+= '<td>'+refund_amount_div+'</td>';                                    
                                    refund_items_list+= '<td>'+refund_feedback_div+'</td>';
                                refund_items_list+= '</tr>';
                            }   
                        refund_items_list+='</tbody>';

                    refund_items_list+='</table>';
                }

                $('#refund_items_list').html(refund_items_list);
                               

                $('#jetloading').hide();
                $('#refund_div').show();
                $('#refund_view_header').show();
                $('#no-rep').hide();
            } else {
               $('#jetloading').hide();
               $('#refund_div').hide();
               $('#refund_view_header').hide();
               $('#no-rep').show();
            }
          }
      );
    }     
}



