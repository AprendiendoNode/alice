var token = $('input[name="_token"]').val();
const headers = new Headers({
  "Accept": "application/json",
  "X-Requested-With": "XMLHttpRequest",
  "X-CSRF-TOKEN": token
});
$(function() {
/*  $('#date_to_search').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "days",
    minViewMode: "days",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });*/

  //var daynow = moment().format("YYYY-MM-DD");
  //$('#date_to_search').val(daynow);
  // console.log(daynow);
  //get_info_banks();
});

var d = new Date();
var month = d.getMonth();
var day = d.getDate();
var output = d.getFullYear() + '-' +((''+month).length<2 ? '0' : '') + month;
//$('.mes_nps').text(output);
var _token = $('input[name="_token"]').val();

$('.filtrarDashboard').on('click', function(){
  var date = $('#date_to_search').val();
  var year=$('#year_to_search').val();
  if (date === "" || date>53) {
    swal("Error!", "Ingrese un número de semana valido.", "error");
  }if(year==="" || year <2000){
    swal("Error!", "Ingrese un año valido.", "error");
  }else{
    // get_info_banks();
    // get_table_bank_mx();

    get_info_banks_mxn();
    get_info_banks_usd();
    get_info_banks_ex();
    get_info_banks_cred_rev();
    get_all_banks();
    get_cxc_cxp();
    get_table_values();
    table_cxc_vencidas();
  }
});
/*function get_info_banks() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  var datanow = $('#date_to_search').val();
  $.ajax({
    type: "POST",
    url: "/get_info_banks",
    data: { _token : _token, date: datanow },
    success: function (data){
      //console.log(data);
      // table_banks(data, $("#table_banks"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}*/
function get_table_bank_mx(){
  var datanow = $('#date_to_search').val();
  var init = { method: 'get',
               headers: headers,
               credentials: "same-origin",
               cache: 'default' };
  if(datanow != null && datanow != undefined){
    fetch(`/get_info_banks_mxn/${datanow}/1`, init)
      .then(response => {
        return response.text();
      })
      .then(data => {
        $('.table_dyn_mx').html('');
        $('.table_dyn_mx').html(data);
      })
      .catch(error => {
        console.log(error);
      })
  }
}

