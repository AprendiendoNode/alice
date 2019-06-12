$(document).ready(function () {
	$('#btnDiagRAD').on('click', function(e){
		var codigoH = $('#codigoHotel').val();

		if (codigoH == ''){
			swal({
				title: "Error",
				text: "Favor de seleccionar uno de los códigos de hotel!",
				type: "error",
			});
		}else{
			$.get('/DiagServidorAjax?hotelCode=' + codigoH, function(data){
				if (data == "TRUE"){
					swal({
						title: "Servidor Activo",
						text: "El servidor se encuentra online y funcionando correctamente.",
						type: "success",
					});
				}else{
					swal({
						title: "Servidor OFFLINE",
						text: "El servidor se encuentra fuera de linea favor de revisar!",
						type: "error",
					});
				}

			});
		}
	});

	$('#btnDiagWB').on('click', function(e){
		var codigoH = $('#codigoHotel').val();

		if (codigoH == ''){
			swal({
				title: "Error",
				text: "Favor de seleccionar uno de los códigos de hotel!",
				type: "error",
			});
		}else{
			$.get('/DiagServidorAjax2?hotelCode=' + codigoH, function(data){
				//console.log(data);

				if (data.errores == "false" || data.errores == "true"){
					swal({
						title: "WebService Activo",
						text: "El WebService se encuentra online y funcionando correctamente.",
						type: "success",
					});
				}else{
					swal({
						title: "WebService OFFLINE",
						text: "El WebService se encuentra fuera de linea favor de revisar!",
						type: "error",
					});
				}

			});
		}
	});
});