$(function() {
  $(".select2").select2();


});

// configuracion para pdf excel, etc..
// Configuration_table_responsive_with_pdf_two

$('#select_one').on('change', function(e){
	var group = $(this).val();
	refresh_table(group, $('#table_group'));
});

$('#btn_create_group').on('click', function(e){
	var newtext = $('#new_group').val();
	var _token = $('input[name="_token"]').val();
	if (newtext === "" || newtext.length < 4) {
		menssage_toast('Mensaje', '2', 'Completa el campo correctamente.' , '3000');
	}else{
		// insert new group on new table.
		$.ajax({
			type: "POST",
			url: "/group_insert",
			data: { _token : _token,  text: newtext},
			success: function (data){
				//console.log(data);
				if (data === '1') {
					$('#new_group').val('');
					update_select_group();
					menssage_toast('Mensaje', '4', 'Datos insertados correctamente.' , '3000');
				}else{
					menssage_toast('Mensaje', '2', 'Error al momento de insertar, intenta nuevamente.' , '3000');
				}
			},
			error: function (data) {
			  console.log('Error:', data);
			}
		});
	}
});

$('#btn_update_group').on('click', function(e){
	var select = $('#select_one').val();
	var inputmac = $('#mac_input').val();

	var status1 = validarespacioinputlength('mac_input', 10);
	var status2 = validarSelect('select_one');
	if ( status1 == true && status2 == true) {
		//console.log('OK');
		//update group & show table with changes.
		update_group(select, inputmac);

	}else{
		menssage_toast('Mensaje', '2', 'Completa correctamente los campos. Al menos 12 caracteres en el campo de mac.' , '3000');
	}
});

$('#btn_change_group').on('click', function(e){
	var status1 = validarSelect('select_one');
	var status2 = validarSelect('select_hotels');
	var status3 = validarSelect('select_estados');

	if (status1 == true && status2 == true && status3 == true) {
		$('#modal-confirmation').modal('show');
	}else{
		menssage_toast('Mensaje', '2', 'Completa correctamente los campos. (Grupo Exs, Hotel, Estatus)' , '3000');
	}
});

