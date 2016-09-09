/* 
 * @Juandp
 * jdperea59@gmail.com
 * Para Moda de Colombia S.A.S.
 */

function AsociarCate(o) {
    cadena = o.split('-');
    //alert(cadena[0] + "-" + cadena[1]);
    var id_categoria = cadena[0];
    var id_referencia = cadena[1];
    var isChecked = $("#cat-"+o).prop('checked');
    var mensaje = "";
    if(isChecked === true){
        //alert("it's true");
        $.get("logica/logicaProductos.php",
                    {operacion: "agregarCategoriaProducto", id_referencia: id_referencia, id_categoria: id_categoria
                    },
            function (resultados)
            {
                if (resultados === false){
                    alert("Error");
                }
                else{
                    if (resultados === "No")
                    {
                        //$('#box_notificacionRegistro').animate({'top': '65px'}, 500);
                        mensaje += "Problemas en el Registro";
                        alert(mensaje);
                    }
                    else
                    {
                        var referencia = $("#ref-"+id_referencia).val();
                        if (resultados === "Si")
                        {
                            //jQuery('html, body').animate({scrollTop: 0}, 'slow');
                            //$('#box_notificacionRegistro').animate({'top': '65px'}, 500);
                            //alert(resultados);
                            mensaje += '<button type="button" class="btn btn-success " id="categoria-'+referencia+'">OK</button>';
                            document.getElementById('mensajes'+id_referencia).innerHTML = '' + mensaje;
                            }

                            //alert(mensaje);
                        
                    }
                }
            });
        setTimeout(
        function() 
        {
          document.getElementById('mensajes'+id_referencia).innerHTML = '';
        }, 5000);
    }
    else{
        //alert("falsooo")
        $.get("logica/logicaProductos.php",
                    {operacion: "quitarCategoriaProducto", id_referencia: id_referencia, id_categoria: id_categoria
                    },
            function (resultados)
            {
                if (resultados === false){
                    alert("Error");
                }
                else{
                    if (resultados === "No")
                    {
                        //$('#box_notificacionRegistro').animate({'top': '65px'}, 500);
                        mensaje += "Problemas en el Registro";
                        alert(mensaje);
                    }
                    else
                    {
                        var referencia = $("#ref-"+id_referencia).val();
                        if (resultados === "Si")
                        {
                            //jQuery('html, body').animate({scrollTop: 0}, 'slow');
                            //$('#box_notificacionRegistro').animate({'top': '65px'}, 500);
                            //alert(resultados);
                            mensaje += '<button type="button" class="btn btn-success " id="categoria-'+referencia+'">Borrado OK</button>';
                            document.getElementById('mensajes'+id_referencia).innerHTML = '' + mensaje;
                            }

                            //alert(mensaje);
                        
                    }
                }
            });
        setTimeout(
        function() 
        {
          document.getElementById('mensajes'+id_referencia).innerHTML = '';
        }, 5000);
    }
    //alert(isChecked);
    
    
    
    
}

function ModTrans(o) {
    /*
     * @jdperea59
     * Mandamos las variables por medio de este formulario en javascript
     */
    var orden = o;

    var url = 'editar_envio.php';
    var form = $('<form action="' + url + '" method="post"  target="_blank">' +
            '<input type="text" name="o" value="' + orden + '" />' +
            '</form>');
    $(form).submit();

}

function cerrarSession() {

    if (confirm("¿Desea Cerrar la Sesión?") == true) {
        //x = "You pressed OK!";
        window.location = "logica/cerrar.php";
        //alert("debe cerrar")
    } else {
        //x = "You pressed Cancel!";
        //alert("como digas");
    }
}

function actualizarTotal(p) {
    /*
     * @jdperea59
     * Mi funcion para actualizar los campos
     */
    
    var producto = p;
    var precio_iva_inc = $("#pi-"+producto).val();
    var iva = $("#iva-"+producto).val();
    var otro_iva = "1."+iva;
    var precio_iva_excl = precio_iva_inc/otro_iva;
    //alert("o->"+producto+"\npii->"+precio_iva_inc+"\niva->"+iva+"\noi->"+otro_iva+"\npie->"+precio_iva_excl);
    var elem = document.getElementById("pe-"+producto);
    elem.value = '' + precio_iva_excl;
}

