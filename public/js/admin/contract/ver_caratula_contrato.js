$(function() {
    get_info();

    $("#editar").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        errorPlacement: function(error, element) {
            var attr = $('[name="' + element[0].name + '"]').attr('datas');
            if (element[0].id === 'fileInput') {
                error.insertAfter($('#cont_file'));
            } else {
                if (attr == 'sel_estatus') {
                    error.insertAfter($('#cont_estatus'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        rules: {
            InputTelefonoContacto: {
                required: true,
                number: true,
                minlength: 8,
                maxlength: 10
            }
        },
        messages: {},
        // debug: true,
        // errorElement: "label",
        submitHandler: function(form, event) {
          event.preventDefault();
          var form = $('#editar')[0];
          var formData = new FormData(form);
          $.ajax({
            type: "POST",
            url: "/save_edition_caratula_contrato",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              if (data == 'abort') {
                Swal.fire({
                  type: 'error',
                  title: 'Error encontrado..',
                  text: 'Realice la operacion nuevamente!',
                });
              }
              else {
                let timerInterval;
                Swal.fire({
                  type: 'success',
                  title: 'Operación Completada!',
                  html: 'Aplicando los cambios.',
                  timer: 2500,
                  onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                      Swal.getContent().querySelector('strong')
                    }, 100)
                  },
                  onClose: () => {
                    clearInterval(timerInterval)
                  }
                }).then((result) => {
                  if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.timer
                  ) {
                    window.location.href = "/ver_caratula_contrato";
                  }
                });
              }
            },
            error: function (err) {
              Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: err.statusText,
                });
            }
          });
        }
    });

});

function get_info() {
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/search_caratula_contrato",
        data: {
            _token: _token
        },
        success: function(data) {
            table_caratula(data, $("#table_caratula"));
        },
        error: function(data) {
            console.log('Error:', data.statusText);
        }
    });
}

function table_caratula(datajson, table) {
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table);
    vartable.fnClearTable();
    $.each(JSON.parse(datajson), function(index, information) {
        var a01 = '<div class="btn-group">';
        var a02 = '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>';
        var a03 = '<div class="dropdown-menu">';
        var a04 = '<a class="dropdown-item" href="javascript:void(0);" onclick="caratula_edit(this)" value="' + information.id + '" datas="' + information.id + '"><i class="fas fa-pencil-alt"></i> Editar</a>';
        var a05 = '<a class="dropdown-item" href="javascript:void(0);" onclick="caratula_delete(this)" value="' + information.id + '" datas="' + information.id + '"><i class="fas fa-trash"></i> Eliminar</a>';
        var a06 = '<a class="dropdown-item" href="javascript:void(0);" onclick="caratula_download(this)"  value="' + information.id + '" datas="' + information.id + '"><i class="fas fa-download"></i> Descargar</a>';
        var a07 = '</div>';
        var a08 = '</div>';
        var dropdown = a01 + a02 + a03 + a04 + a05 + a06 + a07 + a08;
        vartable.fnAddData([
            (index + 1),
            information.rfc,
            information.razon_social,
            information.telefono_contacto,
            information.tipo_servicio,
            information.created_at,
            dropdown
        ]);
    });
}
var Configuration_table = {
    "order": [
        [0, "asc"]
    ],
    paging: true,
    searching: true,
    Filter: true,
    "aLengthMenu": [
        [5, 10, 25, -1],
        [5, 10, 25, "Todos"]
    ],
    "processing": true,
    dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [{
            extend: 'excelHtml5',
            title: 'Caratulas de contratos',
            init: function(api, node, config) {
                $(node).removeClass('btn-secondary')
            },
            text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
            titleAttr: 'Excel',
            className: 'btn btn-success btn-sm',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5]
            },
        },
        {
            extend: 'csvHtml5',
            title: 'Caratulas de contratos',
            init: function(api, node, config) {
                $(node).removeClass('btn-secondary')
            },
            text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
            titleAttr: 'CSV',
            className: 'btn btn-primary btn-sm',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5]
            },
        }
    ],
    language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "<i class='fa fa-search'></i> Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
};

