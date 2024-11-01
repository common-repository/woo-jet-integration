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


     $("#refund_btn1").click(function()  {
          $("#refund_div").hide();
          $("#request_refund_div").show();
     });

     $("#refund_btn2").click(function()  {
          clearflash();
          var merchant_order_id = $("#merchant_order_id").html();

          var order_item_id = '';
          $('.order_item_id').each(function(){
            order_item_id+=$(this).html()+','; 
          }); 

          order_item_id = order_item_id.slice(0,-1);

          var total_quantity_returned = '';
          $('.total_quantity_returned').each(function(){
            total_quantity_returned+=$(this).val()+','; 
          });   
          total_quantity_returned = total_quantity_returned.slice(0,-1);   

          var order_return_refund_qty = '';
          $('.order_return_refund_qty').each(function(){
            order_return_refund_qty+=$(this).val()+','; 
          });   
          order_return_refund_qty = order_return_refund_qty.slice(0,-1); 

          var refund_feedback = '';
          $('.refund_feedback').each(function(){
            refund_feedback+=$(this).val()+','; 
          });   
          refund_feedback = refund_feedback.slice(0,-1);

          var refund_reason = '';
          $('.refund_reason').each(function(){
            refund_reason+=$(this).val()+','; 
          });   
          refund_reason = refund_reason.slice(0,-1);  

          var notes = '';
          $('.notes').each(function(){
            notes+=$(this).val()+'newnotes'; 
          });   
          notes = notes.slice(0,-8);

          var r_amount_principal = '';
          $('.r_amount_principal').each(function(){
            r_amount_principal+=$(this).val()+','; 
          });   
          r_amount_principal = r_amount_principal.slice(0,-1); 

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

          pageTop();

          var jet_request_refund_secure_key = $('#jet_request_refund_secure_key').val();

          var refund_data = { 'action' : 'jet_request_refund_order',
          'jet_request_refund_secure_key' : jet_request_refund_secure_key,
           'order_id': merchant_order_id, 'order_item_id': order_item_id,
           'total_quantity_returned':total_quantity_returned,
           'order_return_refund_qty':order_return_refund_qty,
           'refund_reason':refund_reason, 'refund_feedback':refund_feedback, 
           'notes':notes, 'r_amount_principal':r_amount_principal, 
           'refund_amount_principal':refund_amount_principal,
           'refund_amount_tax':refund_amount_tax,
           'refund_amount_shipping_cost':refund_amount_shipping_cost,
           'refund_amount_shipping_tax':refund_amount_shipping_tax};

          //console.log(refund_data);

          $.post( ajaxurl, refund_data,
            function(response) {    
                //console.log('response:'+response);
                $('#jet-loading').hide();  
                //console.log(response);
                if(response == 'success') {
                    $('#refund_status').val('success');

                    $("#refund_div").hide();
                    $("#request_refund_div").hide();
                    alert('Refund Requested Successfully');                        
                    setTimeout(getorderdetails, 3000); 
                } else {
                   setflash(response);
                   setTimeout(clearflash, 10000);
                }
            }
          );
     }); 

});

