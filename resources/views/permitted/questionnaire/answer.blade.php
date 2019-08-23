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
      <div class="py-5 text-center">
        <img class="d-block mx-auto" src="{{ asset('images/questionnaire/logo.png') }}" alt="" width="10%" >
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card border-0 mx-auto text-center">
            <div class="card-body">
              <h5 class="text-uppercase"><strong> {{ $title }} </strong></h5>
              <strong>Estatus:</strong><span>  {{ $message }}.</span><br>

              <!--<em><p>La información ingresada es confidencial, no será analizada de forma individual sino de forma global.</p></em>-->
              <div class="row py-3">
                <div class="col-md-12">
                  <i class="{{ $icon }} fa-5x"></i>
                  <i class="fas fa-spinner fa-spin fa-5x"></i>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 mx-auto">
                  <strong>Nota:</strong><span> {{ $nota }}.</span>
                  <em><p class="py-2" style="letter-spacing: 2px">Tiempo de espera: </p></em>
                  <button type="button" class="btn btn-info btn-block"  id="segundos"></button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2019 Sitwifi</p>
      </footer>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/admin/questionnaire/answer.js') }}" charset="utf-8"></script>
    <style media="screen">
      .error {
        color: #f62d51;
      }
      .fa-thumbs-up{
        color: #3b5998;
      }
      .fa-spin{
        color: #ec7a00;
      }
      .fa-exclamation-triangle {
        color: #f62d51;
      }
    </style>
    <script>

    </script>
  </body>
</html>
