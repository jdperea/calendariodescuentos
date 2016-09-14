<?php
session_start();
include("../persistencia/class.mysql.php");
include("../modelo/class.productos.php");
//$ordenes = new ordenes();
$productos = new productos();
$operacion = $_REQUEST["operacion"];
//mysql_query("SET NAMES 'utf8'");

if($operacion=="actualizarPrecioProductos"){
    $productos->price_iva_inc = $_GET["price_iva_inc"];
    $productos->price_iva_excl = $_GET["price_iva_excl"];
    $productos->id_referencia = $_GET["id_referencia"];
    $productos->empleado = $_SESSION["id_employee"];
    $productos->tipo_op = $operacion;
    $productos->query = "precio con iva -> ".$_GET["price_iva_inc"] . " | precio sin iva -> ". $_GET["price_iva_excl"] . " | referencia -> ". $_GET["id_referencia"];
    
    $resul1 = $productos->updatePreciosAudit();
    
    $resul2 = $productos->updatePrecioProductos();
    
    $resul3 = $productos->updatePrecioProductos2();
    $resul4 = $productos->updatePrecioProductos3();
    $resul5 = $productos->updatePrecioProductos4();
    $resul6 = $productos->updatePrecioProductos5();
    
    echo $resul1 ."-".$resul2."-".$resul3."-".$resul4."-".$resul5."-".$resul6;
}
else if($operacion=="registrarProducto"){
    $productos->id_referencia_nueva = $_GET["id_referencia_nueva"];
    $productos->referencia_nueva = $_GET["referencia_nueva"];
    $productos->empleado = $_SESSION["id_employee"];
    $productos->tipo_op = $operacion;
    $productos->query = "id_referencia_nueva -> ".$_GET["id_referencia_nueva"] . " | referencia_nueva -> ". $_GET["referencia_nueva"];
    
    $resul1 = $productos->updatePreciosAudit();
    
    $resul2 = $productos->registrarProducto();
    
    echo $resul1 ."-".$resul2;
}
else if($operacion=="agregarCategoriaProducto"){
    $productos->id_categoria = $_GET["id_categoria"];
    $productos->id_referencia = $_GET["id_referencia"];

    
    
    $resul1 = $productos->insertCatProductos();
    
    echo $resul1;
}
else if($operacion=="quitarCategoriaProducto"){
    $productos->id_categoria = $_GET["id_categoria"];
    $productos->id_referencia = $_GET["id_referencia"];

        
    $resul1 = $productos->deleteCatProductos();
    
    echo $resul1;
}

