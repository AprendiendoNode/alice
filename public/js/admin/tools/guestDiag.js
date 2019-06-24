$(function() {
	$('#fila-p').hide();
	$('#fila-p2').hide();
	refresh_table();
});

$('#btnDiag2').on('click', function(e){
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

$('#btnDiag').on('click', function(e){
	var codigoH = $('#codigoHotel').val();
	var roomNumba = $('#numeroHab').val();
	var _token = $('input[name="_token"]').val();

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
		//console.log('correcto todo');
		refresh_table2(codigoH, roomNumba);
		web_service();
	}
});

function web_service() {
	var codigoH = $('#codigoHotel').val();
	var roomNumba = $('#numeroHab').val();
	var _token = $('input[name="_token"]').val();
	$.ajax({
	    type: "POST",
	    url: "/DiagHuespedAjax2",
	    data: { _token : _token, hotelCode : codigoH, roomNum:  roomNumba},
	    success: function (data){
	      //console.log(data);
	      var parseo2 = JSON.parse(data);
	      if (parseo2.errores == "true"){
	      	//console.log('contiene errores');
	      	$('#table_palace').hide();
			$('#fila-p2').show();
			$('#results2').val("");
			$('#results2').val("Web Service Palace:\n");
			$('#results2').val($('#results2').val() + "Errores: " +parseo2.errores + "\n" + "Mensaje de Error: " + parseo2.mensaje);
	      }else{
	      	$('#table_palace').show();
			$('#fila-p2').hide();
			$('#results2').val("");
	      	table_palace_web(data, $('#table_palace'));
	      }

	    },
	    error: function (data) {
	      console.log('Error:', data);
	    }
	});

}

function table_palace_web(datajson, table) {
	table.DataTable().destroy();
	var vartable = table.dataTable(Configuration_table_responsive_with_pdf_enc_dominio);
	vartable.fnClearTable();
	var parseo = JSON.parse(datajson);
	vartable.fnAddData([
	  parseo.apellido,
	  parseo.nombre,
	  parseo.noches,
	  parseo.pais,
	  parseo.errores,
	]);

}

function refresh_table() {
	var _token = $('input[name="_token"]').val();
	$.ajax({
		type: "POST",
		url: "/existenceUsersAll",
		data: { _token : _token },
		success: function (data){
			// console.log(data); 
			table_group_content(data, $('#table_guests'));
		},
		error: function (data) {
		  console.log('Error:', data);
		}
	});
}

function refresh_table2(codigoH, roomNumba) {
	var _token = $('input[name="_token"]').val();
	$.ajax({
		type: "POST",
		url: "/existenceUsers",
		data: { _token : _token, hotelCode : codigoH, roomNum:  roomNumba },
		success: function (data){
			//console.log(data); 
			if (data.length === 0) {
				menssage_toast('Mensaje', '2', 'No se encontro ningun registro con ese numero de habitación!' , '3000');
			}
			table_group_content2(data, $('#table_guests'));
		},
		error: function (data) {
		  console.log('Error:', data);
		}
	});
}

function table_group_content(datajson, table){
	table.DataTable().destroy();
	var vartable = table.dataTable(Configuration_table_responsive_with_pdf_enc_dominio);
	vartable.fnClearTable();
	$.each(datajson, function(index, status){
		table.fnAddData([
		  status.username,
		  status.lastname,
		  status.expiration,
		  status.creationdate,
		  status.email,
		]);
	});
	/*for (var i = 0; i < datajson.length; i++) {
		for (var j = 0; j < datajson[i].length; j++) {
			table.fnAddData([
			    datajson[i][j].username,
			    datajson[i][j].lastname,
			    datajson[i][j].expiration,
			    datajson[i][j].creationdate,
			    datajson[i][j].email
		  	]);
		}
	}*/
}

function table_group_content2(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_pdf_enc_dominio);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.username,
      status.lastname,
      status.expiration,
      status.creationdate,
      status.email,
    ]);
  });
}