(function(){
    "use strict";

    var regalo = document.getElementById('regalo');
    document.addEventListener('DOMContentLoaded', function(){
        
        // campos datos usuario
        var nombre = document.getElementById('nombre');
        var apellido = document.getElementById('apellido');
        var email = document.getElementById('email');

        // campos pases
        var pase_dia = document.getElementById('pase_dia');
        var pase_dosdias = document.getElementById('pase_dosdias');
        var pase_completo = document.getElementById('pase_completo');

        // botones y divs
        var calcular = document.getElementById('calcular');
        var errorDiv = document.getElementById('error');
        var botonRegistro = document.getElementById('btnRegistro');
        var lista_productos = document.getElementById('lista-productos');
        var suma = document.getElementById('suma-total');

        // extras
        var etiquetas = document.getElementById('etiquetas');
        var camisas = document.getElementById('camisa_evento');

        if(botonRegistro){
            botonRegistro.disabled = true;
        }

        if(document.getElementById('calcular')) { // condicion opcional de que exista el boton calcular para evitar error en consola
            calcular.addEventListener('click', calcularMontos);

            pase_dia.addEventListener('blur', mostrarDias);
            pase_dosdias.addEventListener('blur', mostrarDias);
            pase_completo.addEventListener('blur', mostrarDias);

            nombre.addEventListener('blur', validarCampos);
            apellido.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarEmail);

            if(pase_dia.value || pase_dosdias.value || pase_completo.value){
                mostrarDias();
            }

            function validarCampos(){
                if(this.value == ''){
                    errorDiv.style.display = "block";
                    errorDiv.innerHTML = "Este campo es obligatorio";
                    errorDiv.style.border = "1px solid red";
                    this.style.border = "1px solid red";
                } else {
                    error.style.display = "none";
                    this.style.border = "1px solid #ccc";
                }
            }

            function validarEmail(){
                if(this.value.indexOf("@") > -1){
                    error.style.display = "none";
                    this.style.border = "1px solid #ccc";
                } else {
                    errorDiv.style.display = "block";
                    errorDiv.innerHTML = "Debe contener al menos un @";
                    errorDiv.style.border = "1px solid red";
                    this.style.border = "1px solid red";
                }
            }


            function calcularMontos(event){
                event.preventDefault();
                if(regalo.value === ''){
                    alert("Debes elegir un regalo");
                    regalo.focus();
                } else {
                    var boletosDia = parseInt(pase_dia.value, 10) || 0,
                        boletos2Dias = parseInt(pase_dosdias.value, 10) || 0,
                        boletosCompletos = parseInt(pase_completo.value, 10) || 0,
                        cantCamisas = parseInt(camisas.value, 10) || 0,
                        cantEtiquetas = parseInt(etiquetas.value, 10) || 0;

                    var totalPagar = (boletosDia * 30) + (boletos2Dias * 45) + (boletosCompletos * 50) + ((cantCamisas * 10) * .93) + (cantEtiquetas * 2);
                    
                    var listadoProductos = [];

                    if(boletosDia >= 1){
                        listadoProductos.push(boletosDia + ' pase/s por día');
                    }
                    if(boletos2Dias >= 1){
                        listadoProductos.push(boletos2Dias + ' pase/s por 2 días');
                    }
                    if(boletosCompletos >= 1){
                        listadoProductos.push(boletosCompletos + ' pase/s completos');
                    }
                    if(cantCamisas >= 1){
                        listadoProductos.push(cantCamisas + ' camisas');
                    }
                    if(cantEtiquetas >= 1){
                        listadoProductos.push(cantEtiquetas + ' etiquetas');
                    }

                    lista_productos.style.display = "block";
                    lista_productos.innerHTML = '';
                    for(var i = 0; i < listadoProductos.length; i++){
                        lista_productos.innerHTML += listadoProductos[i] + '<br/>';
                    }

                    suma.innerHTML = "$ " + totalPagar.toFixed(2);

                    botonRegistro.disabled = false;
                    document.getElementById('total_pedido').value = totalPagar;

                }
            }

            function mostrarDias(){
                var boletosDia = parseInt(pase_dia.value, 10) || 0,
                    boletos2Dias = parseInt(pase_dosdias.value, 10) || 0,
                    boletosCompletos = parseInt(pase_completo.value, 10) || 0;

                var diasElegidos = [];

                if(boletosDia > 0){
                    diasElegidos.push('Friday');
                }
                if(boletos2Dias > 0){
                    diasElegidos.push('Friday','Saturday');
                }
                if(boletosCompletos > 0){
                    diasElegidos.push('Friday','Saturday','Sunday');
                }

                for(var i = 0; i < diasElegidos.length; i++){
                    document.getElementById(diasElegidos[i]).style.display = "block";
                }
            }

        } // Fin condicion boton calcular



    }); // DOM CONTENT LOADED
})();