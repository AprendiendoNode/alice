$(function() {
	$(".select2").select2();

});

$('#select_one').on('change', function(){
	var select = $('#select_one').val();
	var _token = $('input[name="_token"]').val();
	//console.log(select);
	var zd = "";
	var zd1 = "";
	var zd2 = "";
	$.ajax({
	  type: "POST",
	  url: "/getInfoZD",
	  data: { _token : _token, select : select },
	  success: function (data){
	    //console.log(data);
	    if (data.length === 0) {
	    	if ($('#direccion_ip').val() === "" && $('#puerto_dir').val() === "") {
	    		menssage_toast('Mensaje', '2', 'Este hotel no cuenta con ip pública.' , '3000');
	    	}
	    }else if (data.length > 1) {
			zd1 = data[0].ip;
			zd2 = data[1].ip;
	    	swal("Este hotel cuenta con mas de una opcion elija su opcion.", {
	    		buttons: {
	    			cancel: "Cancelar",
	    			opcion1: {
	    				text: "ZD puerto 1",
	    				value: 1,
	    			},
	    			opcion2: {
	    				text: "ZD puerto 2",
	    				value: 2,
	    			},
	    		},	
	    	})
	    	.then((value) => {
	    		switch (value) {
	    			case 1:
	    				var ip1 = zd1.split(':');
	    				$('#direccion_ip').val(ip1[0]);
	    				$('#puerto_dir').val(ip1[1]);
	    				$('#select_one').val('').trigger('change');
	    				break;
	    			case 2:
	    				var ip2 = zd2.split(':');
	    				$('#direccion_ip').val(ip2[0]);
	    				$('#puerto_dir').val(ip2[1]);
	    				$('#select_one').val('').trigger('change');
	    				break;
	    			default:
	   					$('#select_one').val('').trigger('change');
	    		}
	    	});
	    }else{
	    	var zd = data[0].ip;
	    	var ip = zd.split(':');
	    	$('#direccion_ip').val(ip[0]);
	    	$('#puerto_dir').val(ip[1]);
	    	$('#select_one').val('').trigger('change');
	    }

	  },
	  error: function (data) {
	    console.log('Error:', data);
	  }
	});
	
});

$('#comprobarip').on('click', function(){
	var select = $('#select_one').val();
    var direc=$('#direccion_ip').val();
    var puert=$('#puerto_dir').val();
    var _token = $('input[name="_token"]').val();

    if (direccionip(direc) == '1') {
    	if (puert === '' || puert.length == 0) {
    		//ajax sin puerto.
			$.ajax({
			  type: "POST",
			  url: "/testzonedir",
			  data: { num_dir : direc , num_port : 161 ,_token : _token  },
			  success: function (data){
	            if (data === '0'){
	              menssage_toast('Mensaje', '4', 'Ping successful!.', '3000');
	            }
	            else {
	              var mens2='Timeout: No Response from'+direc+':'+puert;
	              menssage_toast('Mensaje', '2', mens2, '3000s');
	            }
			  },
			  error: function (data) {
			    console.log('Error:', data);
			  }
			});	
    	}else{
    		//ajax con puerto.
			$.ajax({
			  type: "POST",
			  url: "/testzonedir",
			  data: { num_dir : direc , num_port : puert ,_token : _token  },
			  success: function (data){
	            if (data === '0'){
	              menssage_toast('Mensaje', '4', 'Ping successful!.', '3000');
	            }
	            else {
	              var mens2='Timeout: No Response from'+direc+':'+puert;
	              menssage_toast('Mensaje', '2', mens2, '3000s');
	            }
			  },
			  error: function (data) {
			    console.log('Error:', data);
			  }
			});	

    	}
    }else{
		menssage_toast('Mensaje', '2', 'LLene los campos correctamente.' , '3000');
    }
});


$('#resetcomprobarip').on('click', function(){
    var direc=$('#direccion_ip').val('');
    var puert=$('#puerto_dir').val('');
});

function direccionip(inputText){
   var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
   if(inputText.match(ipformat)){
     return '1';
   }
   else  {
     return '0';
   }
}