function get_info_banks_mxn() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  var datanow = $('#date_to_search').val();
  $.ajax({
    type: "POST",
    url: "/get_info_banks_mxn",
    data: { _token : _token, date: datanow },
    success: function (data){
      // console.log(data);
    //  var order=["CH PESOS BX","Santander Pesos","HSBC PESOS","Multiva","Bancomer"];
 var sortedData= data.sort(function(a, b) {
  var arrayOrder = ["CH PESOS BX","MOVIMIENTOS (Sin Barredora)", "Santander Pesos", "HSBC PESOS", "Multiva", "Bancomer"];
  function getIndex(x) {
    return arrayOrder.indexOf(x.banco);
  }

  return (getIndex(a) - getIndex(b)) ;
});
//console.log(sortedData);
    table_banks_mxn(data, $("#table_banks1"));
    total_global();
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function get_info_banks_usd() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  var datanow = $('#date_to_search').val();
  $.ajax({
    type: "POST",
    url: "/get_info_banks_usd",
    data: { _token : _token, date: datanow },
    success: function (data){
       //console.log(data);
      var sortedData= data.sort(function(a, b) {
       var arrayOrder = ["CH DLLES BX", "Santander Dólares", "HSBC Dolares"];
       function getIndex(x) {
         return arrayOrder.indexOf(x.banco);
       }

       return (getIndex(a) - getIndex(b)) ;
     });
     //data[0].saldo_final= -2467322;
      table_banks(data, $("#table_banks2"));
      total_global();
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function get_info_banks_ex() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  var datanow = $('#date_to_search').val();
  $.ajax({
    type: "POST",
    url: "/get_info_banks_ex",
    data: { _token : _token, date: datanow },
    success: function (data){
    //  console.log(data);
      var sortedData= data.sort(function(a, b) {
       var arrayOrder = ["Dominicana Dólares","Costa Rica Dólares","Dominicana (DOP)","Costa Rica  (CRC)"];
       function getIndex(x) {
         return arrayOrder.indexOf(x.banco);
       }

       return (getIndex(a) - getIndex(b)) ;
     });
      table_banks(sortedData, $("#table_banks3"));
      total_global();
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function get_info_banks_cred_rev() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  var datanow = $('#date_to_search').val();
  $.ajax({
    type: "POST",
    url: "/get_info_banks_cred_rev",
    data: { _token : _token, date: datanow },
    success: function (data){
    //  console.log(data);
      var sortedData= data.sort(function(a, b) {
       var arrayOrder = ["CH PESOS BX REV","Santander Pesos REV","HSBC Pesos REV"];
       function getIndex(x) {
         return arrayOrder.indexOf(x.banco);
       }

       return (getIndex(a) - getIndex(b)) ;
     });
      table_banks_rev(sortedData, $("#table_banks4"));
      //total_global();
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function total_global(){
  var t1_i=parseInt($("#t1_i").text().replace(",","").replace("(","").replace(")",""));
  var t1_f=parseInt($("#t1_f").text().replace(",","").replace("(","").replace(")",""));
  var t2_i=parseInt($("#t2_i").text().replace(",","").replace("(","").replace(")",""));
  var t2_f=parseInt($("#t2_f").text().replace(",","").replace("(","").replace(")",""));
  var t3_i=parseInt($("#t3_i").text().replace(",","").replace("(","").replace(")",""));
  var t3_f=parseInt($("#t3_f").text().replace(",","").replace("(","").replace(")",""));
  var gt_i=(parseInt(t1_i+t2_i+t3_i)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  var gt_f=(parseInt(t1_f+t2_f+t3_f)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  $("#gt_i").text(gt_i);
  $("#gt_f").text(gt_f);
}

function table_banks(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_banks);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.banco,
      // status.semana,
      status.saldo_inicial.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.deposito.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.retiro.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.saldo_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.saldo_inicial_mxn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.saldo_final_mxn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    ]);
  });
}
function table_banks_mxn(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_banks);
  vartable.fnClearTable();
  var bucle=0;
  var deposito=0;
  var retiro=0;
  var depos_mov=0;
  var ret_mov=0;
  $.each(datajson, function(index, status){
    //console.log(status.deposito.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    vartable.fnAddData([
      status.banco,
      // status.semana,
      status.saldo_inicial.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      bucle==1? (deposito-status.deposito.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace(/,/g, '')).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","): status.deposito.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      bucle==1? (retiro-status.retiro.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace(/,/g, '')).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","): status.retiro.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.saldo_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.saldo_inicial_mxn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.saldo_final_mxn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    ]);
    if(bucle==0){
      deposito=status.deposito.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace(/,/g, '');
      retiro=status.retiro.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace(/,/g, '');
    }
    if(bucle==1){
      depos_mov=(deposito-status.deposito.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace(/,/g, '')).toString();
      ret_mov=(retiro-status.retiro.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace(/,/g, '')).toString();
    }

    bucle++;
  });
  var total_dep=($("#tdep_mov").text().replace(",","").replace("(","").replace(")","")).toString();
  var total_ret=($("#tret_mov").text().replace(",","").replace("(","").replace(")","")).toString();


  $("#tdep_mov").text(total_dep-depos_mov);
  $("#tret_mov").text(total_ret-ret_mov);
}


function table_banks_rev(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_banks);
  vartable.fnClearTable();
  var bucle=0;
  $.each(datajson, function(index, status){
    //console.log(parseInt(status.saldo_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g,"").replace(/,/g, '')));
    vartable.fnAddData([
      status.banco,
      // status.semana,
      status.saldo_inicial.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.deposito.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.retiro.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.saldo_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      //status.saldo_inicial_mxn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    //  status.saldo_final_mxn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.saldo_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      bucle==0? (285-status.saldo_final): bucle==1? (5000+parseInt(status.saldo_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g,"").replace(/,/g, ''))): (6000+parseInt(status.saldo_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g,"").replace(/,/g, ''))),
      bucle==0? 285: bucle==1? 5000 : 6000,
      ""
    ]);
    bucle++;
  });
  var grantotal=parseInt(($("#gt_f").text().replace(",","").replace("(","").replace(")","")).toString());
  var rev_disp=parseInt(($("#rev_disp").text().replace(",","").replace("(","").replace(")","")).toString());

  $("#liquidez_tot").text((grantotal+rev_disp).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}

function get_all_banks() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  var datanow = $('#date_to_search').val();
  var year=$('#year_to_search').val();
  $.ajax({
    type: "POST",
    url: "/get_all_banks",
    data: { _token : _token, date: datanow,year:year },
    success: function (data){
      //console.log(data);
      table_banks_all(data, $('#table_all_banks'));
      //Ajustando saldos manualmente
         $("#saldo_inicial_mxn").text(data[0].Saldo_Inicial_MXM);
         var saldo_ini = parseInt($("#saldo_inicial_mxn").text().replace(",","").replace("(","").replace(")",""));
         var depositos = parseInt($("#depositos_mxn").text().replace(",","").replace("(","").replace(")",""));
         var retiros = parseInt($("#retiros_mxn").text().replace(",","").replace("(","").replace(")",""));
         $("#saldo_final_mxn").text((saldo_ini+depositos-retiros).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
         if(saldo_ini < 0) $("#saldo_inicial_mxn").addClass("negative negativeleft negativeright");
         else $("#saldo_inicial_mxn").removeClass("negative negativeleft negativeright");
         if((saldo_ini + depositos - retiros) < 0) $("#saldo_final_mxn").addClass("negative negativeleft negativeright");
         else $("#saldo_final_mxn").removeClass("negative negativeleft negativeright");
         $("#saldo_inicial_usd").text(data[0].Saldo_Inicial_USD);
         saldo_ini = parseInt($("#saldo_inicial_usd").text().replace(",","").replace("(","").replace(")",""));
         depositos = parseInt($("#depositos_usd").text().replace(",","").replace("(","").replace(")",""));
         retiros = parseInt($("#retiros_usd").text().replace(",","").replace("(","").replace(")",""));
         $("#saldo_final_usd").text((saldo_ini+depositos-retiros).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
         if(saldo_ini < 0) $("#saldo_inicial_usd").addClass("negative negativeleft negativeright");
         else $("#saldo_inicial_usd").removeClass("negative negativeleft negativeright");
         if((saldo_ini + depositos - retiros) < 0) $("#saldo_final_usd").addClass("negative negativeleft negativeright");
         else $("#saldo_final_usd").removeClass("negative negativeleft negativeright");

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}
function table_banks_all(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_banks);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.Semana,
      status.fechaini.split("-").reverse().join("-"),
      status.fechafin.split("-").reverse().join("-"),
      status.Saldo_Inicial_MXM.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.Depositos_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.Retiros_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.Saldo_Final_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.Saldo_Inicial_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.Depositos_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.Retiros_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.Saldo_Final_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    ]);
  });
}
function get_cxc_cxp() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  var datanow = $('#date_to_search').val();
  var year=$('#year_to_search').val();

  $.ajax({
    type: "POST",
    url: "/get_cxc_cxp",
    data: { _token : _token, date: datanow,year:year },
    success: function (data){
      //console.log(data);
      //console.log($('#dollar').val());
      table_payments(data, $('#table_cxc'));
      var current_dollar=$('#dollar').val();
      var ingresado_MXN = (data[4].ingresado_MXN).toString();
      var ingresado_USD = (data[4].ingresado_USD).toString();
      var res_i_s = parseInt((parseInt(ingresado_MXN.replace(",","")))+(parseInt(ingresado_USD.replace(",","")*current_dollar ) )).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      $("#Semana_Ingresado_MXN").text(res_i_s);
      var por_cobrar_MXN=(data[4].por_cobrar_MXN).toString();
      var por_cobrar_USD=(data[4].por_cobrar_USD).toString();
      var res_pc_s=parseInt(parseInt(por_cobrar_MXN.replace(",",""))+(parseInt(por_cobrar_USD.replace(",","")*current_dollar ) )).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      $("#Semana_PorCobrar_MXN").text(res_pc_s);
      var pagado_MXN = (data[4].pagado_MXN).toString();
      var pagado_USD = (data[4].pagado_USD).toString();
      var res_p_s =parseInt(parseInt(pagado_MXN.replace(",",""))+(parseInt(pagado_USD.replace(",",""))*current_dollar ) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      $("#Semana_Pagado_MXN").text(res_p_s);
      var por_pagar_MXN=(data[4].por_pagar_MXN).toString();
      var por_pagar_USD=(data[4].por_pagar_USD).toString();
      var res_pp_s = parseInt(parseInt(por_pagar_MXN.replace(",",""))+(parseInt(por_pagar_USD.replace(",",""))*current_dollar ) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      $("#Semana_PorPagar_MXN").text(res_pp_s);
      var tot_ing_acum_mxn = parseInt($('#tot_ing_acum_mxn').text().replace(",","").replace("(","").replace(")",""));
      var tot_ing_acum_usd =parseInt($('#tot_ing_acum_usd').text().replace(",","").replace("(","").replace(")",""));
      var tot_ing_mxn=(parseInt(tot_ing_acum_mxn+(tot_ing_acum_usd*current_dollar))).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      $('#Total_Ingresado_MXN').text(tot_ing_mxn);
      var tot_pag_acum_mxn = parseInt($('#tot_pag_acum_mxn').text().replace(",","").replace("(","").replace(")",""));
      var tot_pag_acum_usd =parseInt($('#tot_pag_acum_usd').text().replace(",","").replace("(","").replace(")",""));
      var tot_pag_mxn=(parseInt(tot_pag_acum_mxn+(tot_pag_acum_usd*current_dollar))).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      $('#Total_Pagado_MXN').text(tot_pag_mxn);
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function table_payments(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_banks);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.semana,
      status.fechaini.split("-").reverse().join("-"),
      status.fechafin.split("-").reverse().join("-"),
      status.ingresado_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.por_cobrar_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.ingresado_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.por_cobrar_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.pagado_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.por_pagar_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.pagado_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.por_pagar_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    ]);
  });
}
function get_table_values() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  var datanow = $('#date_to_search').val();
  $.ajax({
    type: "POST",
    url: "/get_table_bankvals",
    data: { _token : _token, date: datanow },
    success: function (data){
    //console.log(data);
      var sortedData= data.sort(function(a, b) {//Ordenamos los datos

       var arrayOrder = ["Traspasos, venta divisas","Traspasos, venta divisas (DOP,CRC)","Créditos, arrendamientos, intereses, Comisiones bancarias, Impuestos","Ingresos CxC/PagosCxP","Movimientos por identificar/Fuera del sistema","Devuelto, rechazado por el banco","Notas de Crédito, eliminados, cancelados","Ingresos gastos extranjeros","Rendimiento","Ingresos en MXN, facturado en USD"];
       function getIndex(x) {
         return arrayOrder.indexOf(x.descripcion);
       }

       return (getIndex(a) - getIndex(b)) ;
     });
    // console.log(sortedData);
      table_validaciones(sortedData, $('#table_validaciones'));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function table_validaciones(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_banks_validaciones);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.descripcion,
      status.depositoMXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.retiroMXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.depositoUSD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.retiroUSD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.sumaDepositosMXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      status.sumaRetirosMXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    ]);
  });
}

function table_cxc_vencidas(){
  var _token = $('meta[name="csrf-token"]').attr('content');
  var datanow = $('#date_to_search').val();
  var year=$('#year_to_search').val();
  $.ajax({
    type: "POST",
    url: "/get_cxc_vencidas_306090",
    data: { _token : _token },
    success: function (data){
    //  console.log(data);
      table_vencidas(data, $('#table_cxc_vencidas'));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function table_vencidas(datajson,table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_cxc_vencidas);
  var total_MXN;
  var total_USD;
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.cadena+'/'+status.key,
      parseInt(status._30_dias_MXN).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      parseInt(status._60_dias_MXN).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      parseInt(status._90_dias_MXN).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      parseInt(status._30_dias_USD).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      parseInt(status._60_dias_USD).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      parseInt(status._90_dias_USD).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      total_MXN=parseInt(status._30_dias_MXN+status._60_dias_MXN+status._90_dias_MXN).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      total_USD=parseInt(status._30_dias_USD+status._60_dias_USD+status._90_dias_USD).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      statuscolor(status._30_dias_MXN,status._30_dias_USD,status._60_dias_MXN,status._60_dias_USD,status._90_dias_MXN,status._90_dias_USD,status.sin_fecha),
      formatcomment(status.comentario,status.key,status.cadena_id)
    ]);
  });
}

