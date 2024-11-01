var $ = jQuery.noConflict();

$(window).load(function(e) {
	  console.log('jet product view');
    clear_msg();

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
  			getproductdetails();
  		} 
  	});	

    $('.selectpicker').selectpicker();

    $('.update_product_btn').click(function(e) {
        e.preventDefault();
        clear_msg();

        console.log('update');

        var merchant_sku = $('#merchant_sku').val();
        var parent_sku = $('#parent_sku').val();
        var product_title = $('#product_title').val();
        var product_price = $('#product_price').val();
        var product_quantity = $('#product_quantity').val();
        var multipack_quantity = $('#multipack_quantity').val();
        var map_price = $('#map_price').val();
        var map_implementation = $('#map_implementation').val();

        var msrp = $('#msrp').val();
        var brand = $('#brand').val();
        var standard_product_code_type = $('#standard_product_code_type').val();
        var standard_product_code = $('#standard_product_code').val();

        var shipping_weight_pounds = $('#shipping_weight_pounds').val();
        var package_width_inches = $('#package_width_inches').val();
        var package_height_inches = $('#package_height_inches').val();
        var package_length_inches = $('#package_length_inches').val();

        var display_width_inches = $('#display_width_inches').val();
        var display_height_inches = $('#display_height_inches').val();
        var display_length_inches = $('#display_length_inches').val();
        var country_of_origin = $('#country_of_origin').val();

        var manufacturer = $('#manufacturer').val();
        var mfr_part_number = $('#mfr_part_number').val();
        var main_image_url = $('#main_image_url').val();
        var swatch_image_url = $('#swatch_image_url').val();

        var alternate_image1_url = $('#alternate_image1_url').val();
        var alternate_image2_url = $('#alternate_image2_url').val();
        var alternate_image3_url = $('#alternate_image3_url').val();
        var alternate_image4_url = $('#alternate_image4_url').val();

        var alternate_image5_url = $('#alternate_image5_url').val();
        var alternate_image6_url = $('#alternate_image6_url').val();
        var alternate_image7_url = $('#alternate_image7_url').val();
        var alternate_image8_url = $('#alternate_image8_url').val();

        var jet_category = $('#jet_category').val();
        var jet_product_tax_code = $('#jet_product_tax_code').val();
        var legal_disclaimer_description = $('#legal_disclaimer_description').val();
        var safety_warning = $('#safety_warning').val();

        var product_description = $('#product_description').val();

        var prop65 = 'false';
        if ($("#prop65").is(":checked")) {
          prop65 = 'true';
        } 

        var bullets = [];
        var bullet;
        $("input[name='bullets[]']").each(function() {
          var val = $(this).val();
          if(val != '') {
            bullet = val;
          } else {
            bullet = "";
          }
          bullets.push( bullet );
        });

        var cpsia_statements = [];
        var cpsia;
        $("input[name='cpsia_cautionary_statements[]']").each(function() {
          if(this.checked) {
            cpsia = $(this).val();
          } else {
            cpsia = "";
          }
          cpsia_statements.push( cpsia );
        });  

        var attr_list = [];        
        $("input[name='attribute_ids[]']").each( function () {
            var attr_id = $(this).val();
            var attr_val = $('#attr'+attr_id).val();
            attr_list.push({
              'attr_id': attr_id,
              'attr_val': attr_val,
            });
        });    

        if(merchant_sku == '') {
          $('#merchant_sku').focus();
        } else if(product_title == '') {
          $('#product_title').focus();
        } else if(product_price == '') {
          $('#product_price').focus();
        } else if(product_quantity == '') {
          $('#product_quantity').focus();
        } else if(multipack_quantity == '') {
          $('#multipack_quantity').focus();
        } else if(brand == '') {
          $('#brand').focus();
        } else if(standard_product_code == '') {
          $('#standard_product_code').focus();
        } else if(main_image_url == '') {
          $('#main_image_url').focus();
        } else if(product_description == '') {
          $('#product_description').focus();
        } else {
            pageTop();
            $('#jetloading').show();

            var pdt_data = []; 
            pdt_data.push({
                'merchant_sku' : merchant_sku, 
                'parent_sku' : parent_sku, 
                'product_title' : product_title,
                'product_price' : product_price,
                'product_quantity' : product_quantity,
                'multipack_quantity' : multipack_quantity,
                'map_price' : map_price,
                'map_implementation' : map_implementation,
                'msrp' : msrp,
                'brand' : brand,
                'standard_product_code_type' : standard_product_code_type,
                'standard_product_code' : standard_product_code,
                'shipping_weight_pounds' : shipping_weight_pounds,
                'package_width_inches' : package_width_inches,
                'package_height_inches' : package_height_inches,
                'package_length_inches' : package_length_inches,
                'display_width_inches' : display_width_inches,
                'display_height_inches' : display_height_inches,
                'display_length_inches' : display_length_inches,
                'country_of_origin' : country_of_origin,
                'manufacturer' : manufacturer,
                'mfr_part_number' : mfr_part_number,
                'main_image_url' : main_image_url,
                'swatch_image_url' : swatch_image_url,
                'alternate_image1_url' : alternate_image1_url,
                'alternate_image2_url' : alternate_image2_url,
                'alternate_image3_url' : alternate_image3_url,
                'alternate_image4_url' : alternate_image4_url,
                'alternate_image5_url' : alternate_image5_url,
                'alternate_image6_url' : alternate_image6_url,
                'alternate_image7_url' : alternate_image7_url,
                'alternate_image8_url' : alternate_image8_url,
                'jet_category' : jet_category,
                'jet_product_tax_code' : jet_product_tax_code,
                'legal_disclaimer_description' : legal_disclaimer_description,
                'safety_warning' : safety_warning,
                'product_description' : product_description,
                'prop65' : prop65,
                'jet_bullets' : bullets,
                'jet_cpsia' : cpsia_statements,
                'attr_list':attr_list
            });

            //console.log(pdt_data);
            
            var jet_update_product_details_secure_key = $('#jet_update_product_details_secure_key').val(); 

            $.post(ajaxurl, {
                  'action' : 'jet_update_product_details',
                  'pdt_data': pdt_data,
                  'jet_update_product_details_secure_key' : jet_update_product_details_secure_key
                },
                function(response) {
                    $('#jetloading').hide();
                    //console.log(response);
                    if(response == "success") {
                       response = "Product Updated Successfully";
                    } 
                    show_alert(response);
                    setTimeout(clear_msg, 5000);
                }
            );
        }
    });

});


