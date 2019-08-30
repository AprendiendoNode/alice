<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/iconified/favicon.ico') }}" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link href="public/bower_components/supersized/css/supersized.css" rel="stylesheet" type="text/css" /> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <title>Encuesta</title>
  </head>
  <body class="bg-light">
    <div class="container">
      <div class="py-4 text-center">
        <img class="d-block mx-auto" src="{{ asset('images/questionnaire/logo.png') }}" alt="" width="10%" >
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card border-0 ">
            <div class="card-body">
              <h5><strong> Advertencia </strong></h5>
              <em><p>La información ingresada es totalmente confidencial.</p></em>
              <form id="questionary" name="questionary" class="needs-validation" action="{{ url('create_questionary') }}" method="POST" novalidate>
              @php ($preg = [])
              @php ($data_survey = [])

              @forelse ($question as $data_question)
                @php ( $ultimo = $loop->count )
                @php ($preg[] = $data_question->id)
                @if ($data_question->type_id == '1')
                  <div class="row">
                    <!-- <label class="col-md-12">{{ $loop->iteration }}.- {{ $data_question->name }}</label> -->
                    @php ($position = $data_question->id)
                    <label class="col-md-12">{{ $loop->iteration }}.- {{ $data_question->name }}</label>
                    <div class="col-md-12 mb-3">
                      @if ($data_question->obligatory == '0')
                        <!-- No obligatory ------------------------------------------------------------------------->
                        @forelse ( App\Models\Survey\Questiondinamic::find($data_question->id)->optiondinamics as $data_option)
                        <div class="custom-control custom-radio custom-control-inline">
                          <input id="radio{{$position}}{{$loop->iteration}}" name="pregunta{{$data_question->id}}" value="{{ $data_option->id}}" class="custom-control-input" type="radio">
                          <label class="custom-control-label" for="radio{{$position}}{{$loop->iteration}}">{{ $data_option->name}}</label>
                        </div>
                        @empty
                        {{ __('reservedwords.notavailable') }}
                        @endforelse
                        <!------------------------------------------------------------------------------------------>
                      @elseif ($data_question->type_id == '1')
                        <!-- Obligatory ---------------------------------------------------------------------------->
                        @forelse ( App\Models\Survey\Questiondinamic::find($data_question->id)->optiondinamics as $data_option)
                        <div class="custom-control custom-radio custom-control-inline emotion">
                          <input id="radio{{$position}}{{$loop->iteration}}" name="pregunta{{$data_question->id}}"  value="{{ $data_option->id}}" class="custom-control-input" type="radio" required>
                          <label class="custom-control-label text-center" for="radio{{$position}}{{$loop->iteration}}">
                            @if (!empty($data_option->icon))
                              <i class="{{$data_option->icon}}"></i><br>
                            @endif
                            {{ $data_option->name}}</label>
                        </div>
                        @empty
                        {{ __('reservedwords.notavailable') }}
                        @endforelse
                        <!------------------------------------------------------------------------------------------>
                      @endif
                    </div>
                  </div>
                @elseif ($data_question->type_id == '2')
                  @php ($position = $loop->iteration)
                  @if ($data_question->obligatory == '0')
                  <!-- No obligatory ------------------------------------------------------------------------->
                  <div class="mb-3">
                    <div class="form-group">
                      <label for="pregunta{{$position}}">{{ $position }}.- {{ $data_question->name }}</label>
                      <textarea class="form-control" id="pregunta{{$data_question->id}}" name="pregunta{{$data_question->id}}" rows="3"></textarea>
                    </div>
                  </div>
                  <!------------------------------------------------------------------------------------------>
                  @elseif ($data_question->obligatory == '1')
                  <!-- Obligatory ---------------------------------------------------------------------------->
                  <div class="mb-3">
                    <div class="form-group">
                      <label for="pregunta{{$position}}">{{ $position }}.- {{ $data_question->name }}</label>
                      <textarea class="form-control" id="pregunta{{$data_question->id}}" name="pregunta{{$data_question->id}}" rows="3" required></textarea>
                    </div>
                  </div>
                  <!------------------------------------------------------------------------------------------>
                  @endif
                @endif
              @empty
                {{ __('reservedwords.notavailable') }}
              @endforelse

              @php ($data_survey[] = $ultimo)
              @php ($data_survey[] = $id_user)
              @php ($data_survey[] = $id_survey)
              @php ($data_survey[] = $date_active)
              @php ($data_survey[] = $verify_fecha_corresponde)


              {{ csrf_field() }}
              <input class="form-control" type="hidden" placeholder="" id="ultimapreg" name="ultimapreg" value="{{ Crypt::encryptString(implode(',', $data_survey)) }}">
              <input class="form-control" type="hidden" placeholder="" id="ordenpreg" name="ordenpreg" value="{{ Crypt::encryptString(implode(',', $preg)) }}">

              <hr class="mb-4">
              <button class="btn btn-primary btn-lg btn-block" type="submit">Finalizar</button>
          </form>
            </div>
          </div>
        </div>
      </div>

      <footer class="my-2 pt-1 text-muted text-center text-small">
        <p class="mb-1">

          Fecha de expiración: {{ $date_end }} <br>
          Copyright Sitwifi &copy;  All rights reserved</p>
      </footer>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/admin/questionnaire/quiz.js') }}" charset="utf-8"></script>
    <style media="screen">
      /* body {
        background-image:url('../images/questionnaire/polygons.jpg');
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      } */
      .error {
        color: #f62d51;
      }
      .emotion i {
          font-size: 4.5rem;
      }
    </style>
    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
              console.log('if');
            }
            else {
              console.log('else');
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
    </script>
  </body>
</html>