function registrarProducto(){
    /*
     * @jdperea59
     * Mi funcion para registrar el nuevo producto
     */
     var id_referencia_nueva = $("#id_referencia_nueva").val();
     var referencia_nueva = $("#referencia_nueva").val();
    
    
    $.get("logica/logicaProductos.php",
                    {operacion: "registrarProducto", id_referencia_nueva: id_referencia_nueva, referencia_nueva: referencia_nueva
                    },
            function (resultados)
            {
                //alert(resultados);
                var contador = 0;
                cadena = resultados.split('-');
                mensaje = "";
                for (i = 0; i < cadena.length; i++) {
                    resultado = cadena[i];

                    if (resultado === false)
                    {
                        alert("Error");
                    }
                    else
                    {
                        if (resultado === "No")
                        {
                            //$('#box_notificacionRegistro').animate({'top': '65px'}, 500);
                            mensaje += "Problemas en el Registro";
                            alert(mensaje);
                        }
                        else
                        {
                            var referencia = $("#referencia_nueva").val();
                            if (resultado === "Si")
                            {
                                //jQuery('html, body').animate({scrollTop: 0}, 'slow');
                                //$('#box_notificacionRegistro').animate({'top': '65px'}, 500);

                                //alert(resultado);
                                contador += 1;
                                if(contador>1){
                                mensaje += '<button type="button" class="btn btn-success " id="producto-nuevo-'+referencia+'">OK</button>';
                                document.getElementById('msg-producto-nuevo').innerHTML = '' + mensaje;
                                }
                                
                                //alert(mensaje);
                            }
                            else {
                                if (resultado != 0) {
                                    
                                    mensaje += '<div class="alert alert-danger" role="alert">Error en modificación del producto ' + referencia + '</div>';
                                    document.getElementById('msg-producto-nuevo').innerHTML = '' + mensaje;
                                    //document.getElementById('mensajes').innerHTML = resultado +'<br>' +mensaje;
                                }

                            }
                        }
                    }
                }
            }

            );
    
    setTimeout(
        function() 
        {
          document.getElementById('producto-nuevo').innerHTML = '';
        }, 5000);
}

function actualizarInventario(p){
    var mensaje = "";
    
    cadena = p.split('-');
    var producto = cadena[1];
    var talla = cadena[0];
    //alert(producto + "\n" + talla);
    var cantidad = $("#c"+talla+"-"+producto).val();
    //alert(cantidad);
    
    $.get("logica/logicaProductos.php",
                    {operacion: "actualizarInventario", id_referencia: producto, talla: talla, cantidad: cantidad
                    },
            function (resultados)
            {
                //alert(resultados);
                var contador = 0;
                cadena = resultados.split('-');
                for (i = 0; i < cadena.length; i++) {
                    resultado = cadena[i];

                    if (resultado === false)
                    {
                        alert("Error");
                    }
                    else
                    {
                        if (resultado === "No")
                        {
                            mensaje += "Problemas en el Registro";
                            alert(mensaje);
                        }
                        else
                        {
                            var referencia = $("#ref-"+producto).val();
                            if (resultado === "Si")
                            {
                                contador += 1;
                                if(contador>4){
                                mensaje += '<button type="button" class="btn btn-success " id="cont-'+referencia+'">OK</button>';
                                
                                document.getElementById('mensajes'+producto).innerHTML = '' + mensaje;
                                }
                                
                                //alert(mensaje);
                            }
                            else {
                                if (resultado != 0) {
                                    
                                    mensaje += '<div class="alert alert-danger" role="alert">Error en modificación del inventario del producto ' + referencia + '</div>';
                                    document.getElementById('mensajes').innerHTML = '' + mensaje;
                                    //document.getElementById('mensajes').innerHTML = resultado +'<br>' +mensaje;
                                }

                            }
                        }
                    }
                }
            }

            );
    setTimeout(
        function() 
        {
          document.getElementById('mensajes'+producto).innerHTML = '';
        }, 5000);
}

function actualizarPrice(p){
    var producto = p;
    var mensaje = "";
    var precio_iva_inc = $("#pi-"+producto).val();
    var precio_iva_exc = $("#pe-"+producto).val();
    var iva = $("#iva-"+producto).val();
    iva = iva/100;
    //alert(precio_iva_exc+ "\n"+precio_iva_inc+ "\n"+iva);
    
    $.get("logica/logicaProductos.php",
                    {operacion: "actualizarPrecioProductos", id_referencia: producto, price_iva_excl: precio_iva_exc, price_iva_inc: precio_iva_inc
                    },
            function (resultados)
            {
                //alert(resultados);
                var contador = 0;
                cadena = resultados.split('-');
                for (i = 0; i < cadena.length; i++) {
                    resultado = cadena[i];

                    if (resultado === false)
                    {
                        alert("Error");
                    }
                    else
                    {
                        if (resultado === "No")
                        {
                            //$('#box_notificacionRegistro').animate({'top': '65px'}, 500);
                            mensaje += "Problemas en el Registro";
                            alert(mensaje);
                        }
                        else
                        {
                            var referencia = $("#ref-"+producto).val();
                            if (resultado === "Si")
                            {
                                //jQuery('html, body').animate({scrollTop: 0}, 'slow');
                                //$('#box_notificacionRegistro').animate({'top': '65px'}, 500);

                                //alert(resultado);
                                contador += 1;
                                if(contador>5){
                                mensaje += '<button type="button" class="btn btn-success " id="cont-'+referencia+'">OK</button>';
                                
                                document.getElementById('mensajes'+producto).innerHTML = '' + mensaje;
                                }
                                
                                //alert(mensaje);
                            }
                            else {
                                if (resultado != 0) {
                                    
                                    mensaje += '<div class="alert alert-danger" role="alert">Error en modificación del producto ' + referencia + '</div>';
                                    document.getElementById('mensajes').innerHTML = '' + mensaje;
                                    //document.getElementById('mensajes').innerHTML = resultado +'<br>' +mensaje;
                                }

                            }
                        }
                    }
                }
            }

            );
    
    setTimeout(
        function() 
        {
          document.getElementById('mensajes'+producto).innerHTML = '';
        }, 5000);
}