function getproductdetails() {
	var product_sku = $('#product_sku').val();
	var product_sku_length = $.trim(product_sku).length;

	if(product_sku_length > 0) {
		  console.log('product_sku:'+product_sku);
		  $('#jetloading').show();

		  var jet_get_product_details_secure_key = $('#jet_get_product_details_secure_key').val();
		  var jet_path_res = $('#jet_path_res').html();
	    var settings_link = $('#settings_link').val();
      var jet_woo_plugin_url = $('#jet_woo_plugin_url').val();

	    $.post(ajaxurl, {
  			  'action' : 'jet_get_product_details',
  			  'product_sku': product_sku,
  		    'jet_get_product_details_secure_key' : jet_get_product_details_secure_key
  			},
  			function(response) {
  				  $('#jetloading').hide();
  				  console.log(response);
  				  var product_data = $.parseJSON(response);
  				  //console.log('products length:'+product_data.length);
            if( (response!='') && (product_data.length>0) ){
                var p_data = product_data[0];

                var parent_sku = p_data.parent_sku;
                $('#parent_sku').val(parent_sku);

                var product_title = p_data.product_title;
                $('#product_title').val(product_title);

                var product_price = p_data.price;
                $('#product_price').val(product_price);

                var product_quantity = p_data.inventory;
                $('#product_quantity').val(product_quantity);

                var product_status = p_data.status;
                $('#product_status').html(product_status);

                var multipack_quantity = p_data.multipack_quantity;
                $('#multipack_quantity').val(multipack_quantity);

                var map_price = p_data.map_price;
                $('#map_price').val(map_price);

                var map_implementation = p_data.map_implementation;
                $('#map_implementation').val(map_implementation);

                var msrp = p_data.msrp;
                $('#msrp').val(msrp);

                var brand = p_data.brand;
                $('#brand').val(brand);

                var standard_product_code_type_val = p_data.standard_product_code_type;                 
                $('#standard_product_code_type').val(standard_product_code_type_val);

                var standard_product_code_val = p_data.standard_product_code;

                standard_product_code_details(standard_product_code_type_val,standard_product_code_val);

                var shipping_weight_pounds = p_data.shipping_weight_pounds;
                $('#shipping_weight_pounds').val(shipping_weight_pounds);

                var package_width_inches = p_data.package_width_inches;
                $('#package_width_inches').val(package_width_inches);

                var package_height_inches = p_data.package_height_inches;
                $('#package_height_inches').val(package_height_inches);

                var package_length_inches = p_data.package_length_inches;
                $('#package_length_inches').val(package_length_inches);

                var display_width_inches = p_data.display_width_inches;
                $('#display_width_inches').val(display_width_inches);

                var display_height_inches = p_data.display_height_inches;
                $('#display_height_inches').val(display_height_inches);

                var display_length_inches = p_data.display_length_inches;
                $('#display_length_inches').val(display_length_inches);
                
                var country_of_origin = p_data.country_of_origin;
                $('#country_of_origin').val(country_of_origin);

                var manufacturer = p_data.manufacturer;
                $('#manufacturer').val(manufacturer);

                var mfr_part_number = p_data.mfr_part_number;
                $('#mfr_part_number').val(mfr_part_number);


                var prop65 = p_data.prop65;

                if(prop65 == "True") {
                  $("#prop65").prop( "checked", true);
                }

                var bullets = '';

                if(p_data.bullet1 !='') { 
                  $('#bullet1').val(p_data.bullet1);
                } 

                if(p_data.bullet2 !='') { 
                  $('#bullet2').val(p_data.bullet2);
                }

                if(p_data.bullet3 !='') { 
                  $('#bullet3').val(p_data.bullet3);
                }

                if(p_data.bullet4 !='') { 
                  $('#bullet4').val(p_data.bullet4);
                }

                if(p_data.bullet5 !='') { 
                  $('#bullet5').val(p_data.bullet5);
                }

                if(p_data.cpsia1 != "") {
                  $("#cpsia1").prop("checked", true);
                }

                if(p_data.cpsia2 != "") {
                  $("#cpsia2").prop("checked", true);
                }

                if(p_data.cpsia3 != "") {
                  $("#cpsia3").prop("checked", true);
                }

                if(p_data.cpsia4 != "") {
                  $("#cpsia4").prop("checked", true);
                }

                if(p_data.cpsia5 != "") {
                  $("#cpsia5").prop("checked", true);
                }

                if(p_data.cpsia6 != "") {
                  $("#cpsia6").prop("checked", true);
                }

                 var main_image_url = p_data.main_image_url;
                 if(main_image_url !='' ) {
                      $('#main_image_url').val(main_image_url);
                      $('#main_image').attr('src', main_image_url);
                      $('#main_image').show();
                 }  else {
                    $('#main_image_label').addClass('non-image-label');
                 }
 

                 var swatch_image_url = p_data.swatch_image_url;
                 if(swatch_image_url !='' ) {
                      $('#swatch_image_url').val(swatch_image_url);
                      $('#swatch_image').attr('src', swatch_image_url);
                      $('#swatch_image').show();
                 }  else {
                    $('#swatch_image_label').addClass('non-image-label');
                 }


                 var alternate_image1 = p_data.alternate_image1;
                 if(alternate_image1 !='' ) {
                      $('#alternate_image1_url').val(alternate_image1);
                      $('#alternate_image1').attr('src', alternate_image1);
                      $('#alternate_image1').show();
                 }  else {
                    $('#alternate_image1_label').addClass('non-image-label');
                 }
 

                 var alternate_image2 = p_data.alternate_image2;
                 if(alternate_image2 !='' ) {
                      $('#alternate_image2_url').val(alternate_image2);
                      $('#alternate_image2').attr('src', alternate_image2);
                      $('#alternate_image2').show();
                 }  else {
                    $('#alternate_image2_label').addClass('non-image-label');
                 }
 

                 var alternate_image3 = p_data.alternate_image3;
                 if(alternate_image3 !='' ) {
                      $('#alternate_image3_url').val(alternate_image3);
                      $('#alternate_image3').attr('src', alternate_image3);
                      $('#alternate_image3').show();
                 }  else {
                    $('#alternate_image3_label').addClass('non-image-label');
                 }
 

                 var alternate_image4 = p_data.alternate_image4;
                 if(alternate_image4 !='' ) {
                      $('#alternate_image4_url').val(alternate_image4);
                      $('#alternate_image4').attr('src', alternate_image4);
                      $('#alternate_image4').show();
                 }  else {
                    $('#alternate_image4_label').addClass('non-image-label');
                 }


                 var alternate_image5 = p_data.alternate_image5;
                 if(alternate_image5 !='' ) {
                      $('#alternate_image5_url').val(alternate_image5);
                      $('#alternate_image5').attr('src', alternate_image5);
                      $('#alternate_image5').show();
                 }  else {
                    $('#alternate_image5_label').addClass('non-image-label');
                 }
 

                 var alternate_image6 = p_data.alternate_image6;
                 if(alternate_image6 !='' ) {
                      $('#alternate_image6_url').val(alternate_image6);
                      $('#alternate_image6').attr('src', alternate_image6);
                      $('#alternate_image6').show();
                 }  else {
                    $('#alternate_image6_label').addClass('non-image-label');
                 }
 

                 var alternate_image7 = p_data.alternate_image7;
                 if(alternate_image7 !='' ) {
                      $('#alternate_image7_url').val(alternate_image7);
                      $('#alternate_image7').attr('src', alternate_image7);
                      $('#alternate_image7').show();
                 }   else {
                    $('#alternate_image7_label').addClass('non-image-label');
                 }


                 var alternate_image8 = p_data.alternate_image8;
                 if(alternate_image8 !='' ) {
                      $('#alternate_image8_url').val(alternate_image8);
                      $('#alternate_image8').attr('src', alternate_image8);
                      $('#alternate_image8').show();
                 }  else {
                    $('#alternate_image8_label').addClass('non-image-label');
                 }

                var jet_category = p_data.jet_browse_node_id;
                $('#jet_category').val(jet_category);

                var attributes_data = p_data.attributes_data;
                var attr_data = p_data.attr_data;
                //getattributes(jet_category, attributes_data);

                attr_listing(attr_data,attributes_data);   

                var jet_product_tax_code = p_data.product_tax_code;
                $('#jet_product_tax_code').val(jet_product_tax_code);

                var product_description = p_data.product_description;
                $('#product_description').val(product_description);

                var legal_disclaimer_description = p_data.legal_disclaimer_description;
                $('#legal_disclaimer_description').val(legal_disclaimer_description);

                var safety_warning = p_data.safety_warning;
                $('#safety_warning').val(safety_warning);    

                $(".selectpicker").selectpicker("refresh");
                $(".selectpicker").selectpicker("refresh");

                $('#product_details').show();
                $('#no-rep').hide();

                $('#standard_product_code_type').on('change', function()  
                {
                    var standard_product_code_type_val =  $(this).val();
                    var standard_product_code_val = '';
                    standard_product_code_details(standard_product_code_type_val,standard_product_code_val);
                });               

                $('#jet_category').on('change', function() 
                {
                    var jet_category =  $(this).val();
                    getattributes(jet_category,'');
                });

            } else {
               $('#product_details').hide();
               $('#no-rep').show();
            }
  			}
		  );
	}	
}

