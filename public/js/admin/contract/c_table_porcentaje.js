//Table 1
$(document).on("blur", "#item_contact tbody .col-porcentaje", function () {
  var id= $(this).attr('id');
  totalPorcentajeItem_contacto(id);
});
function totalPorcentajeItem_contacto(datox) {
  $.ajax({
      url: "/totalLinesContact",
      type: "POST",
      dataType: "JSON",
      data: $("#validation_anexo").serialize(),
      success: function (data) {
          if (data) {
            if (data.respuesta == false) {
              $('#'+datox).val('');
              $("#item_contact_note").text('Error: No puede ser mayor a '+data.total+ ', falta '+data.falta);
            }
            else{
              $("#item_contact_note").html('');
            }
          }
      },
      error: function (error, textStatus, errorThrown) {
          if (error.status == 422) {
              var message = error.responseJSON.error;
              Swal.fire("Operación abortada", message, "error");
          } else {
              alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
          }
      }
  });
};
//Table 2
$(document).on("blur", "#item_cierre tbody .col-cierre-porcentaje", function () {
  var id= $(this).attr('id');
  totalPorcentajeItem_cierre(id);
});
function totalPorcentajeItem_cierre(datox) {
  $.ajax({
      url: "/totalLinesCierre",
      type: "POST",
      dataType: "JSON",
      data: $("#validation_anexo").serialize(),
      success: function (data) {
          if (data) {
            if (data.respuesta == false) {
              $('#'+datox).val('');
              $("#item_cierre_note").text('Error: No puede ser mayor a '+data.total+ ', falta '+data.falta);
            }
            else{
              $("#item_cierre_note").html('');
            }
          }
      },
      error: function (error, textStatus, errorThrown) {
          if (error.status == 422) {
              var message = error.responseJSON.error;
              Swal.fire("Operación abortada", message, "error");
          } else {
              alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
          }
      }
  });
};
//Table 3
$(document).on("blur", "#item_vendedor tbody .col-vendedor-porcentaje", function () {
  var id= $(this).attr('id');
  totalPorcentajeItem_vendedor(id);
});
function totalPorcentajeItem_vendedor(datox) {
  $.ajax({
      url: "/totalLinesVendedor",
      type: "POST",
      dataType: "JSON",
      data: $("#validation_anexo").serialize(),
      success: function (data) {
          if (data) {
            if (data.respuesta == false) {
              $('#'+datox).val('');
              $("#item_vendedor_note").text('Error: No puede ser mayor a '+data.total+ ', falta '+data.falta);
            }
            else{
              $("#item_vendedor_note").html('');
            }
          }
      },
      error: function (error, textStatus, errorThrown) {
          if (error.status == 422) {
              var message = error.responseJSON.error;
              Swal.fire("Operación abortada", message, "error");
          } else {
              alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
          }
      }
  });
};
//Table 4
$(document).on("blur", "#item_colaborador tbody .col-colaborador-porcentaje", function () {
  var id= $(this).attr('id');
  totalPorcentajeItem_colaborador(id);
});
function totalPorcentajeItem_colaborador(datox) {
  $.ajax({
      url: "/totalLinesColaborador",
      type: "POST",
      dataType: "JSON",
      data: $("#validation_anexo").serialize(),
      success: function (data) {
          if (data) {
            if (data.respuesta == false) {
              $('#'+datox).val('');
              $("#item_colaborador_note").text('Error: No puede ser mayor a '+data.total+ ', falta '+data.falta);
            }
            else{
              $("#item_colaborador_note").html('');
            }
          }
      },
      error: function (error, textStatus, errorThrown) {
          if (error.status == 422) {
              var message = error.responseJSON.error;
              Swal.fire("Operación abortada", message, "error");
          } else {
              alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
          }
      }
  });
};


function delete_row_table_a(){
  var rowCount = $("#item_contact > tbody").children().length;
  var fila = 2;
  $("#item_contact tr").slice(2, rowCount).remove();
  // console.log(rowCount);
}
function delete_row_table_b(){
  var rowCount = $("#item_cierre > tbody").children().length;
  var fila = 2;
  $("#item_cierre tr").slice(2, rowCount).remove();
  // console.log(rowCount);
}
function delete_row_table_c(){
  var rowCount = $("#item_vendedor > tbody").children().length;
  var fila = 2;
  $("#item_vendedor tr").slice(2, rowCount).remove();
  // console.log(rowCount);
}
function delete_row_table_d(){
  var rowCount = $("#item_colaborador > tbody").children().length;
  var fila = 2;
  $("#item_colaborador tr").slice(2, rowCount).remove();
  // console.log(rowCount);
}
