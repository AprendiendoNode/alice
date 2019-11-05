@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View drive') )
    <strong>Dashboard Clientes</strong>
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View drive') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View drive') )
    Clientes
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View drive') )

      <div class="input-group mb-3">
        <label class="mr-1">Sitio:</label>
        <select id="cliente" class="form-control select2">
          <option value="" selected> Elija uno... </option>
          @forelse ($hotels as $hotel)
            <option value="{{ $hotel->id }}"> {{ $hotel->Nombre_hotel }} </option>
          @empty
          @endforelse
        </select>
      </div>
      <!--<div id="sabana" class="container card d-none">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#informacion"><i class="fas fa-user-circle"></i> Información</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#contrato"><i class="fas fa-file-contract"></i> Contrato</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#nps"><i class="fas fa-tachometer-alt"></i> NPS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#equipos"><i class="fas fa-box-open"></i> Equipos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tickets"><i class="fas fa-clipboard-list"></i> Tickets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#presupuesto"><i class="fas fa-funnel-dollar"></i> Presupuesto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#gastos"><i class="fas fa-hand-holding-usd"></i></i> Gastos</a>
          </li>
        </ul>
        <div class="tab-content">
          <div id="informacion" class="container tab-pane active"><br>
            <h3 style="margin-left: 40%;">Información general</h3>
            <div class="row">
              <div class="card" style="width: 18rem;">
                <img id="imagenCliente" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 id="telefonoCliente" class="card-title"></h5>
                  <p id="direccionCliente" class="card-text"></p>
                  <a href="#" class="btn btn-primary">Más detalles</a>
                </div>
              </div>
            </div>
          </div>
          <div id="contrato" class="container tab-pane fade"><br>
            <h3>Contrato</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div>
          <div id="nps" class="container tab-pane fade"><br>
            <h3>NPS</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div>
          <div id="equipos" class="container tab-pane fade"><br>
            <h3>Equipos</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
          </div>
          <div id="tickets" class="container tab-pane fade"><br>
            <h3>Tickets</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
          </div>
          <div id="presupuesto" class="container tab-pane fade"><br>
            <h3>Presupuesto</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
          </div>
          <div id="gastos" class="container tab-pane fade"><br>
            <h3>Gastos</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
          </div>
        </div>
      </div>-->
      <div class="tab_wrapper first_tab">
          <ul class="tab_list">
              <li class="active"><i class="fas fa-user-circle"></i> Información</li>
              <li><i class="fas fa-file-contract"></i> Contrato</li>
              <li><i class="fas fa-tachometer-alt"></i> NPS</li>
              <li><i class="fas fa-box-open"></i> Equipos</li>
              <li><i class="fas fa-clipboard-list"></i> Tickets</li>
              <li><i class="fas fa-funnel-dollar"></i> Presupuesto</li>
              <li><i class="fas fa-hand-holding-usd"></i></i> Gastos</li>
          </ul>
          <div class="content_wrapper">
              <div class="tab_content active">
                  <h3 style="margin-left: 40%;">Información general</h3>
                  <div class="row">
                    <div class="card" style="width: 18rem;">
                      <img id="imagenCliente" class="card-img-top" alt="...">
                      <div class="card-body">
                        <h5 id="telefonoCliente" class="card-title"></h5>
                        <p id="direccionCliente" class="card-text"></p>
                        <a href="#" class="btn btn-primary">Más detalles</a>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="tab_content">
                  <h3>Tab content 2</h3>
                  <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in
                      Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections
                      1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum,
                      "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years
                      old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature,
                      discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics,
                      very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
              </div>
              <div class="tab_content">
                  <h3>Tab content 3</h3>
                  <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage
                      of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator
                      on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition,
                      injected humour, or non-characteristic words etc. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look
                      even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined
                      chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The
                      generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
              </div>
              <div class="tab_content">
                  <h3>Tab content 4</h3>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
                      specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                      passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                      standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining
                      essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                  </p>
              </div>
              <div class="tab_content">
                  <h3>Tab content 5</h3>
                  <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
                      specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                      passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                      standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining
                      essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                  </p>
              </div>
              <div class="tab_content">
                  <h3>Tab content 6</h3>
                  <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in
                      Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections
                      1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum,
                      "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years
                      old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature,
                      discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics,
                      very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
              </div>
              <div class="tab_content">
                  <h3>Tab content 7</h3>
                  <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage
                      of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator
                      on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition,
                      injected humour, or non-characteristic words etc. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look
                      even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined
                      chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The
                      generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
              </div>
          </div>
      </div>
      <div style="margin-left: 40%;">
        <img id="cargando" class="d-none" src="/images/cargando.gif" alt="...">
      </div>

    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View drive') )

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/jquery.multipurpose_tabcontent.js"></script>
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script>
      $(function() {
        $(".first_tab").champ();
        $(".select2").select2();
        $("#cliente").on('change', function(e) {
          $("#sabana").addClass("d-none");
          $("#cargando").removeClass("d-none");
          var _token = $('input[name="_token"]').val();
          var cadena = $('#cliente').val();
          $.ajax({
            type: "POST",
            url: "/informacionCliente",
            data: { cliente : cadena, _token : _token },
            success: function (data){
              console.log(data);
              $("#imagenCliente").attr("src", "../images/hotel/" + data[0].dirlogo1);
              $("#telefonoCliente").text("Teléfono: " + data[0].Telefono);
              $("#direccionCliente").text("DIRECCIÓN: " + data[0].Direccion);
              $("#cargando").addClass("d-none");
              $("#sabana").removeClass("d-none");
            },
            error: function (data) {
              console.log('Error:', data);
            }
          });
        });
      });
    </script>

  @else
    <!--NO SCRIPTS-->
  @endif
@endpush