$('#InputAplicaGarantia').on('change', function() {
    var valor = $(this).val();
    $('#InputMontoGarantia').val('');
    if (valor == 0) {
        $('#InputMontoGarantia').prop('readonly', true); // console.log(0);
        $("#InputMontoGarantia").prop('required', false);
    } else {
        $('#InputMontoGarantia').prop('readonly', false); // console.log(1);
        $("#InputMontoGarantia").prop('required', true);
    }
});
function caratula_edit(e) {
    var valor = e.getAttribute('value');
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: '/editar_caratula_contrato',
        data: {
            token_b: valor,
            _token: _token
        },
        success: function(data) {
            if (data != []) {
                $('#token_b').val(data[0].id);

                $('#InputRazonSocial').val(data[0].razon_social);
                $('#InputRepresentante').val(data[0].representante);
                $('#InputTelefonoContacto').val(data[0].telefono_contacto);

                $('#InputEmailCobranza').val(data[0].correo_contacto_cobranza);
                $('#InputEmailComercial').val(data[0].correo_contacto_comercial);
                $('#InputEmailLegal').val(data[0].correo_contacto_legal);

                $('#InputRfc').val(data[0].rfc);
                $('#InputCfdi').val(data[0].cfdi);
                $('#InputDireccion').val(data[0].direccion);
                $('#InputMetodoPago').val(data[0].metodo_pago);

                $('#InputDireccionPersona').val(data[0].direccion_persona);
                $('#InputEmailCliente').val(data[0].correo_cliente);
                $('#InputAtencionPersona').val(data[0].atencion_persona);

                $('#InputTipoServ').val(data[0].tipo_servicio);
                $('#InputVigencia').val(data[0].vigencia);

                $('#InputMontoPago').val(data[0].monto_pago);
                $('#InputMonedaPago').val(data[0].moneda_pago).trigger('change');
                $('#InputDosUltMeses').val(data[0].pago_ultms_meses).trigger('change');

                $('#InputAplicaGarantia').val(data[0].aplica_garantia).trigger('change');
                if (data[0].aplica_garantia == 0) {
                  $('#InputMontoGarantia').prop('readonly', true); // console.log(0);
                  $("#InputMontoGarantia").prop('required',true);
                } else {
                  $('#InputMontoGarantia').prop('readonly', false); // console.log(1);
                  $("#InputMontoGarantia").prop('required',false);
                }
                $('#InputMontoGarantia').val(data[0].monto_garantia);

                $('#textareaCondicionesEspeciales').text(data[0].condiciones_especiales);
                $('#textareaObservaciones').text(data[0].observaciones);
                $('#modal-Edit').modal('show');
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Error encontrado..',
                    text: 'Realice la operacion nuevamente!',
                });
            }
        },
        error: function(data) {
            alert('Error:', data);
        }
    })
}

function caratula_delete(e) {
    var valor = e.getAttribute('value');
    var _token = $('meta[name="csrf-token"]').attr('content');
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podras revertir este cambio",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: '/delete_caratula_contrato',
                data: {
                    token_d: valor,
                    _token: _token
                },
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire('Registro eliminado!', '', 'success')
                            .then(() => {
                                location.href = "/ver_caratula_contrato";
                            });
                    }
                },
                error: function(err) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: err.statusText,
                    });
                }
            })
        }
    })
}

function caratula_download(e) {
  var valor = e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $('#token_ab').val(valor);
  $('#pdf')[0].submit();
}

function mayuscula(e) {
    e.value = e.value.toUpperCase();
}

function redondeo_monto() {
    var token = $('input[name="_token"]').val();
    var valor = $('#InputMontoPago').val();
    if (valor) {
        $.ajax({
            type: "POST",
            url: "/monto_caratula_contrato",
            data: {
                _token: token,
                valorInput: valor
            },
            success: function(data) {
                $('#InputMontoPago').val(data.text);
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    }
}

function redondeo_garantia() {
    var token = $('input[name="_token"]').val();
    var valor = $('#InputMontoGarantia').val();
    if (valor) {
        $.ajax({
            type: "POST",
            url: "/monto_caratula_contrato",
            data: {
                _token: token,
                valorInput: valor
            },
            success: function(data) {
                $('#InputMontoGarantia').val(data.text);
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    }
}