function printDiv(elementId) {
    var a = document.getElementById('printing-css').value;
    var b = document.getElementById(elementId).innerHTML;
    window.frames["print_frame"].document.title = document.title;
    window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();

    /*var newWindow = window.open();
    newWindow.document.write(document.getElementById(elementId).innerHTML);
    newWindow.print();*/
}

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
                    //console.log(response);
                    var order_data = $.parseJSON(response);
                    //console.log('orders length:'+order_data.length);
                      
                    if(order_data.length > 0) {
                         var refund_state = order_data[0].refund_state;
                         var o_data = order_data[0].order_details; 

                         var acknowledgement_status = o_data.acknowledgement_status; 

                         var merchant_order_id = o_data.merchant_order_id;
                         $('#merchant_order_id').html(merchant_order_id);

                         var reference_order_id = o_data.reference_order_id;
                         $('#reference_order_id').html(reference_order_id);

                         var order_placed_date = o_data.order_placed_date;
                         $('#order_placed_date').html(order_placed_date);

                         var status = o_data.status;
                         $('#order_status').html(status);
                                           
                         $('#exception_state').html('');
                         $('#exception_state').hide();
                         
                         $('#order_complete_date').html('');
                         $('#order_complete_date_div').hide();

                         $('#shipments_info').hide();

                         var shipments_carrier = '';
                         var shipments_shipping_method = '';
                         var shipment_tracking_number = '';
                         var response_shipment_date = '';
                         var carrier_pick_up_date = '';
                         var expected_delivery_date = '';

                         $('#printing_process').hide();

                         var ack_status;
                         if( ( (!o_data.exception_state) && (status == 'complete') ) || ( acknowledgement_status == 'accepted' && acknowledgement_status == 'acknowledged' )  ) {
                             ack_status =  '<span style="color: #0d0;"><b>Acknowledged</b></span>';
                         } else {
                             ack_status = '<span style="color: #f00;"><b>Not Acknowledged</b><span>';
                         }
                         

                         if(status == 'complete') {
                             //$('#printing_process').show();
                             if(o_data.exception_state) {
                                 $('#order_status').append(",&nbsp;");
                                 $('#exception_state').html(o_data.exception_state);
                                 $('#exception_state').show(); 
                                 //$('#order_complete_print').hide();
                             } else {  
                                 var order_complete_date = order_data[0].order_complete_date;                    
                                 $('#order_complete_date').html(order_complete_date);
                                 $('#order_complete_date_div').show();
                                 
                                 var shipments_carrier = o_data.shipments[0].carrier;
                                 var shipments_shipping_method = o_data.shipments[0].response_shipment_method;
                                 var shipment_tracking_number = o_data.shipments[0].shipment_tracking_number;
                                 var response_shipment_date = order_data[0].response_shipment_date;
                                 var carrier_pick_up_date =  order_data[0].carrier_pick_up_date;
                                 var expected_delivery_date =  order_data[0].expected_delivery_date;

                                 $('#shipments_info').show();
                                 //$('#order_complete_print').show();
                             }
                         }

                         var ship_order = '<button order_id="'+merchant_order_id+'" id="ship_order_btn">Ship Order</button>';
                         var cancel_order = '<button order_id="'+merchant_order_id+'" id="cancel_order_btn">Cancel Order</button>';

                         var accept_order = '<button order_id="'+merchant_order_id+'" id="accept_order_btn">Accept Order</button>';
                         var reject_order ='<select order_id="'+merchant_order_id+'"  id="reject_order_btn">';
                                 reject_order+='<option value=""> -- Reject Order -- </option>';
                                 reject_order+='<option value="rejected - ship from location not available">Ship from location not available</option>';
                                 reject_order+='<option value="rejected - shipping method not supported">Shipping method not supported</option>';
                                 reject_order+='<option value="rejected - unfulfillable address">Unfulfillable address</option>';
                                 reject_order+='<option value="rejected - fraud">Fraud</option>';
                                 reject_order+='<option value="rejected - other">Other</option>';
                             reject_order+='</select>';
                                     

                         var order_btns = '';

                         if(status == 'ready') {
                             order_btns = accept_order+reject_order;                        
                         } else if(status == 'acknowledged')   {
                             order_btns = ship_order+cancel_order;
                         }

                         $('#order_btns').html(order_btns); 

                         if(order_btns!='') {                      
                            $('#order_btns').show();
                         } else {
                             $('#order_btns').hide();
                         }
                         

                         $('#shipments_carrier').html(shipments_carrier);
                         $('#shipments_shipping_method').html(shipments_shipping_method);
                         $('#shipment_tracking_number').html(shipment_tracking_number);
                         $('#response_shipment_date').html(response_shipment_date);
                         $('#carrier_pick_up_date').html(carrier_pick_up_date);
                         $('#expected_delivery_date').html(expected_delivery_date);
                         

                         var total_base_price = o_data.order_totals.item_price.base_price;
                         var total_item_tax = o_data.order_totals.item_price.item_tax;
                         var total_item_shipping_tax = o_data.order_totals.item_price.item_shipping_tax;
                         var total_item_shipping_cost = o_data.order_totals.item_price.item_shipping_cost;

                         $('#total_base_price').html(total_base_price);
                         $('#total_item_shipping_cost').html(total_item_shipping_cost);

                         if(o_data.order_totals.fee_adjustments) {
                             if($.type(o_data.order_totals.fee_adjustments[0].adjustment_type) != "undefined"
                              && o_data.order_totals.fee_adjustments[0].adjustment_type!='') {
                                 var adjustment_type = o_data.order_totals.fee_adjustments[0].adjustment_type;
                                 var total_order_base_fee = o_data.order_totals.fee_adjustments[0].value;
                                 console.log(adjustment_type+':'+total_order_base_fee);
                                 var order_fees = '<b>'+adjustment_type+' Fee: </b>-$'+total_order_base_fee;
                                 $('#order_fees').html(order_fees);
                             }
                         }

                         var order_total_val = '$'+order_data[0].order_total_val;
                         $('#total_payable').html(order_total_val);

                         var customer_name = o_data.buyer.name;
                         var customer_phone = o_data.buyer.phone_number;
                         var customer_email = o_data.hash_email;

                         $('#customer_name').html(customer_name);
                         $('#customer_phone').html(customer_phone);
                         $('#customer_email').html(customer_email);

                         var recipient_name = o_data.shipping_to.recipient.name;
                         $('#recipient_name').html(recipient_name);

                         var recipient_address1 = o_data.shipping_to.address.address1;
                         var recipient_address2 = o_data.shipping_to.address.address2;
                         var recipient_address = recipient_address1+'<br/>'+recipient_address2;
                         $('#recipient_address').html(recipient_address);

                         var recipient_city = o_data.shipping_to.address.city;
                         $('#recipient_city').html(recipient_city);

                         var recipient_state = o_data.shipping_to.address.state;
                         $('#recipient_state').html(recipient_state);

                         var recipient_zipcode = o_data.shipping_to.address.zip_code;
                         $('#recipient_zipcode').html(recipient_zipcode);

                         var shipping_carrier = o_data.order_detail.request_shipping_carrier;
                         $('#shipping_carrier').html(shipping_carrier);

                         var service_level = o_data.order_detail.request_service_level;
                         $('#service_level').html(service_level);

                         var ship_by_date = order_data[0].ship_by_date; 
                         $('#ship_by_date').html(ship_by_date);

                         var delivery_date = order_data[0].delivery_date;
                         $('#delivery_date').html(delivery_date);


                         var order_items = o_data.order_items; 
                         var order_items_count = order_items.length;

                         var order_items_header = 'Ordered Items&nbsp;('+order_items_count+')';
                         $('#orders_header').html(order_items_header);


                         var order_items_list = '';
                         if(order_items_count>0) {                      
                             order_items_list+= '<table id="order_items_list_tbl" cellpadding="10" cellspacing="0">';

                                 order_items_list+= '<thead>';
                                     order_items_list+= '<tr><th>Product</th><th>Quantity</th><th>Price per item</th><th>Fee per item</th><th>Value</th><th>Ack. Status</th></tr>';
                                 order_items_list+= '</thead>';

                                 order_items_list+='<tbody>';
                                     for(i=0;i<order_items_count;i++) {
                                         var per_product_title = order_items[i].product_title;
                                         var per_order_item_id = order_items[i].order_item_id;
                                         var per_merchant_sku = order_items[i].merchant_sku;

                                         var per_order_qty = order_items[i].request_order_quantity;
                                         var per_order_cancel_qty = order_items[i].request_order_cancel_qty;
                                         var product_qty = (per_order_qty - per_order_cancel_qty);

                                         var per_base_price = order_items[i].item_price.base_price;
                                         var per_item_tax = order_items[i].item_price.item_tax;
                                         var per_item_shipping_tax = order_items[i].item_price.item_shipping_tax;
                                         var per_item_shipping_cost = order_items[i].item_price.item_shipping_cost;

                                         var per_order_base_fee = '';
                                         var per_order_adjustment_type = '';
                                         var fee_adjustments = '';

                                         if(order_items[i].fee_adjustments) {
                                            per_order_adjustment_type = order_items[i].fee_adjustments[0].adjustment_type;
                                            per_order_base_fee = order_items[i].fee_adjustments[0].per_order_base_fee; 
                                            fee_adjustments = '<b>'+per_order_adjustment_type+' Fee: </b>-$'+per_order_base_fee; 
                                         }

                                         if(per_base_price == '') { per_base_price = 0; }
                                         if(per_item_tax == '') { per_item_tax = 0; }
                                         if(per_item_shipping_tax == '') { per_item_shipping_tax = 0; }
                                         if(per_item_shipping_cost == '') { per_item_shipping_cost = 0; }
                                         if(per_order_base_fee == '') { per_order_base_fee = 0; }

                                         var product_total_price = (per_base_price + per_item_tax + per_item_shipping_tax + per_item_shipping_cost);
                                         var product_total_val = (product_total_price - per_order_base_fee) * product_qty;
                                         console.log('product_total_val:'+product_total_val);

                                         var per_product='';
                                         per_product+='<div class="order_rows"><span><b>Item ID:</b></span>&nbsp;&nbsp;<span>'+per_product_title+'</span></div>';
                                         per_product+='<div class="order_rows"><span><b>Product Title:</b></span>&nbsp;&nbsp;<span>'+per_order_item_id+'</span></div>';
                                         per_product+='<div class="order_rows"><span><b>Merchant SKU:</b></span>&nbsp;&nbsp;<span>'+per_merchant_sku+'</span></div>';
                                          
                                         var per_quantity = '<div>'+per_order_qty+'</div>';
                                         if(per_order_cancel_qty>0) {
                                             per_quantity+='<div style = "color:#f00;margin-top:3px;">';
                                                 per_quantity+='<span>Canceled:</span>&nbsp;&nbsp;';
                                                 per_quantity+='<span><b>'+per_order_cancel_qty+'</b></span>';                                                    
                                             per_quantity+='</div>';
                                         }

                                         var per_price  = '';
                                         per_price+='<div class="order_rows">';
                                                 per_price+='<span><b>Base Price:</b></span>&nbsp;&nbsp;';
                                                 per_price+='<span>$'+per_base_price+'</span>';                                                    
                                         per_price+='</div>';

                                         per_price+='<div class="order_rows">';
                                                 per_price+='<span><b>Shipping Cost:</b></span>&nbsp;&nbsp;';
                                                 per_price+='<span>$'+per_item_shipping_cost+'</span>';                                                    
                                         per_price+='</div>';


                                         order_items_list+= '<tr>';
                                             order_items_list+= '<td>'+per_product+'</td>';
                                             order_items_list+= '<td class="tbl_td">'+per_quantity+'</td>';
                                             order_items_list+= '<td>'+per_price+'</td>';
                                             order_items_list+= '<td class="tbl_td">'+fee_adjustments+'</td>';
                                             order_items_list+= '<td class="tbl_td">$'+product_total_val+'</td>';
                                             order_items_list+= '<td class="tbl_td">'+ack_status+'</td>';
                                         order_items_list+= '</tr>';

                                     }
                                 order_items_list+='</tbody>';

                                 order_items_list+='<tfoot>';
                                     order_items_list+= '<tr><td id="total_order_payable" colspan="4">Total Payable:</td><td style="font-weight:700;">'+order_total_val+'</td><td>&nbsp;</td></tr>';
                                 order_items_list+='</tfoot>';

                             order_items_list+= '</table>';
                         }

                         $('#order_items_list').html(order_items_list);

                         var refund_status = $('#refund_status').val();

                         if( ( (!o_data.exception_state) && (status == 'complete') ) && ( merchant_order_id != '' && refund_state == 'failed' && refund_status == '')  ) {
                            
                             var refund_items_header = 'Refund Items &nbsp;('+order_items_count+')';
                             $('#refund_header').html(refund_items_header);

                             var refund_order_items_list = '';
                             if(order_items_count>0) { 
                                 refund_order_items_list+= '<table id="refund_order_items_list_tbl" cellpadding="10" cellspacing="0">';

                                 refund_order_items_list+= '<thead>';
                                     refund_order_items_list+= '<tr><th>order item id</th><th>Merchant SKU</th><th>Select Refund Type</th><th>Ordered Qty</th><th>Qty Returned By Customer</th><th>Qty You Refund</th><th>Refund Amount</th><th>Refund Feedback</th></tr>';
                                 refund_order_items_list+= '</thead>';

                                 refund_order_items_list+='<tbody>';

                                 for(i=0;i<order_items_count;i++) {
                                     var per_order_item_id = order_items[i].order_item_id;
                                     var per_merchant_sku = order_items[i].merchant_sku;

                                     var per_order_qty = order_items[i].request_order_quantity;
                                     var per_order_cancel_qty = order_items[i].request_order_cancel_qty;
                                     var product_qty = (per_order_qty - per_order_cancel_qty);

                                     console.log(order_items[i].item_price);

                                     var per_base_price = order_items[i].item_price.base_price;
                                     var per_item_tax = order_items[i].item_price.item_tax;
                                     var per_item_shipping_tax = order_items[i].item_price.item_shipping_tax;
                                     var per_item_shipping_cost = order_items[i].item_price.item_shipping_cost;

                                     if(per_base_price == '') { per_base_price = 0; }
                                     if(per_item_tax == null || per_item_tax == '') {per_item_tax = 0;  }
                                     if(per_item_shipping_tax == null || per_item_shipping_tax == '') { per_item_shipping_tax = 0; }
                                     if(per_item_shipping_cost == null || per_item_shipping_cost == '') { per_item_shipping_cost = 0; }

                                     var refund_reason_div = '<select class="refund_reason">';
                                         refund_reason_div+= '<option value="No longer want this item">No longer want this item</option>';
                                         refund_reason_div+= '<option value="Received the wrong item">Received the wrong item</option>';
                                         refund_reason_div+= '<option value="Website description is inaccurate">Website description is inaccurate</option>';
                                         refund_reason_div+= '<option value="Product is defective / does not work">Product is defective / does not work</option>';
                                         refund_reason_div+= '<option value="Item arrived damaged - box intact">Item arrived damaged - box intact</option>';
                                         refund_reason_div+= '<option value="Item arrived damaged - box damaged">Item arrived damaged - box damaged</option>';
                                         refund_reason_div+= '<option value="Package never arrived">Package never arrived</option>';
                                         refund_reason_div+= '<option value="Package arrived late">Package arrived late</option>';
                                         refund_reason_div+= '<option value="Wrong quantity received">Wrong quantity received</option>';
                                         refund_reason_div+= '<option value="Better price found elsewhere">Better price found elsewhere</option>';
                                         refund_reason_div+= '<option value="Unwanted gift">Unwanted gift</option>';
                                         refund_reason_div+= '<option value="Accidental order">Accidental order</option>';
                                         refund_reason_div+= '<option value="Unauthorized purchase">Unauthorized purchase</option>';
                                         refund_reason_div+= '<option value="Item is missing parts / accessories">Item is missing parts / accessories</option>';
                                         refund_reason_div+= '<option value="Return to Sender - damaged, undeliverable, refused">Return to Sender - damaged, undeliverable, refused</option>';
                                         refund_reason_div+= '<option value="Return to Sender - lost in transit only">Return to Sender - lost in transit only</option>';
                                         refund_reason_div+= '<option value="Item is refurbished">Item is refurbished</option>';
                                         refund_reason_div+= '<option value="Item is expired">Item is expired</option>';
                                         refund_reason_div+= '<option value="Package arrived after estimated delivery date">Package arrived after estimated delivery date</option>';     
                                         refund_reason_div+= '</select>';

                                     var total_quantity_returned = '<input type="number" step="1" min="0" max="'+product_qty+'" class="total_quantity_returned" value="'+product_qty+'" />';
                                     var order_return_refund_qty = '<input type="number" step="1" min="0" max="'+product_qty+'" class="order_return_refund_qty" order_item_id="'+per_order_item_id+'" id="order_return_refund_qty'+per_order_item_id+'" value="'+product_qty+'" />';
                                                           
                                     var principal_div ='<input type="number" step="0.01" min="0" max="'+per_base_price+'" class="refund_amount_inputs refund_amount_principal" order_item_id="'+per_order_item_id+'" id="refund_amount_principal'+per_order_item_id+'" value="'+per_base_price+'" />';
                                     var tax_div ='<input type="number" step="0.01" min="0" max="'+per_item_tax+'" class="refund_amount_inputs refund_amount_tax" id="refund_amount_tax'+per_order_item_id+'" value="'+per_item_tax+'" />';
                                     var shipping_cost_div ='<input type="number" step="0.01" min="0" max="'+per_item_shipping_cost+'" class="refund_amount_inputs refund_amount_shipping_cost" id="refund_amount_shipping_cost'+per_order_item_id+'" value="'+per_item_shipping_cost+'" />';
                                     var shipping_tax_div ='<input type="number" step="0.01" min="0" max="'+per_item_shipping_tax+'" class="refund_amount_inputs refund_amount_shipping_tax" id="refund_amount_shipping_tax'+per_order_item_id+'" value="'+per_item_shipping_tax+'" />';

                                     var refund_amount_div = '';
                                         refund_amount_div+='<input type="hidden" class="r_amount_principal" value="'+per_base_price+'" id="r_principal'+per_order_item_id+'"/>';
                                         refund_amount_div+='<input type="hidden" class="r_amount_tax" value="'+per_item_tax+'" id="r_amount_tax'+per_order_item_id+'"/>';
                                         refund_amount_div+='<input type="hidden" class="r_amount_shipping_cost" value="'+per_item_shipping_cost+'" id="r_amount_shipping_cost'+per_order_item_id+'"/>';
                                         refund_amount_div+='<input type="hidden" class="r_amount_shipping_tax" value="'+per_item_shipping_tax+'" id="r_amount_shipping_tax'+per_order_item_id+'"/>';
                                         refund_amount_div+= '<div class="refunds_rows"><span><b>Base Price:</b><span><br/><span>'+principal_div+'</span></div>';
                                         refund_amount_div+= '<div class="refunds_rows"><span><b>Tax:</b><span><br/><span>'+tax_div+'</span></div>';
                                         refund_amount_div+= '<div class="refunds_rows"><span><b>Shipping Cost:</b><span><br/><span>'+shipping_cost_div+'</span></div>';
                                         refund_amount_div+= '<div class="refunds_rows"><span><b>Shipping Tax:</b><span><br/><span>'+shipping_tax_div+'</span></div>';                                                
                                     
                                     var refund_feedback_divs = '<select class="refund_feedback" id="refund_feedback'+per_order_item_id+'" style="display:none;">';
                                         refund_feedback_divs+= '<option value="Item is missing parts/accessories">Item is missing parts/accessories</option>';
                                         refund_feedback_divs+='<option value="Wrong Item">Wrong Item</option>';
                                         refund_feedback_divs+='<option value="Item damaged">Item damaged</option>';
                                         refund_feedback_divs+='<option value="Returned outside window">Returned outside window</option>';   
                                         refund_feedback_divs+='<option value="Restocking fee">Restocking fee</option>'; 
                                         refund_feedback_divs+='<option value="Not shipped in original packaging">Not shipped in original packaging</option>'; 
                                         refund_feedback_divs+='<option value="Rerouting fee">Rerouting fee</option>'; 
                                         refund_feedback_divs+='</select><br/>';
                                         refund_feedback_divs+='<textarea class="notes" id="refund_notes'+per_order_item_id+'" rows="3" placeholder="notes" style="display:none;"></textarea>';

                                     refund_order_items_list+= '<tr>';
                                         refund_order_items_list+= '<td class="order_item_id">'+per_order_item_id+'</td>';
                                         refund_order_items_list+= '<td>'+per_merchant_sku+'</td>';
                                         refund_order_items_list+= '<td>'+refund_reason_div+'</td>';
                                         refund_order_items_list+= '<td>'+product_qty+'</td>';
                                         refund_order_items_list+= '<td>'+total_quantity_returned+'</td>';
                                         refund_order_items_list+= '<td>'+order_return_refund_qty+'</td>';
                                         refund_order_items_list+= '<td>'+refund_amount_div+'</td>';
                                         refund_order_items_list+= '<td>'+refund_feedback_divs+'</td>';
                                     refund_order_items_list+= '</tr>';
                                 }

                                 refund_order_items_list+= '</tbody>';
                                 refund_order_items_list+= '</table>';
                             }

                             $('#refund_order_items_list').html(refund_order_items_list);

                             $("#refund_div").show();

                         } else {
                             $("#refund_div").hide();
                         }                                     


                         $('#jetloading').hide();
                         $('#order_div').show();
                         $('#order_view_header').show();
                         $('#no-rep').hide();

                         // accept order
                         $('#accept_order_btn').click(function(e) {
                             //e.preventDefault();
                             var order_id = $(this).attr('order_id');
                             var ack_type = 'accepted';
                             ack_order(order_id, ack_type);                        
                         });

                         // reject order
                         $('#reject_order_btn').change(function(e) {
                             //e.preventDefault();
                             var order_id = $(this).attr('order_id');
                             var ack_type = $(this).val();
                             ack_order(order_id, ack_type);                        
                         });

                         // cancel order
                         $('#cancel_order_btn').click(function(e) {
                             //e.preventDefault();
                             var order_id = $(this).attr('order_id');
                             order_cancel(order_id);                        
                         });

                         // cancel order
                         $('#ship_order_btn').click(function(e) {
                             // e.preventDefault();
                              var order_id = $(this).attr('order_id');
                              window.location.href =  jet_woo_plugin_url+'&tab=jet-ship-order&order_id='+order_id;
                         });

                         $('.order_return_refund_qty').on('change', function() {
                            var order_item_id = $(this).attr('order_item_id');
                            refund_price_toggle(order_item_id);
                         });

                         $('.refund_amount_principal').on('change', function() {
                            var order_item_id = $(this).attr('order_item_id');
                            refund_feedback_toggle(order_item_id);
                         });

                         // package slip with no shipping
                         $('#package_slip_no_shipping').click(function(e) {
                             e.preventDefault();
                             printDiv('package_slip_without_shipping');                       
                         });
                         
                         // package slip with  shipping
                         $('#package_slip').click(function(e) {
                             e.preventDefault();
                             printDiv('package_slip_with_shipping');                       
                         });

                         // print order
                         $('#order_print').click(function(e) {
                             e.preventDefault();
                             printDiv('print_order_div');                       
                         });
                    } else {
                         $('#jetloading').hide();
                         $('#order_div').hide();
                         $('#order_view_header').hide();
                         $('#no-rep').show();
                    }
               }
          );
     }     
}