function statuscolor(_30mxn,_30usd,_60mxn,_60usd,_90mxn,_90usd,montosinfecha){
  if((parseInt(_30mxn)!='0' || parseInt(_30usd)!='0') && (parseInt(_60mxn)=='0' && parseInt(_60usd)=='0') && (parseInt(_90mxn)=='0' && parseInt(_90usd)=='0') ){

  return '<svg height="40" width="40"><circle cx="20" cy="20" r="12" stroke="black" stroke-width="1" fill="orange" /></svg>'
  }

    else if(parseInt(montosinfecha)!='0') {
    return '<span class="badge badge-primary" style="margin:0;padding:5px;">Sin fecha</span><br>'+parseInt(montosinfecha).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+''
    }
       else {
         return '<svg height="40" width="40"><circle cx="20" cy="20" r="12" stroke="black" stroke-width="1" fill="red" /></svg>'
            }
}


function formatcomment(comentario,key,cadena_id){
  if(comentario==null) {
  return 'Sin comentarios'+'<a  onclick= enviarKeyContrato("'+key+'","'+cadena_id+'") class="btn btn-primary btn-xs" role="button" data-toggle="modal" data-target="#modal-view-comment" title="Ver" width="20%"><i class=" text-white far fa-edit"></i></a>';
  }
  else{
    //console.log(comentario.toString().split('\n'));
  var lastcomment=(comentario.toString().split('\n').pop());



  return lastcomment +
  '<a  onclick= enviarKeyContrato("'+key+'","'+cadena_id+'") class="btn btn-primary btn-xs" role="button" data-toggle="modal" data-target="#modal-view-comment" title="Ver" width="20%"><i class=" text-white far fa-edit"></i></a>';
  }
}

