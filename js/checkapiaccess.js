function checkaccess() {
        var jet_checkapiaccess_secure_key = $('#jet_checkapiaccess_secure_key').val();
        var result = '';
        $.ajax({
                type: "POST",
                url : ajaxurl,		
                async: false,
                data:{
                	'action':'jet_checkapiaccess',
                	'jet_checkapiaccess_secure_key' : jet_checkapiaccess_secure_key
                },
                success: function(res) {
                	result = $.trim(res);
                	console.log('checkapi response:'+result);
                }
        });

        return result;
}