function refund_price_toggle(order_item_id) {
    console.log('order_item_id:'+order_item_id);

    var order_return_refund_qty_id = 'order_return_refund_qty'+order_item_id;
    var order_return_refund_val =  parseInt($('#'+order_return_refund_qty_id).val());

    console.log('order_return_refund_val:'+order_return_refund_val);

    var r_principal_id = 'r_principal'+order_item_id;
    var r_principal_val =  parseFloat($('#'+r_principal_id).val());

    var r_amount_tax_id = 'r_amount_tax'+order_item_id;
    var r_amount_tax_val =  parseFloat($('#'+r_amount_tax_id).val());

    var r_amount_shipping_cost_id = 'r_amount_shipping_cost'+order_item_id;
    var r_amount_shipping_cost_val =  parseFloat($('#'+r_amount_shipping_cost_id).val());

    var r_amount_shipping_tax_id = 'r_amount_shipping_tax'+order_item_id;
    var r_amount_shipping_tax_val =  parseFloat($('#'+r_amount_shipping_tax_id).val());

    console.log('r_principal_val:'+r_principal_val);
    console.log('r_amount_tax_val:'+r_amount_tax_val);
    console.log('r_amount_shipping_cost_val:'+r_amount_shipping_cost_val);
    console.log('r_amount_shipping_tax_val:'+r_amount_shipping_tax_val);

    var refund_principal =  parseFloat(r_principal_val * order_return_refund_val);
    var refund_amount_tax =  parseFloat(r_amount_tax_val * order_return_refund_val);
    var refund_amount_shipping_cost =  parseFloat(r_amount_shipping_cost_val * order_return_refund_val);
    var refund_amount_shipping_tax =  parseFloat(r_amount_shipping_tax_val * order_return_refund_val);

    console.log('refund_principal:'+refund_principal);
    console.log('refund_amount_tax:'+refund_amount_tax);
    console.log('refund_amount_shipping_cost:'+refund_amount_shipping_cost);
    console.log('refund_amount_shipping_tax:'+refund_amount_shipping_tax);


    var refund_principal_id = 'refund_amount_principal'+order_item_id;
    $('#'+refund_principal_id).val(refund_principal);
    $('#'+refund_principal_id).attr('max',refund_principal);

    var refund_amount_tax_id = 'refund_amount_tax'+order_item_id;
    $('#'+refund_amount_tax_id).val(refund_amount_tax);
    $('#'+refund_amount_tax_id).attr('max',refund_amount_tax);

    var refund_amount_shipping_cost_id = 'refund_amount_shipping_cost'+order_item_id;
    $('#'+refund_amount_shipping_cost_id).val(refund_amount_shipping_cost);
    $('#'+refund_amount_shipping_cost_id).attr('max',refund_amount_shipping_cost);

    var refund_amount_shipping_tax_id = 'refund_amount_shipping_tax'+order_item_id;
    $('#'+refund_amount_shipping_tax_id).val(refund_amount_shipping_tax); 
    $('#'+refund_amount_shipping_tax_id).attr('max',refund_amount_shipping_tax); 

    refund_feedback_toggle(order_item_id);
}