$(".btn-conf-action").click(function(event) {
	var group_id = $('#select_one').val();
	var hotel_id = $('#select_hotels').val();
	var status_id = $('#select_estados').val();
	var _token = $('input[name="_token"]').val();
	$.ajax({
		type: "POST",
		url: "/move_group",
		data: {  group : group_id, hotel : hotel_id, status : status_id, _token : _token  },
		success: function (data){
			console.log(data);
			if (data === '1') {
				menssage_toast('Mensaje', '4', 'Datos actualizados.' , '3000');
				refresh_table(group_id, $('#table_group'));
				$('#select_hotels').val('').trigger('change');
				$('#select_estados').val('').trigger('change');
				$('#mac_input').val("");
				$('#modal-confirmation').modal('toggle');

			}else{
				$('#modal-confirmation').modal('toggle');
				menssage_toast('Mensaje', '2', 'Se encontro un error: Revisar la mac address.' , '3000');
			}
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
});

$('#btn_update_group2').on('click', function(e){
	var newtext = $('#new_group').val();
	var select = $('#select_one').val();
	var inputmac = $('#mac_input').val();

	if (newtext != "" && select != "" && inputmac != "") {
		menssage_toast('Mensaje', '2', 'Elija que campo de grupo usar.' , '3000');
	}else if (newtext != "" && inputmac != "") {
		update_group(newtext, inputmac);
		emptySelect();
		update_select_group();
		$('#mac_input').focus();
	}else if (select != "" && inputmac != "") {
		update_group(select, inputmac);
		emptySelect();
		update_select_group();
		$('#mac_input').focus();
	}else if (newtext != "" || select != "") {
		menssage_toast('Mensaje', '2', 'Completa los campos necesarios.' , '3000');
	}else{
		menssage_toast('Mensaje', '2', 'Completa los campos necesarios.' , '3000');
	}
});

function update_group(datos, mac) {
	var _token = $('input[name="_token"]').val();
	$.ajax({
		type: "POST",
		url: "/update_group_equipment",
		data: { select1: datos, mac: mac, _token: _token },
		success: function (data){
		  //console.log(data);
		  if (data[0].valor === '1') {
		  	menssage_toast('Mensaje', '4', 'Datos actualizados.' , '3000');
		  	refresh_table(datos, $('#table_group'));

		  	//$('#select_one').val('').trigger('change');
		  	$('#mac_input').val("");

		  }else{
		  	menssage_toast('Mensaje', '2', 'La mac ya se encuentra en este grupo.' , '3000');
		  	$('#mac_input').val("");
		  }
		},
		error: function (data) {
		  console.log('Error:', data);
		}
	});
}


function update_select_group() {
	var _token = $('input[name="_token"]').val();
	dataselect = [];
	// var data_count = [{value:335, name:'Ap Stock = 335'},{value:310, name:'Ap Renta = 310'},{value:234, name:'Ap Prestamo = 234'},{value:135, name:'Ap Venta = 135'},{value:1315, name:'Ap Demo = 1315'},{value:1548, name:'SW Renta = 1548'}];

	$.ajax({
		type: "POST",
		url: "/get_new_groups",
		data: { _token : _token},
		success: function (data){
			//console.log(data);
			emptySelect();
			dataselect.push({id : "", text : "Elija"});
			$.each(JSON.parse(data), function(index, datos){
				dataselect.push({id: datos.id, text: datos.name});
			});
			//console.log(dataselect);
			$('#select_one').select2({
				data : dataselect
			});
		},
		error: function (data) {
		  console.log('Error:', data);
		}
	});
}



function refresh_table(group, table) {
	var _token = $('input[name="_token"]').val();
	$.ajax({
		type: "POST",
		url: "/get_table_group",
		data: { select1: group, _token: _token },
		success: function (data){
			//console.log(data);
			table_group_content(data, table);
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
}

function table_group_content(datajson, table){
	table.DataTable().destroy();
	var vartable = table.dataTable(Configuration_table_responsive_with_pdf_two);
	vartable.fnClearTable();
	$.each(JSON.parse(datajson), function(index, status){
	  table.fnAddData([
	    status.name,
	    status.MAC,
	    status.Serie,
	    status.Nombre_marca,
	    status.ModeloNombre
	  ]);
	});
  document.getElementById("table_group_wrapper").childNodes[0].setAttribute("class", "form-inline");
}

function emptySelect() {
	$('#select_one').empty();
	$('#select_one').select2("destroy");
}

function validarSelect(campo) {
  if (campo != '') {
    select=document.getElementById(campo).selectedIndex;
    if( select == null || select == 0 ) {
      return false;
    }
    else {
      return true;
    }
  }
  else {
    return false;
  }
}

function validarespacioinputlength(campo, campob){
  if( $("#"+campo).val().trim()==='' || $("#"+campo).val().length < campob ) {
    return false;
  }
  else {
    return true;
  }
}


function convertMac(value) {
	//DBDBDBDBDBDB 5 espacios.
	//12 + 5 = 17
	//DB DB DB DB DB DB
	let status = 0;
	let newstr = "";
	var parts = []
	countstr = value.length;
	//console.log(value.length);
	if (countstr < 17) {
		parts = value.match(/[\s\S]{1,2}/g) || [];
		for (var i = 0; i < parts.length; i++) {
			newstr = newstr + parts[i] + ':';
		}
		//console.log(newstr);
		newstr = newstr.substr(0, newstr.length - 1);
		//console.log(newstr);
		return status = 1;
	}else if (countstr = 17) {
		return status = 1;
	}else{
		//console.log('string > 17');
		return status;
	}
	return status;
	// count = parts.length;
	// console.log(parts);
	// console.log(count);
}