function enviarKeyContrato(key,cadena_id){
  //console.log(key);
  $('#clave_contrato').text(key);
  //console.log(cadena_id);
  $('#cadena_id').val(cadena_id);
  $.ajax({
    type: "POST",
    url: "/get_contract_comment",
    data: { _token : _token,key:key},
    success: function (data){
      //$('#history_comment').val(data[0]['comment']);
      var comentario=data[0]['comment'];
     //console.log(data[0]['comment']);
      //$('#history_comment').text(comentario);
      $('#history_comment').html(comentario);
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

$('#save_comment').on('click',function(){
var cadena_id =$('#cadena_id').val();
var key =  $('#clave_contrato').text();
var oldcomment= $('#history_comment').val();
var newcomment = $('#newcomment').val();
//console.log(newcomment);
if(newcomment==''){
  $('#modal-view-comment').modal('hide');
  swal("Operación abortada!", "Ningun cambio realizado. :(", "error");
}
else{
$.ajax({
  type: "POST",
  url: "/save_comment_by_contract",
  data: { _token : _token,cadena_id:cadena_id,key:key,oldcomment,newcomment },
  success: function (data){
    //console.log('Insertado');
    $('#newcomment').val(" ");
    $('#modal-view-comment').modal('hide');
    swal("Agregado correctamente", "", "success");
    table_cxc_vencidas();
    /*
    setTimeout(function(){
      location.reload();
    }, 3000);*/
  },
  error: function (data) {
    console.log('Error:', data);
  }
});
}

});

var Configuration_table_banks = {
  "order": [[ 0, "asc" ]],
  paging: false,
  //"pagingType": "simple",
  Filter: false,
  searching: false,
  ordering: false,
  "select": false,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  // "columnDefs": [
  //     {
  //       "targets": 0,
  //       "width": "1%",
  //     },
  // ],
  // "select": {
  //     'style': 'multi',
  // },
  //ordering: false,
  //"pageLength": 5,
  dom: "<'row'<'col-sm-2'l><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",

  bInfo: false,
  "createdRow": function ( row, data, index ) {
    //console.log("imprimiendo:");
    //console.log(data);
   if (parseInt(data[1]) < 0) {
       $('td', row).eq(1).addClass('negative');
       $('td', row).eq(1).addClass('negativeleft');
       $('td', row).eq(1).addClass('negativeright');
   }
   if (parseInt(data[2]) < 0) {
       $('td', row).eq(2).addClass('negative');
       $('td', row).eq(2).addClass('negativeleft');
       $('td', row).eq(2).addClass('negativeright');
   }
   if (parseInt(data[3]) < 0) {
       $('td', row).eq(3).addClass('negative');
       $('td', row).eq(3).addClass('negativeleft');
       $('td', row).eq(3).addClass('negativeright');
   }
   if (parseInt(data[4]) < 0) {
       $('td', row).eq(4).addClass('negative');
       $('td', row).eq(4).addClass('negativeleft');
       $('td', row).eq(4).addClass('negativeright');
   }
   if (parseInt(data[5]) < 0) {
       $('td', row).eq(5).addClass('negative');
       $('td', row).eq(5).addClass('negativeleft');
       $('td', row).eq(5).addClass('negativeright');
   }
   if (parseInt(data[6]) < 0) {
       $('td', row).eq(6).addClass('negative');
       $('td', row).eq(6).addClass('negativeleft');
       $('td', row).eq(6).addClass('negativeright');
   }
   if (parseInt(data[7]) < 0) {
       $('td', row).eq(7).addClass('negative');
       $('td', row).eq(7).addClass('negativeleft');
       $('td', row).eq(7).addClass('negativeright');
   }
   if (parseInt(data[8]) < 0) {
       $('td', row).eq(8).addClass('negative');
       $('td', row).eq(8).addClass('negativeleft');
       $('td', row).eq(8).addClass('negativeright');
   }
},
  "footerCallback": function(row, data, start, end, display){
    var api = this.api(), data;
    var suma = 0;
    // var colCount = 13;
    var colCountDyn = 0;
    var colCount = api.columns().header().length;
    // console.log('Columnas: ' + colCount);
    // Remove the formatting to get integer data for summation
    var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
    };

            api.columns('.sum_col').every( function () {
              var sum = this
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var total  = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

               if(parseInt(total) < 0) this.footer().innerHTML = "<span class='negative'>("+total+")</span>"

               else this.footer().innerHTML = total;
            } );

      // total = api
      //     .column( 1 )
      //     .data()
      //     .reduce( function (a, b) {
      //         return intVal(a) + intVal(b);
      //     }, 0 );

      // $( api.column( 1 ).footer() ).html(
      //     '$'+total
      // );
  },
  language:{
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "<i class='fa fa-search'></i> Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  }
}
var Configuration_table_banks_validaciones = {
  "order": [[ 0, "asc" ]],
  paging: false,
  //"pagingType": "simple",
  Filter: false,
  searching: false,
  ordering: false,
  "select": false,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
      {
        "targets": 0,
        "width": "4%",
      },
      {
        "targets": 1,
        "width": "1%",
      },
      {
        "targets": 2,
        "width": "1%",
      },
      {
        "targets": 3,
        "width": "1%",
      },
      {
        "targets": 4,
        "width": "1%",
      },
      {
        "targets": 5,
        "width": "1%",
      },
      {
        "targets": 6,
        "width": "1%",
      },

  ],
  // "select": {
  //     'style': 'multi',
  // },
  //ordering: false,
  //"pageLength": 5,
  dom: "<'row'<'col-sm-2'l><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",

  bInfo: false,
  "createdRow": function ( row, data, index ) {
   if (parseInt(data[1]) < 0) {
       $('td', row).eq(1).addClass('negative');
       $('td', row).eq(1).addClass('negativeleft');
       $('td', row).eq(1).addClass('negativeright');
   }
   if (parseInt(data[2]) < 0) {
       $('td', row).eq(2).addClass('negative');
       $('td', row).eq(2).addClass('negativeleft');
       $('td', row).eq(2).addClass('negativeright');
   }
   if (parseInt(data[3]) < 0 ) {
       $('td', row).eq(3).addClass('negative');
       $('td', row).eq(3).addClass('negativeleft');
       $('td', row).eq(3).addClass('negativeright');
   }
   if (parseInt(data[4]) < 0) {
       $('td', row).eq(4).addClass('negative');
       $('td', row).eq(4).addClass('negativeleft');
       $('td', row).eq(4).addClass('negativeright');
   }
   if (parseInt(data[5]) < 0) {
       $('td', row).eq(5).addClass('negative');
       $('td', row).eq(5).addClass('negativeleft');
       $('td', row).eq(5).addClass('negativeright');
   }
   if (parseInt(data[6]) < 0) {
       $('td', row).eq(6).addClass('negative');
       $('td', row).eq(6).addClass('negativeleft');
       $('td', row).eq(6).addClass('negativeright');
   }
   if (parseInt(data[7]) < 0) {
       $('td', row).eq(7).addClass('negative');
       $('td', row).eq(7).addClass('negativeleft');
       $('td', row).eq(7).addClass('negativeright');
   }
},
  "footerCallback": function(row, data, start, end, display){
    var api = this.api(), data;
    var suma = 0;
    // var colCount = 13;
    var colCountDyn = 0;
    var colCount = api.columns().header().length;
    // console.log('Columnas: ' + colCount);
    // Remove the formatting to get integer data for summation
    var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
    };

            api.columns('.sum_col').every( function () {
              var sum = this
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var total  = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

               if(parseInt(total) < 0) this.footer().innerHTML = "<span class='negative'>("+total+")</span>"

               else this.footer().innerHTML = total;
            } );

      // total = api
      //     .column( 1 )
      //     .data()
      //     .reduce( function (a, b) {
      //         return intVal(a) + intVal(b);
      //     }, 0 );

      // $( api.column( 1 ).footer() ).html(
      //     '$'+total
      // );
  },
  language:{
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "<i class='fa fa-search'></i> Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  }
}

var Configuration_table_cxc_vencidas = {
  "order": [[ 0, "asc" ]],
  paging: true,
  //"pagingType": "simple",
  Filter: false,
  searching: true,
  ordering: true,
  "select": false,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
      {
          "targets": 0,
          "width": "0.5%",
          "className": "text-center",
      },
      {
        "targets": 1,
        "width": "1%",
        "className": "text-center",
      },
      {
        "targets": 2,
        "width": "1%",
        "className": "text-center",
      },
      {
        "targets": 3,
        "width": "0.5%",
        "className": "text-center",
      },
      {
        "targets": 4,
        "width": "1%",
        "className": "text-center",
      },
      {
        "targets": 5,
        "width": "1%",
        "className": "text-center",
      },
      {
        "targets": 6,
        "width": "0.5%",
        "className": "text-center",
      },
      {
        "targets": 7,
        "width": "0.5%",
        "className": "text-center",
      },
      {
        "targets": 8,
        "width": "0.5%",
        "className": "text-center",
      },
      {
        "targets": 9,
        "width": "0.5%",
        "className": "text-center",
      },
      {
        "targets": 10,
        "width": "0.5%",
        "className": "text-center",
      }
  ],
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  buttons: [
                  {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    titleAttr: 'Excel',
                    title: function ( e, dt, node, config ) {
                      var ax = Date.now();
                      return 'Atrasos'+ax;
                    },
                    init: function(api, node, config) {
                       $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                        columns: [ 0,1,2,3,4,5,6,7,8,9,10 ],
                        modifier: {
                            page: 'all',
                        }
                    },
                    className: 'btn btn-success',
                  }
  ],

  bInfo: false,
  "footerCallback": function(row, data, start, end, display){
    var api = this.api(), data;
    var suma = 0;
    // var colCount = 13;
    var colCountDyn = 0;
    var colCount = api.columns().header().length;
    // console.log('Columnas: ' + colCount);
    // Remove the formatting to get integer data for summation
    var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
    };

            api.columns('.sum_col').every( function () {
              var sum = this
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var total  = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

               if(parseInt(total) < 0) this.footer().innerHTML = "<span class='negative'>("+total+")</span>"

               else this.footer().innerHTML = total;
            } );
},
  language:{
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "<i class='fa fa-search'></i> Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  }
}