function refund_feedback_toggle(order_item_id) {
    console.log('order_item_id:'+order_item_id);

    var order_return_refund_qty_id = 'order_return_refund_qty'+order_item_id;
    var order_return_refund_val =  parseInt($('#'+order_return_refund_qty_id).val());

    console.log('order_return_refund_val:'+order_return_refund_val);

    var r_principal_id = 'r_principal'+order_item_id;
    var r_principal_val =  parseFloat($('#'+r_principal_id).val()); 

    var refund_principal_val =  parseFloat(r_principal_val * order_return_refund_val);

    var principal_amount_id = 'refund_amount_principal'+order_item_id;
    var principal_amount =  parseFloat($('#'+principal_amount_id).val());

    var principal_amount_val =  parseFloat(principal_amount * order_return_refund_val);
   
    var refund_feedback_id = 'refund_feedback'+order_item_id;
    var refund_feedback = $('#'+refund_feedback_id).val();

    var notes_id = 'refund_notes'+order_item_id;

       
    if((principal_amount_val < refund_principal_val) || (order_return_refund_val == 0) ) {
        console.log('principal_amount_val1:'+principal_amount_val+'&refund_principal_val1:'+refund_principal_val);

        $('#'+refund_feedback_id).show(); 
        $('#'+notes_id).show(); 
    }  else {
        console.log('principal_amount_val2:'+principal_amount_val+'&refund_principal_val2:'+refund_principal_val);

        $('#'+refund_feedback_id).hide();  
        $('#'+notes_id).hide();
    }
}

