function contador() {
     var cronometro;
     var contador_s =5;
     cronometro = setInterval(
     function(){
          if(contador_s==0)
          {
            document.getElementById('segundos').innerHTML = 0;
            setTimeout(function(){
              // window.location.href = "{{ url('/') }}";
              window.location.href = 'http://sitwifi.com/';
            }, 1000);
            // console.log('detener');
          }
          else {
            document.getElementById('segundos').innerHTML = contador_s;
            // console.log(contador_s);
            contador_s--;
          }
     },1000);
}
(function () {
    contador();
})();
