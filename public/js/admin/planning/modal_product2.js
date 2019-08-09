$(document).ready( function() {
  $('#creatproductsystem').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputCreatkey: {
        validators: {
          notEmpty: {
            message: 'The key is required'
          },
          stringLength: {
            min: 2,
            max: 150,
          }
        }
      },
      inputCreatpart: {
        validators: {
          notEmpty: {
            message: 'The part number is required'
          },
          stringLength: {
            min: 1,
            max: 150,
          }
        }
      },
      inputCreatname: {
        validators: {
          notEmpty: {
            message: 'The product name is required'
          },
          stringLength: {
            min: 3,
            max: 150,
          }
        }
      },
      inputCreatcoindefault: {
        validators: {
          notEmpty: {
            message: 'The default price is required'
          },
          stringLength: {
            min: 2,
            max: 150,
          }
        }
      },
      sel_modal_coin: {
        validators: {
          notEmpty: {
            message: 'The default price is required'
          }
        }
      },
      sel_modal_proveedor: {
        validators: {
          notEmpty: {
            message: 'The default price is required'
          }
        }
      },
      sel_categoria: {
        validators: {
          notEmpty: {
            message: 'The default price is required'
          }
        }
      },
      sel_modelo: {
        validators: {
          notEmpty: {
            message: 'The default price is required'
          }
        }
      },


      sel_estatus: {
        validators: {
          notEmpty: {
            message: 'The default price is required'
          }
        }
      },




    }
  })
  .on('success.form.fv', function(e) {
    e.preventDefault();
    /* --------------------------------------------------------------------- */
    /* --------------------------------------------------------------------- */
  });
});