function ack_order(order_id, ack_type) {  
    console.log('order_id:'+order_id+'&ack_type:'+ack_type);
    if( (order_id!='') &&  (ack_type!='') ) {       
          $('#jet-loading').show();
          var confirm_msg;
          var success_msg;
          if(ack_type == 'accepted') {
            confirm_msg = 'Are you sure you want to Accept this order?';
            success_msg = 'Order acknowledged Successfully';
          } else {
            confirm_msg = 'Are you sure you want to Reject this order?';
            success_msg = 'Order rejected Successfully';
          }

          if(confirm(confirm_msg))  {
               var jet_acknowledge_order_secure_key = $('#jet_acknowledge_order_secure_key').val();
               $.post( ajaxurl,    {
                    'action' : 'jet_acknowledge_order',
                    'order_id': order_id,
                    'ack_type': ack_type,
                    'jet_acknowledge_order_secure_key' : jet_acknowledge_order_secure_key
               },
               function(response) {   
                    console.log('response:'+response);
                    $('#jet-loading').hide();    
                    if(response == 'success') {
                        alert(success_msg);                        
                        setTimeout(getorderdetails, 3000); 
                    } else {
                        setflash(response);
                        setTimeout(clearflash, 10000);
                    }
               }
            );            
          } else {
             $('#jet-loading').hide(); 
          }
    }
}

function order_cancel(order_id ){
    console.log('order_id:'+order_id);
    if( (order_id!='')) {  
        $('#jet-loading').show();
        var confirm_msg = 'Are you sure you want to Cancel this order?';
        var success_msg = 'Order Cancelled Successfully';
        if(confirm(confirm_msg))  {
             var jet_order_cancel_secure_key = $('#jet_order_cancel_secure_key').val();
             $.post( ajaxurl,    {
                  'action' : 'jet_order_cancel',
                  'order_id': order_id,
                  'jet_order_cancel_secure_key' : jet_order_cancel_secure_key
             },
             function(response) {
                  console.log('response:'+response);
                  $('#jet-loading').hide();  
                  if(response == 'success') {
                      alert(success_msg);                        
                      setTimeout(getorderdetails, 3000); 
                  } else {
                      setflash(response);
                      setTimeout(clearflash, 10000);
                  }
             }
          );            
        } else {
           $('#jet-loading').hide(); 
        }
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

