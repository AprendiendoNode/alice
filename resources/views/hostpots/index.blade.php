<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <!--<link rel="stylesheet" href="/css/style.css">-->
    <link rel="stylesheet" href="{{ asset('css/hostpots/style.css') }}">
</head>
<body>
    
    <!--Panel de carga-->
    <div id="loading-page">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="container" id="main-content">
        <div class="row mb-3">
            <div class="col-md-12">
                <h2>Reports</h2>
            </div>
        </div>
        <!--Panel de scopes-->
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="select-scope">Scope</label>
                <select id="select-scope" class="form-control"></select>
            </div>
        </div>

        <!--Panel de hostspots-->
        <div class="row mb-3" id="panel-select-hotspots" style="display: none;">
            <div class="col-md-12 loading-panel text-center">
                <div class="spinner-border" role="status" >
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="col-md-12 filter-panel">
                <select id="select-hotspots" class="form-control" name="hotspots" multiple="multiple"></select>
                <br />
                <button class="btn btn-primary mt-3">Find</button>
            </div>
        </div>

        <!--Panel de grafica-->
        <div class="panel-grafica row mb-3"  id="panel-grafica" style="display:none;" >
            <div class="content-filters col-md-12 row mb-3">
                <div class="col-md-6">
                    <select id="filter-data-select" class="form-control"></select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="fechaInicio">
                        <option value="<?= date("Y-m-d", strtotime("-7 days")) ?>">7 days</option>
                        <option value="<?= date("Y-m-d", strtotime("-30 days")) ?>">30 days</option>
                        <option value="<?= date("Y-m-d", strtotime("-90 days")) ?>">90 days</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="hidden" class="form-control" value="<?= date("Y-m-d") ?>" name="fechaFinal">
                </div>
            </div>
            <div class="col-md-12  card">
                <div class="card-body">
                    <div class="col-md-12 loading-panel text-center">
                        <div class="spinner-border" role="status" >
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="col-md-12" id="graphic-content">
                        <div class="grafica" style="display: none; width: 100%; min-height: 400px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.7.0/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <!--<script src="./dist/gs.js"></script>-->
    <script src="{{ asset('js/hostpots/gs.js') }}"></script>
    <script>
        $(() => {
            $("#select-hotspots").select2({
                placeholder: 'filter by hostpot'
            });
        });
        $("#select-scope").on('change', () => {
            $("#select-hotspots").val(null).trigger('change');
        });
    </script>
    <!--<script src="{{ asset('bower_components/incubator-echarts-4.2.1/dist/echarts.min.js') }}"></script>-->
</body>
</html>