else if($operacion=="actualizarInventario"){
    $productos->tipo_op = $operacion;
    $productos->empleado = $_SESSION["id_employee"];
    $productos->id_referencia = $_GET["id_referencia"];
    $productos->cantidad = $_GET["cantidad"];
    $talle = $_GET["talla"];
    $error = 0;
    
    switch ($talle) {
    case 'xs':
        $productos->talla = "cant_xs";
        break;
    case 's':
        $productos->talla = "cant_s";
        break;
    case 'm':
        $productos->talla = "cant_m";
        break;
    case 'l':
        $productos->talla = "cant_l";
        break;
    case 'xl':
        $productos->talla = "cant_xl";
        break;
    case '2x':
        $productos->talla = "cant_2xl";
        break;
    case '3x':
        $productos->talla = "cant_3xl";
        break;
    case '4x':
        $productos->talla = "cant_4xl";
        break;
    default :
        $error = 1;
        break;
    }
    
    $productos->query = "talla -> ". $talle . " | cantidad -> ". $_GET["cantidad"] . " | referencia -> ". $_GET["id_referencia"];
    
    $resul1 = $productos->updatePreciosAudit();
    
    if($error == 0)
    {
        $resul2 = $productos->updateCantidadProductos();
        $resul3 = $productos->updateInventarioProductos();
        $resul4 = $productos->updateInventarioProductos1();
        $resul5 = $productos->updateInventarioProductos2();
    }
    else {
    $resul2 = 'No';
    $resul3 = 'No';
    $resul4 = 'No';
    $resul5 = 'No';
    }
    echo $resul1 ."-".$resul2."-".$resul3."-".$resul4."-".$resul5;
}
else if($operacion=="obtenerProductos"){
    
    $productos->referencia = $_REQUEST["referencia_nueva"];
    $soloprod = $productos->getProductos();
    
    //los resultadosse pasan por el foreach
    $num_total_registros = $productos->num_rows($soloprod);
    //echo 'num_registros->'.$num_total_registros;
    if($num_total_registros<1){
        echo '<li>No se han encontrado resultados relacionados con la busqueda</li>';
    }
    else{
        foreach ($soloprod as $rs) {
            // put in bold the written text
            $referencia = str_replace($_REQUEST["referencia"], '<b>'.$_REQUEST["referencia"].'</b>', $rs['referencia']);
            $id_referencia = $rs["id_referencia"];
            // add new option
        echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['referencia']).'\',\''.$id_referencia.'\')">'.$referencia.'</li>';
        }
    }
}
else{
    echo "no llego operacion";
}
/*
if($operacion=="actualizarOrden"){
    
    $insert1 = 0;
    $insert2 = 0;
    $insert3 = 0;
    $insert4 = 0;
    $insert5 = 0;
    
    $ordenes->cant_ordenes = $_GET["cant_ordenes"];
    $ordenes->id_order = $_GET["id_order"];
    $ordenes->reference = $_GET["reference"];
    $ordenes->total_paid_tax_incl_old = $_GET["total_paid_tax_incl_old"];
    $ordenes->total_paid_tax_incl = $_GET["total_paid_tax_incl"];
    $ordenes->metodopago = $_GET["metodopago"];
    $ordenes->metodopagoold = $_GET["metodopagoold"];
    $ordenes->metodopagoorden0 = $_GET["metodopagoorden0"];
    $ordenes->metodopagoinicialorden0 = $_GET["metodopagoinicialorden0"];
    $ordenes->valorpagoorden0 = $_GET["valorpagoorden0"];
    $ordenes->valorinicialorden0 = $_GET["valorinicialorden0"];
    $ordenes->metodopagoorden1 = $_GET["metodopagoorden1"];
    $ordenes->metodopagoinicialorden1 = $_GET["metodopagoinicialorden1"];
    $ordenes->valorpagoorden1 = $_GET["valorpagoorden1"];
    $ordenes->valorinicialorden1 = $_GET["valorinicialorden1"];
    $ordenes->metodopagoorden2 = $_GET["metodopagoorden2"];
    $ordenes->metodopagoinicialorden2 = $_GET["metodopagoinicialorden2"];
    $ordenes->valorpagoorden2 = $_GET["valorpagoorden2"];
    $ordenes->valorinicialorden2 = $_GET["valorinicialorden2"];
    $ordenes->id_employee = $_GET["id_employee"];
    $ordenes->id_order_payment0 = $_GET["id_order_payment0"];
    $ordenes->id_order_payment1 = $_GET["id_order_payment1"];
    $ordenes->id_order_payment2 = $_GET["id_order_payment2"];

    $resul1 = $ordenes->insertAuditoria();
    
    $resul2 = $ordenes->updateOrden();
    
    if($_GET["id_order_payment0"]!=0)
    {
        $resul3 = $ordenes->updatePagosOrden1();
    if($_GET["id_order_payment1"]!=0)
    {
        $resul4 = $ordenes->updatePagosOrden2();
    if($_GET["id_order_payment2"]!=0)
    {
        $resul5 = $ordenes->updatePagosOrden3();
    }
    else{
        $resul5 = 0;
    }
    }
    else{
        $resul4 = 0;
    }
    }
    else{
        $resul3 = 0;
    }
    
    if(!isset($resul3))
    {
        $resul3 = 0;
    }
    
    if(!isset($resul4))
    {
        $resul4 = 0;
    }
    
    if(!isset($resul5))
    {
        $resul5 = 0;
    }
    /*
    if($result1=="Si")
    {
        $result ="Si";
    }
    if($resul2=="Si")
    {
        $result ="Si";
    }
    else {
        $result =$resul2;
    }*/
    //echo $result1;
   /* echo $resul1 ."-".$resul2 ."-".$resul3 ."-".$resul4 ."-".$resul5;
}*/
?>
