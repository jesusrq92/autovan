/*$(document).ready(function () {
        $('ul.nav > li').click(function (e) {
            e.preventDefault();
            $('ul.nav > li').removeClass('active');
            $(this).addClass('active');                
        });            
    });*/

    //Cambia a la siguiente section mostrando transición

$(document).ready(function(){
     $('a[href^="#"]').on('click',function (e) {
         e.preventDefault();

         var target = this.hash;
         var $target = $(target);

         $('html, body').stop().animate({
             'scrollTop': $target.offset().top
         }, 900, 'swing', function () {
             window.location.hash = target;
            });
     });
}); 
