
<h6 class="text-dark">Aprobado por:</h6>
<input id="id" name="id" type="hidden" value="{{$documentp[0]->id}}">
<input id="cotizador_status" name="cotizador_status" type="hidden" value="{{$documentp[0]->cotizador_status_id}}">
@if($check_approvals[0]->aprobado_direccion == 0)
    <!-----------ADMINISTRACION-------------------->
    @if(auth()->user()->can('Aprobacion administracion') && $aprovals_propuesta->administracion == 1)
        <div class="custom-control custom-checkbox">
            <input checked disabled type="checkbox" class="custom-control-input" id="check_administracion">
            <label class="custom-control-label" for="check_administracion">María  de Jesús Ortíz</label>
        </div>
    @elseif(auth()->user()->can('Aprobacion administracion') && $aprovals_propuesta->administracion == 0)
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="check_administracion">
            <label class="custom-control-label" for="check_administracion">María  de Jesús Ortíz</label>
        </div>
    @elseif($aprovals_propuesta->administracion == 1)
        <div class="custom-control custom-checkbox">
            <input disabled checked type="checkbox" class="custom-control-input" id="check_administracion">
            <label class="custom-control-label" for="check_administracion">  María  de Jesús Ortíz</label>
        </div>
    @elseif($aprovals_propuesta->administracion == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_administracion">
            <label class="custom-control-label" for="check_administracion">  María  de Jesús Ortíz</label>
        </div>
    @endif
    <!-----------DIRECTOR COMERCIAL-------------------->    
    @if(auth()->user()->can('Aprobacion director comercial') && $aprovals_propuesta->director_comercial == 1)
        <div class="custom-control custom-checkbox">
            <input checked disabled type="checkbox" class="custom-control-input" id="check_comercial">
            <label class="custom-control-label" for="check_comercial"> John Walker</label>
        </div>
    @elseif(auth()->user()->can('Aprobacion director comercial') && $aprovals_propuesta->director_comercial == 0)
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="check_comercial">
            <label class="custom-control-label" for="check_comercial"> John Walker</label>
        </div>        
    @elseif($aprovals_propuesta->director_comercial == 1)
        <div class="custom-control custom-checkbox">
            <input disabled checked type="checkbox" class="custom-control-input" id="check_comercial">
            <label class="custom-control-label" for="check_comercial">  John Walker</label>
        </div>
    @elseif($aprovals_propuesta->director_comercial == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_comercial">
            <label class="custom-control-label" for="check_comercial">  John Walker</label>
        </div>
    @endif
    <!-----------DIRECTOR OPERACIONES-------------------->  
    @if(auth()->user()->can('Aprobacion director operaciones') && $aprovals_propuesta->director_operaciones == 1)
        <div class="custom-control custom-checkbox">
            <input checked disabled type="checkbox" class="custom-control-input" id="check_director_operaciones">
            <label class="custom-control-label" for="check_director_operaciones">  René González</label>
        </div>
    @elseif(auth()->user()->can('Aprobacion director operaciones') && $aprovals_propuesta->director_operaciones == 0)
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="check_director_operaciones">
            <label class="custom-control-label" for="check_director_operaciones">  René González</label>
        </div>        
    @elseif($aprovals_propuesta->director_operaciones == 1)
        <div class="custom-control custom-checkbox">
            <input disabled checked type="checkbox" class="custom-control-input" id="check_director_operaciones">
            <label class="custom-control-label" for="check_director_operaciones">  René González</label>
        </div>
    @elseif($aprovals_propuesta->director_operaciones == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_director_operaciones">
            <label class="custom-control-label" for="check_director_operaciones">  René González</label>
        </div>
    @endif
    <!-----------DIRECTOR GENERAL-------------------->  
    @if(auth()->user()->can('Aprobacion director general') && $aprovals_propuesta->director_general == 1)
        <div class="custom-control custom-checkbox">
            <input checked disabled type="checkbox" class="custom-control-input" id="check_director_general">
            <label class="custom-control-label" for="check_director_general">  Alejandro Espejo</label>
        </div>
    @elseif(auth()->user()->can('Aprobacion director general') && $aprovals_propuesta->director_general == 0)
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="check_director_general">
            <label class="custom-control-label" for="check_director_general">  Alejandro Espejo</label>
        </div>        
    @elseif($aprovals_propuesta->director_general == 1)
        <div class="custom-control custom-checkbox">
            <input disabled checked type="checkbox" class="custom-control-input" id="check_director_general">
            <label class="custom-control-label" for="check_director_general">  Alejandro Espejo</label>
        </div>
    @elseif($aprovals_propuesta->director_general == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_director_general">
            <label class="custom-control-label" for="check_director_general">  Alejandro Espejo</label>
        </div>
    @endif
           
@else
<!---EL proyecto ya esta aprobado por 2 directivos, se bloquean todos los checkbox --->

    <!-----------ADMINISTRACION-------------------->
    @if(auth()->user()->can('Aprobacion administracion') && $aprovals_propuesta->administracion == 1)
        <div class="custom-control custom-checkbox">
            <input checked disabled type="checkbox" class="custom-control-input" id="check_administracion">
            <label class="custom-control-label" for="check_administracion">María  de Jesús Ortíz</label>
        </div>
    @elseif(auth()->user()->can('Aprobacion administracion') && $aprovals_propuesta->administracion == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_administracion">
            <label class="custom-control-label" for="check_administracion">María  de Jesús Ortíz</label>
        </div>
    @elseif($aprovals_propuesta->administracion == 1)
        <div class="custom-control custom-checkbox">
            <input disabled checked type="checkbox" class="custom-control-input" id="check_administracion">
            <label class="custom-control-label" for="check_administracion">  María  de Jesús Ortíz</label>
        </div>
    @elseif($aprovals_propuesta->administracion == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_administracion">
            <label class="custom-control-label" for="check_administracion">  María  de Jesús Ortíz</label>
        </div>
    @endif
    <!-----------DIRECTOR COMERCIAL-------------------->    
    @if(auth()->user()->can('Aprobacion director comercial') && $aprovals_propuesta->director_comercial == 1)
        <div class="custom-control custom-checkbox">
            <input checked disabled type="checkbox" class="custom-control-input" id="check_comercial">
            <label class="custom-control-label" for="check_comercial"> John Walker</label>
        </div>
    @elseif(auth()->user()->can('Aprobacion director comercial') && $aprovals_propuesta->director_comercial == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_comercial">
            <label class="custom-control-label" for="check_comercial"> John Walker</label>
        </div>        
    @elseif($aprovals_propuesta->director_comercial == 1)
        <div class="custom-control custom-checkbox">
            <input disabled checked type="checkbox" class="custom-control-input" id="check_comercial">
            <label class="custom-control-label" for="check_comercial">  John Walker</label>
        </div>
    @elseif($aprovals_propuesta->director_comercial == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_comercial">
            <label class="custom-control-label" for="check_comercial">  John Walker</label>
        </div>
    @endif
    <!-----------DIRECTOR OPERACIONES-------------------->  
    @if(auth()->user()->can('Aprobacion director operaciones') && $aprovals_propuesta->director_operaciones == 1)
        <div class="custom-control custom-checkbox">
            <input checked disabled type="checkbox" class="custom-control-input" id="check_director_operaciones">
            <label class="custom-control-label" for="check_director_operaciones">  René González</label>
        </div>
    @elseif(auth()->user()->can('Aprobacion director operaciones') && $aprovals_propuesta->director_operaciones == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_director_operaciones">
            <label class="custom-control-label" for="check_director_operaciones">  René González</label>
        </div>        
    @elseif($aprovals_propuesta->director_operaciones == 1)
        <div class="custom-control custom-checkbox">
            <input disabled checked type="checkbox" class="custom-control-input" id="check_director_operaciones">
            <label class="custom-control-label" for="check_director_operaciones">  René González</label>
        </div>
    @elseif($aprovals_propuesta->director_operaciones == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_director_operaciones">
            <label class="custom-control-label" for="check_director_operaciones">  René González</label>
        </div>
    @endif
    <!-----------DIRECTOR GENERAL-------------------->  
    @if(auth()->user()->can('Aprobacion director general') && $aprovals_propuesta->director_general == 1)
        <div class="custom-control custom-checkbox">
            <input checked disabled type="checkbox" class="custom-control-input" id="check_director_general">
            <label class="custom-control-label" for="check_director_general">  Alejandro Espejo</label>
        </div>
    @elseif(auth()->user()->can('Aprobacion director general') && $aprovals_propuesta->director_general == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_director_general">
            <label class="custom-control-label" for="check_director_general">  Alejandro Espejo</label>
        </div>        
    @elseif($aprovals_propuesta->director_general == 1)
        <div class="custom-control custom-checkbox">
            <input disabled checked type="checkbox" class="custom-control-input" id="check_director_general">
            <label class="custom-control-label" for="check_director_general">  Alejandro Espejo</label>
        </div>
    @elseif($aprovals_propuesta->director_general == 0)
        <div class="custom-control custom-checkbox">
            <input disabled type="checkbox" class="custom-control-input" id="check_director_general">
            <label class="custom-control-label" for="check_director_general">  Alejandro Espejo</label>
        </div>
    @endif
@endif

<script>

(function() {
    //Si el cotizador ya esta autorizado desactivo todos los checkboxes 
    let cotizador = document.getElementById('cotizador_status').value;
    if(cotizador == 4){
        var input_checks = document.getElementsByClassName('custom-control-input');
        Array.from(input_checks).forEach(function (element) {
            $flag = false;
            element.disabled = true;
        });
    }
})();
    
    var check_administracion = document.getElementById("check_administracion");
    var check_comercial = document.getElementById("check_comercial");
    var check_director_operaciones = document.getElementById("check_director_operaciones");
    var check_director_general = document.getElementById("check_director_general");

    //EVENT LISTENERS CHECKBOX APPROVALS
    check_administracion.addEventListener('click', (e) => {
        approval_propuesta(e);
    });
    check_comercial.addEventListener('click', (e) => {
        approval_propuesta(e);
    });
    check_director_operaciones.addEventListener('click', (e) => {
        approval_propuesta(e);
    });
    check_director_general.addEventListener('click', (e) => {
        approval_propuesta(e);
    });

function approval_propuesta(e){
    e.preventDefault();
    e.stopPropagation();

    var _token = $('input[name="_token"]').val();
    var id = document.getElementById('id').value;

    let administracion = (document.getElementById("check_administracion").checked ? 1 : 0);
    let director_comercial = (document.getElementById("check_comercial").checked ? 1 : 0);
    let director_operaciones = (document.getElementById("check_director_operaciones").checked ? 1 : 0);
    let director_general = (document.getElementById("check_director_general").checked ? 1 : 0);

    let data = {
        id,
        administracion,
        director_comercial,
        director_operaciones,
        director_general
    }

    console.log(data);

    const headers = new Headers({
        "Accept": "application/json",
        'Content-Type': 'application/json',
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": _token
    })

    var miInit= {
        method: 'post',
        headers: headers,
        body: JSON.stringify(data),
        credentials: "same-origin",
        cache: 'default' };

            Swal.fire({
            title: "Confirmar aprobacion de cotizador",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {

               return fetch(`/approval_directives_propuesta_comercial`, miInit)
                         .then(function(response){
                           if (!response.ok) {
                              throw new Error(response.statusText)
                            }
                           return response.json();
                         })
                         .catch(function(error){
                           Swal.showValidationMessage(
                             `Request failed: ${error}`
                           )
                         });
            }//Preconfirm
        }).then((result) => {
            console.log(result.value)
            if(result.value.status){
            
            Swal.fire({title: 'Autorizado',text: "", type: 'success'})
                .then(function (result) {
                    if (result.value) {
                        location.reload();
                    }
                })
            }
        })
        
    }
</script>