function getattributes(jet_category,attributes_val) {

    if(jet_category!='') {

        console.log("jet_category:"+jet_category);          
        $("#attributes_list").html('');
        $("#cat_loading").show();

        var jet_get_category_attributes_secure_key = $('#jet_get_category_attributes_secure_key').val();
      
        $.post( ajaxurl, {
                'action' : 'jet_get_category_attributes',
                'jet_category' : jet_category,
                'jet_get_category_attributes_secure_key' : jet_get_category_attributes_secure_key
            },
            function(res) {
                console.log(res); 

                var jet_path_res = $('#jet_path_res').html();
                var api_error = $('#api_error').html();

                if( (res!='') && (res!= jet_path_res) && (res!= api_error) ) { 
                    var attr_data  = $.parseJSON(res);
                    attr_listing(attr_data,attributes_val);                    
                } else {
                  alert(res);
                } 
                $("#cat_loading").hide(); 
            }
        ); 
    }       
}

function attr_listing(attr_lists, attributes_val) {
  var attributes = attr_lists.attributes;
  console.log('attributes length:'+attributes.length);

  if(attributes.length > 0) {    
      for(i=0;i<attributes.length;i++)  {
          var attribute_id = attributes[i].attribute_id;
          var attribute_description = attributes[i].attribute_description;
          var free_text = attributes[i].free_text;
          var variant = attributes[i].variant;

          var values = attributes[i].values;

          var type;

          var attributes_listing='';
          
          var ress = get_attr_val(attributes_val,attribute_id);

          console.log("ress:"+ress);

          console.log("attribute_id:"+attribute_id+"&attribute_description:"+attribute_description);
          console.log("free_text:"+free_text+"&variant:"+variant);

          var attribute_description1 = attribute_description.replace(/_/g, ' ');

          attributes_listing+='<div class="attrs_div">';
            attributes_listing+='<label class="product_label">'+attribute_description1+'</label>';

            if(attribute_id == 50) {
                type = "select";
            }  else if(jQuery.type(values) === "undefined")  {
                type = "input";
            }  else if(free_text == false) {
                type = "select";
            } else if(free_text == true)  {
                type = "input";
            }

            attributes_listing+='<span class="pdt_text">';

              if(type == "select")  {

                  var values1 = values.toString();
                  var values2 = values1.split(',');

                  attributes_listing+='<select class="pdt_text_inputs" id="attr'+attribute_id+'" name="attribute_vals[]">';
                  attributes_listing+='<option value="">-- Select Value --</option>';
                  for(j=0;j<values2.length;j++)
                  {
                      if(values2[j] == ress)
                      {
                          var value_selt = 'selected';
                      }
                      else
                      {
                          var value_selt = '';
                      }

                      attributes_listing+='<option value="'+values2[j]+'" '+value_selt+'>'+values2[j]+'</option>';
                  }

                  attributes_listing+='</select>';
              } else {
                attributes_listing+='<input type="text" class="pdt_text_inputs" id="attr'+attribute_id+'" name="attribute_vals[]" placeholder="'+attribute_description1+'"  value="'+ress+'" >';
              }
              attributes_listing+='<input type="hidden" name="attribute_ids[]" value="'+attribute_id+'">';
              
            attributes_listing+='</span>';                       
          attributes_listing+='</div><br/><br/><br/>';

          attributes_listing+='<div class="clearfix"></div>';

          console.log("type:"+type);

          $("#attributes_list").append(attributes_listing);
      }
  }
  
}

