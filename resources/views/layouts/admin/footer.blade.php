        <div class="wow bounceInUp" style=" display: none; cursor: pointer; position: fixed; bottom: 10px !important; right: 5px !important;">
          <img src="/images/docs/message.svg" id="globo" style="width: 10vw; height: 12vh;" alt="">
          <img src="/images/docs/cancel.svg" id="globo_close">
        </div>
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2019 <a  class="auth-link text-black">Sitwifi</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">2.0 <i class="mdi mdi-upload text-success"></i><i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
@push('scripts')
  <link rel="stylesheet" href="https://wowjs.uk/css/libs/animate.css">
  <script src="https://wowjs.uk/dist/wow.min.js" ></script>
  <style media="screen">
    #globo_close {
      position: absolute;
      top: -1.75vh;
      right: -0.25vw;
      width: 1.75vw;
      /*font-size: 2vw;
      font-weight: bold;
      color: black;*/
    }
  </style>
  <script>
    /*$('.wow').show();
    new WOW().init();
    $('#globo').on('click',function(){
      var urlarray=(window.location.href).split("/");
      var url = urlarray.pop();
      if(url == "home" || url == "") {
        var ventana = window.open("http://"+urlarray[2]+"/docs/2.0/home/dash", "_blank");
        ventana.focus();
        $('.wow').hide();
      } else if(url == "dash_finan") {
        var ventana = window.open("http://"+urlarray[2]+"/docs/2.0/home/dash_finan", "_blank");
        ventana.focus();
        $('.wow').hide();
      } else {
        $.ajax({
          type: "GET",
          url: '/searchDocumentation',
          data:{url: url },
          success: function (data) {
            //console.log(data);
            var ruta=JSON.parse(data)[0]['name'];
            var ventana= window.open("http://"+urlarray[2]+"/docs/2.0/"+ruta+"/"+url, "_blank");
            ventana.focus();
            $('.wow').hide();
          },
          error: function (data) {
            console.log(data);
          }
        });
      }
    });
    $('#globo_close').on('click',function() {
      $('.wow').hide();
    });*/
  </script>

@endpush
