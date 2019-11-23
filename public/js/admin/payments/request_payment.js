// $(function() {
//   $(".select2").select2();
// })

$('#project').on('change',function(){
  var id = $('#project').val();
  $('#idProject').text('');
  $('#customer').empty();
  $('#customer').append('<option value="">Elegir...</option>');
  // $('#provider').empty();
  // $('#provider').append('<option value="">Elegir...</option>');
  // $('#provider').val('').trigger('change');
  getHotels();
})

//Implementacion de conversion de numeros a letras
$('#amount').on('keyup',function(){
  var number = $('#amount').val();
  var cadena = NumeroALetras(number)+" ";
  cadena+= 'M.N. ' + $("#coin option:selected").text();
  $('#amountText').val(cadena);
})

//Cambio de moneda
$('#coin').on('change',function(){
  var number = $('#amount').val();
  var cadena = NumeroALetras(number)+" ";
  cadena+= 'M.N. ' + $("#coin option:selected").text();
  $('#amountText').val(cadena);
})

//Obtener hoteles de la cadena
function getHotels() {
  var id = $('#project').val();
  var _token = $('input[name="_token"]').val();
  var datax;
  $.ajax({
    type: "POST",
    url: "/get_hotel_cadena",
    data: { data_one : id, _token : _token },
    success: function (data){
      datax = JSON.parse(data);
      if ($.trim(data)){
        $.each(datax, function(i, item) {
            $('#customer').append("<option value="+item.id+">"+item.Nombre_hotel+"</option>");
        });
      }
      else{
        $("#customer").text('');
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}


$('#customer').on('change', function(e){
  var id= $(this).val();
  // $('#provider').empty();
  // $('#provider').append('<option value="">Elegir...</option>');
  getProyect(id);
  // getProveedor(id);
});

function getProyect(id_proyect) {
  var id = id_proyect;
  var _token = $('input[name="_token"]').val();
  var datax;

  $.ajax({
    type: "POST",
    url: "/get_proyecto_hotel",
    data: { data_one : id, _token : _token },
    success: function (data){
      datax = JSON.parse(data);
      if ($.trim(data)){
          $('#idProject').val(datax[0].id_proyecto);
      }
      else{
        $("#customer").text('');
        alert('error');
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function getProveedor(id_cliente) {
  var id = id_cliente;
  var _token = $('input[name="_token"]').val();
  var datax;

  $.ajax({
    type: "POST",
    url: "/get_proveedor",
    data: { data_one : id, _token : _token },
    success: function (data){
      datax = JSON.parse(data);

      if ($.trim(data)){
          $.each(datax,function(i,item){
            $('#provider').append("<option value="+item.id+">"+item.Proveedor+"</option>");
          })
      }
      else{
        $("#customer").text('');
        alert('error');
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}

//Datos bancarios

$('#provider').on('change',function(){
  $('#bank').empty();
  $('#bank').append('<option value="">Elegir...</option>');
   getBank();
})

function getBank(){
  var id_client = $('#customer').val();
  var id_prov = $('#provider').val();

  var _token = $('input[name="_token"]').val();
  var datax;

  $.ajax({
    type: "POST",
    url: "/get_data_bank",
    data: { data_one : id_client, data_two : id_prov , _token : _token },
    success: function (data){
      //console.log(data);
      if (data == null || data == '[]') {
        $('#bank').empty();
        $('#bank').append('<option value="">Elegir...</option>');
      }
      else{
        datax = JSON.parse(data);
        if ($.trim(data)){
          $.each(datax, function(i, item) {
            $('#bank').append("<option value="+item.id+">"+item.banco+"</option>");
          });
        }
        else{
          $("#customer").text('');
          alert('error');
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}

$('#bank').on('change',function(){
  $('#account').empty();
  $('#account').append('<option value="">Elegir...</option>');
  $('#clabe').val('');
  $('#reference_banc').val('');
  getCuentaClabe();
})

function getCuentaClabe(){
  var id_bank  = $('#bank').val();
  var id_prov = $('#provider').val();

  var _token = $('input[name="_token"]').val();
  var datax;
  $.ajax({
    type: "POST",
    url: "/get_account_clabe",
    data: { data_one : id_prov, data_two : id_bank , _token : _token },
    success: function (data){
      if (data == null || data == '[]') {
        $('#account').empty();
        $('#account').append('<option value="">Elegir...</option>');
        $('#clabe').val('');
        $('#reference_banc').val('');
      }
      else{
        datax = JSON.parse(data);
        if ($.trim(data)){
          $.each(datax,function(i,item){
            $('#account').append("<option value="+item.id+">"+item.cuenta+"</option>");
            $('#clabe').val('');
            $('#reference_banc').val('');
          })
        }
        else{
          $('#clabe').val('');
          $('#reference_banc').val('');
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}


//Cuenta
$('#account').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();
  $('#clabe').val('');
  $('#reference_banc').val('');
  getdataCuenta(id, _token);
})
function getdataCuenta(campoa, campob){
  $.ajax({
    type: "POST",
    url: "/get_data_accw",
    data: { data_one : campoa, _token : campob },
    success: function (data){
      if (data == null || data == '[]') {
        $('#reference_banc').val('');
        $('#clabe').val('');
      }
      else {
        if ($.trim(data)){
          datax = JSON.parse(data);
          $('#clabe').val(datax[0].clabe);
          $("#reference_banc").val(datax[0].referencia);
        }
        else {
          $('#reference_banc').val('');
          $('#clabe').val('');
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}

//Check boxes

$('input[name=tipoServicio]').on('change',function(){
  var checkboxes = document.getElementById("solicitudPagoForm").checkbox;
  var cont = 0;

  for (var x=0; x < checkboxes.length; x++) {
     if (checkboxes[x].checked) {
      cont = cont + 1;
     }
  }
  console.log(cont);
})

//Funcionalidad para convertir numero a letras

function Unidades(num){

  switch(num)
  {
    case 1: return "UN";
    case 2: return "DOS";
    case 3: return "TRES";
    case 4: return "CUATRO";
    case 5: return "CINCO";
    case 6: return "SEIS";
    case 7: return "SIETE";
    case 8: return "OCHO";
    case 9: return "NUEVE";
  }

  return "";
}

function Decenas(num){

  decena = Math.floor(num/10);
  unidad = num - (decena * 10);

  switch(decena)
  {
    case 1:
      switch(unidad)
      {
        case 0: return "DIEZ";
        case 1: return "ONCE";
        case 2: return "DOCE";
        case 3: return "TRECE";
        case 4: return "CATORCE";
        case 5: return "QUINCE";
        default: return "DIECI" + Unidades(unidad);
      }
    case 2:
      switch(unidad)
      {
        case 0: return "VEINTE";
        default: return "VEINTI" + Unidades(unidad);
      }
    case 3: return DecenasY("TREINTA", unidad);
    case 4: return DecenasY("CUARENTA", unidad);
    case 5: return DecenasY("CINCUENTA", unidad);
    case 6: return DecenasY("SESENTA", unidad);
    case 7: return DecenasY("SETENTA", unidad);
    case 8: return DecenasY("OCHENTA", unidad);
    case 9: return DecenasY("NOVENTA", unidad);
    case 0: return Unidades(unidad);
  }
}//Unidades()

function DecenasY(strSin, numUnidades){
  if (numUnidades > 0)
    return strSin + " Y " + Unidades(numUnidades)

  return strSin;
}//DecenasY()

function Centenas(num){

  centenas = Math.floor(num / 100);
  decenas = num - (centenas * 100);

  switch(centenas)
  {
    case 1:
      if (decenas > 0)
        return "CIENTO " + Decenas(decenas);
      return "CIEN";
    case 2: return "DOSCIENTOS " + Decenas(decenas);
    case 3: return "TRESCIENTOS " + Decenas(decenas);
    case 4: return "CUATROCIENTOS " + Decenas(decenas);
    case 5: return "QUINIENTOS " + Decenas(decenas);
    case 6: return "SEISCIENTOS " + Decenas(decenas);
    case 7: return "SETECIENTOS " + Decenas(decenas);
    case 8: return "OCHOCIENTOS " + Decenas(decenas);
    case 9: return "NOVECIENTOS " + Decenas(decenas);
  }

  return Decenas(decenas);
}//Centenas()

function Seccion(num, divisor, strSingular, strPlural){
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)

  letras = "";

  if (cientos > 0)
    if (cientos > 1)
      letras = Centenas(cientos) + " " + strPlural;
    else
      letras = strSingular;

  if (resto > 0)
    letras += "";

  return letras;
}//Seccion()

function Miles(num){
  divisor = 1000;
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)

  strMiles = Seccion(num, divisor, "UN MIL", "MIL");
  strCentenas = Centenas(resto);

  if(strMiles == "")
    return strCentenas;

  return strMiles + " " + strCentenas;

}//Miles()

function Millones(num){
  divisor = 1000000;
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)

  strMillones = Seccion(num, divisor, "UN MILLON", "MILLONES");
  strMiles = Miles(resto);

  if(strMillones == "")
    return strMiles;

  return strMillones + " " + strMiles;

}//Millones()

function NumeroALetras(num){
  var data = {
    numero: num,
    enteros: Math.floor(num),
    centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
    letrasCentavos: "",
    letrasMonedaPlural: "",
    letrasMonedaSingular: ""
  };

  if (data.centavos > 0)
    data.letrasCentavos = "CON " + data.centavos + "/100";

  if(data.enteros == 0)
    return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos + "";
  if (data.enteros == 1)
    return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
  else
    return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos ;
}//NumeroALetras()

  // $("#validation").on("submit",function(e){
  //   e.preventDefault();
  //   alert("Enviando");
  // });