function get_attr_val(attributes_val,attribute_id)
{
    var resp = '';

    if(attributes_val.length > 0)
    {
        for(m=0;m<attributes_val.length;m++)
        {
            var attr_id = attributes_val[m]['attribute_id'];
            var attr_val = attributes_val[m]['attribute_value'];

            if(attr_id == attribute_id)
            {
                resp = attr_val;
            }
        }
    }

    return resp;
}


function standard_product_code_details(standard_product_code_type_val,standard_product_code_val)
{
   console.log("standard_product_code_type_val:"+standard_product_code_type_val+"&standard_product_code_val:"+standard_product_code_val);
   
   var maxlength;
   var placeholder_value;

   if(standard_product_code_type_val == 'GTIN-14')  {
       maxlength ='14';
       placeholder = 'GTIN-14 code';
   } else if(standard_product_code_type_val == 'EAN')   {
       maxlength ='13';
       placeholder = 'EAN code';
   } else if(standard_product_code_type_val == 'ISBN-10')   {
       maxlength='10';
       placeholder= 'ISBN-10 code';
   }  else if(standard_product_code_type_val == 'ISBN-13')   {
       maxlength='13';
       placeholder= 'ISBN-13 code';
   }  else if(standard_product_code_type_val == 'UPC')   {
       maxlength='12';
       placeholder= 'UPC code';
   }  else if(standard_product_code_type_val == 'ASIN')   {
       maxlength='20';
       placeholder= 'Amazon Standard Identification Number ';
   }

   var spc = '<input type="text" class="pdt_text_inputs" id="standard_product_code"  placeholder="'+placeholder+'" maxlength="'+maxlength+'" value="'+standard_product_code_val+'" required>';
   $('#spc').html(spc);
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
