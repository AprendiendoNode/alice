<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
  @include('layouts.auth.header')
  <body>
    <div id="app"class="container-scroller">
      @include('layouts.admin.navbar')
      <div class="container-fluid page-body-wrapper">
          @include('layouts.admin.siderbar')
          <!-- partial -->
          <div class="main-panel">
            <div class="content-wrapper">
              <div class="row">
                <div class="col-md-12 grid-margin-onerem">
                  <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end flex-wrap">
                      <div class="mr-md-3 mr-xl-5">
                        <h5 class="mb-md-0">@yield('contentheader_title', 'Header here')</h5>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <i class="mdi mdi-home text-muted hover-cursor"></i>
                        <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;@yield('breadcrumb_title', 'breadcrumb here')&nbsp;</p>
                    </div>
                  </div>
                </div>
              </div>
              @yield('content')
            </div>
            @include('layouts.admin.footer')
          </div>
          <!-- partial -->
      </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @include('layouts.auth.scripts')
    <script src="{{ asset('/js/general.js') }}"></script>
    @stack('scripts')
  </body>
</html>
