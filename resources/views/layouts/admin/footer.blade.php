        <div class="wow bounceIn from-me bubble message1 text-left" data-wow-delay=".8s"  style=" display: none;cursor: pointer; position: fixed; bottom: 60px !important; right: 65px !important; font-size:15px;">
          <p class="pt-1">Hey!
        </div>
        <div class="wow bounceIn from-me bubble text-left" data-wow-delay="2.5s"  id="globo" style=" display: none;cursor: pointer; z-index:10; position: fixed; bottom: 60px !important; right: 65px !important; font-size:15px;">
          <p class="pt-1">¿Necesitas ayuda?</p>
        </div>
        <div class="wow bounceInUp bubble circle" id="globo" style="display: none; cursor: pointer; z-index:15;position: fixed; bottom: -10px !important; right: 5px !important;">A
          <img src="/images/docs/cancel.svg" id="globo_close">
        </div>

        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2019 <a  class="auth-link text-black">Sitwifi</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">2.0 <i class="mdi mdi-upload text-success"></i><i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
@push('scripts')
  <link rel="stylesheet" href="/bower_components/animate/animate.css">
  <script src="/bower_components/animate/wow.min.js" ></script>
  <style media="screen">
    #globo_close {
      position: absolute;
      top: -1.95vh;
      right: -0.20vw;
      width: 1.35vw;
      /*font-size: 2vw;
      font-weight: bold;
      color: black;*/
    }
    .circle {
  width: 50px;
  height: 50px;
  line-height: 50px;
  border-radius: 50%; /* the magic */
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  text-align: center;
  color: white;
  font-size: 32px;
  text-transform: uppercase;
  font-weight: 700;
  margin: 0 auto 40px;
  background-color: #282C34;
}

.from-me {
  position: relative;
  padding: 10px 20px;
  color: white;
  background: #0B93F6;
  border-radius: 25px;
  float: right;
}
.from-me:before {
  content: "";
  position: absolute;
  z-index: -1;
  bottom: -2px;
  right: -7px;
  height: 20px;
  border-right: 20px solid #0B93F6;
  border-bottom-left-radius: 16px 14px;
  -webkit-transform: translate(0, -2px);
}
.from-me:after {
  content: "";
  position: absolute;
  z-index: 1;
  bottom: -2px;
  right: -56px;
  width: 26px;
  height: 20px;
  background: white;
  border-bottom-left-radius: 10px;
  -webkit-transform: translate(-30px, -2px);
}

  </style>
    @if( auth()->user()->can('View Help Assistant') )
  <script>
    $('.bubble').show();
    new WOW().init();
    $('#globo').on('click',function(){
      var urlarray=(window.location.href).split("/");
      var url = urlarray.pop();
      if(url == "home" || url == "") {
        var ventana = window.open("http://"+urlarray[2]+"/docs/2.0/home/dash", "_blank");
        ventana.focus();
        $('.bubble').hide();
      } else if(url == "dash_finan") {
        var ventana = window.open("http://"+urlarray[2]+"/docs/2.0/home/dash_finan", "_blank");
        ventana.focus();
        $('.bubble').hide();
      } else {
        $('.bubble').hide();
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
        });
      }
    });
    $(".message1").delay(1300).fadeOut(500);
    $('#globo_close').on('click',function() {
      $('.bubble').hide();
    });
  </script>
    @endif
@endpush
