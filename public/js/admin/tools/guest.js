$('#fila-p').hide();
$('#fila-p2').hide();


$('#btnDiag').on('click', function(e){
	var codigoH = $('#codigoHotel').val();
	var roomNumba = $('#numeroHab').val();

	if (codigoH == '' || roomNumba == ''){
		swal({
			title: "Error",
			text: "Favor de seleccionar uno de los códigos de hotel y agregar número de habitación!",
			type: "error",
		});
	}else if(roomNumba.length < 3 || roomNumba.length > 5){
		swal({
			title: "Error",
			text: "El número de habitacion tiene que ser de 3 a 5 digitos!",
			type: "error",
		});
	}else{
		$.get('/DiagHuespedAjax?hotelCode=' + codigoH + '&roomNum=' + roomNumba, function(data){
			//console.log(data);
			swal({
				title: "Buscando",
				text: "La información será desplegada a continuación",
				type: "success",
				timer: 2000,
			});

			$('#fila-p').show();
			$('#results').val("");
			$('#results').val("Usuarios en base de datos:\n");

			if (typeof data === 'undefined' || !data || data == "" || data == null || data.length === 2){
				$('#results').val($('#results').val() + "No Existe en Base de Datos." + "\n");
			}else{
				$.each(JSON.parse(data), function(index, datosQuery){
					$('#results').val($('#results').val() + datosQuery.username + " | Fecha de Creación: " + datosQuery.createdate + " | Fecha de expiración: " + datosQuery.expiration + "\n");
				});
			}
		});

		$.get('/DiagHuespedAjax2?hotelCode=' + codigoH + '&roomNum=' + roomNumba, function(data){
			//console.log(data);

			var parseo2 = JSON.parse(data);
			//console.log(parseo2);
			$('#fila-p2').show();
			$('#results2').val("");
			$('#results2').val("Web Service Palace:\n");

			if (parseo2.errores == "false"){
				$('#results2').val($('#results2').val() + "\nNombres: " +parseo2.nombre + "\n" + "Apellido: " + parseo2.apellido + "\n" + "Noches de estancia: " + parseo2.noches + " + 1" + "\n");
			}else{
				$('#results2').val($('#results2').val() + "Errores: " +parseo2.errores + "\n" + "Mensaje de Error: " + parseo2.mensaje);
			}

		});
	}

});
