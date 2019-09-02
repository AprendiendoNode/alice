  <!--<img src="/images/docs/message.svg" class="wow bounceInUp"style=" display: none; cursor: pointer;position: fixed !important; width:8vw;height: 6vw; bottom:10px !important; right: 5px!important; "alt="">-->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2019 <a  class="auth-link text-black">Sitwifi</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">2.0 <i class="mdi mdi-upload text-success"></i><i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
@push('scripts')
  <!--<link rel="stylesheet" href="https://wowjs.uk/css/libs/animate.css">
  <script src="https://wowjs.uk/dist/wow.min.js" ></script>-->
  <style media="screen">
    .stickybuble{
      position: fixed !important;
      bottom:10px !important;
      right: 5px!important;
      width:4vw;
      height: 4vw;
      /*border-radius:50%;*/
    }
  </style>
  <script>
  /*  $('.wow').show();
    new WOW().init();
    $('.wow').on('click',function(){
      var urlarray=(window.location.href).split("/");
      var url = urlarray.pop();
         $.ajax({
           type: "GET",
           url: '/searchDocumentation',
           data:{url: url },
           success: function (data) {
             //console.log(data);
              var ruta=JSON.parse(data)[0]['name'];
             var ventana= window.open("http://"+urlarray[2]+"/docs/2.0/"+ruta+"/"+url, "_blank");
             ventana.focus();
           },
           error: function (data) {
             console.log(data);
           }
         })

    });*/
  </script>

@endpush
