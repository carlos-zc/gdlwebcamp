(function(){
    "use strict";

    document.addEventListener('DOMContentLoaded', function(){

        //Mapa LeafletJS
 
        if (document.getElementById('mapa')) { // condicion que exista el contenedor mapa para evitar error
            var map = L.map('mapa').setView([10.245689, -67.996166], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([10.245689, -67.996166]).addTo(map)
                .bindPopup('GDLWebCamp 2020.<br> Boletos ya disponibles.')
                .openPopup()
                .bindTooltip('¡No te lo pierdas!')
                .openTooltip();
        }

    }); // DOM CONTENT LOADED
})();


// jQuery
$(function(){

    // Lettering
    $('.nombre-sitio').lettering();

    // Agregar clase a menu
    $('body.conferencia .navegacion-principal a:contains("Conferencia")').addClass('activo');
    $('body.calendario .navegacion-principal a:contains("Calendario")').addClass('activo');
    $('body.invitados .navegacion-principal a:contains("Invitados")').addClass('activo');

    // menu fijo
    var windowHeight = $('div.hero').height();

    $(window).scroll(function(){
        var scroll = $(window).scrollTop();
        if(scroll > windowHeight){
            $('.barra').addClass('fixed');
            $('body').css({'margin-top': $('.barra').innerHeight() + 'px'});
        } else {
            $('.barra').removeClass('fixed');
            $('body').css({'margin-top': '0px'});
        }
        
    });

    // menu responsive
    $('.menu-movil').on('click', function(){
        $('.navegacion-principal').slideToggle();
    });

    // seleccion programa de conferecias
    $('.programa-evento .info-curso:first').show();
    $('.menu-programa a:first').addClass('activo');

    $('.menu-programa a').on('click', function(){
        $('.menu-programa a').removeClass('activo');
        $(this).addClass('activo');
        $('.ocultar').hide();
        var enlace = $(this).attr('href');
        $(enlace).fadeIn(1000);

        return false;
    });

    // Animaciones para los numeros
    $('.resumen-evento li:nth-child(1) p').animateNumber({number: 6},1200);
    $('.resumen-evento li:nth-child(2) p').animateNumber({number: 15},1300);
    $('.resumen-evento li:nth-child(3) p').animateNumber({number: 3},1000);
    $('.resumen-evento li:nth-child(4) p').animateNumber({number: 9},1200);

    // Cuenta regresiva
    $(".cuenta-regresiva").countdown("2020/12/24 09:00:00", function(event) {
        $('#dias').text(event.strftime('%D'));
        $('#horas').text(event.strftime('%H'));
        $('#minutos').text(event.strftime('%M'));
        $('#segundos').text(event.strftime('%S'));
  });

    // Colorbox
    if($(window).width() > 768) {
        $('.invitado-info').colorbox({inline:true, width:"50%"});
        $('.boton_newsletter').colorbox({inline:true, width:"50%"});
    } else {
        $('.invitado-info').colorbox({inline:true, width:"95%"});
        $('.boton_newsletter').colorbox({inline:true, width:"95%"});
    }
    

});