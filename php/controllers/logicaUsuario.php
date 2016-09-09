<?php
error_reporting(E_ALL);
include("../persistencia/class.mysql.php");
include("../modelo/class.usuario.php");

$usuario = new usuario();
$operacion = filter_input(INPUT_GET, 'operacion');
if ($operacion == "logearUsu") {
    
    if (!filter_input(INPUT_GET, "usuario", FILTER_SANITIZE_EMAIL)) {
        $emailValid = "";
    } else {
        if (!filter_input(INPUT_GET, "usuario", FILTER_VALIDATE_EMAIL)) {
            $emailValid = "";
        }
        else{
            $emailValid = filter_input(INPUT_GET, "usuario", FILTER_SANITIZE_EMAIL);
        }
    }
    if (!filter_input(INPUT_GET, "clave", FILTER_SANITIZE_STRING)) {
        $pssValid = "";
    } else {
        $pssValid = filter_input(INPUT_GET, "clave", FILTER_SANITIZE_STRING);
    }    
    
    if(!$pssValid == "" || !$emailValid == "")
    {
    $usuario->codigo = $emailValid;
    $usuario->clave = $pssValid;
    $usr = $usuario->autenticarEmpleado();
    if ($usr != "No") {
        session_start();
        $usrDatos = explode("-", $usr);
        $_SESSION['estado'] = "logeado";
        $_SESSION['id_employee'] = $usrDatos[0];
        $_SESSION['id_profile'] = $usrDatos[1];
        $_SESSION['lastname'] = $usrDatos[2];
        $_SESSION['firstname'] = $usrDatos[3];
        $_SESSION['active'] = $usrDatos[4];
        $_SESSION['id_permiso'] = $usrDatos[5];
        $_SESSION['nombre_permiso'] = $usrDatos[6];
        $_SESSION['img_empleado'] = $usrDatos[7];
    }
    }
    echo $usr;
}
if ($operacion == "instalarApp") {
    $tabla = array();
    $tabla['auditoria_edicion_precios'] = "CREATE TABLE IF NOT EXISTS `auditoria_edicion_precios` (
                                            `id_aep` int(11) NOT NULL AUTO_INCREMENT,
                                            `tipo_operacion_aep` char(20) COLLATE utf8_spanish2_ci NOT NULL,
                                            `referencia` int(11) DEFAULT NULL,
                                            `consulta_ejecutada_aep` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
                                            `empleado` int(10) unsigned NOT NULL,
                                            `fechayhora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                            PRIMARY KEY (`id_aep`),
                                            KEY `FK_auditoria_edicion_precios_ps_employee` (`empleado`),
                                            CONSTRAINT `FK_auditoria_edicion_precios_ps_employee` FOREIGN KEY (`empleado`) REFERENCES `ps_employee` (`id_employee`)
                                          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    $tabla['colmoda_visita_mod_ordenes'] = "CREATE TABLE IF NOT EXISTS `colmoda_visita_mod_ordenes` (
                                `id_visita` bigint(20) NOT NULL AUTO_INCREMENT,
                                `ip_visita` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
                                `fecha_visita` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                PRIMARY KEY (`id_visita`)
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci ROW_FORMAT=COMPACT";
    $tabla['colmoda_permisos'] = "CREATE TABLE IF NOT EXISTS `colmoda_permisos` (
                                    `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
                                    `nombre_permiso` varchar(50) NOT NULL,
                                    PRIMARY KEY (`id_permiso`)
                                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $tabla['colmoda_permisos_empleados'] = "CREATE TABLE IF NOT EXISTS `colmoda_permisos_empleados` (
                    `id_permiso` int(11) NOT NULL,
                    `id_empleado` int(10) unsigned NOT NULL,
                    `fecha_asignacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    `img_empleado` varchar(15) DEFAULT NULL,
                    UNIQUE KEY `id_empleado` (`id_empleado`),
                    KEY `id_permiso` (`id_permiso`),
                    CONSTRAINT `FK_a_colmoda_permisos_empleados_a_colmoda_permisos` FOREIGN KEY (`id_permiso`) REFERENCES `colmoda_permisos` (`id_permiso`),
                    CONSTRAINT `FK_a_colmoda_permisos_empleados_ps_employee` FOREIGN KEY (`id_empleado`) REFERENCES `ps_employee` (`id_employee`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $tabla['producto_ps_all'] = "CREATE TABLE IF NOT EXISTS `producto_ps_all` (
                                `id_producto` bigint(20) NOT NULL,
                                `id_referencia` bigint(20) NOT NULL,
                                `referencia` varchar(30) NOT NULL,
                                `nombre` varchar(255) DEFAULT NULL,
                                `nombre_ing` varchar(255) DEFAULT NULL,
                                `label_a1` varchar(50) DEFAULT NULL,
                                `campo1` varchar(255) DEFAULT NULL,
                                `label_a2` varchar(50) DEFAULT NULL,
                                `campo2` varchar(255) DEFAULT NULL,
                                `label_a3` varchar(50) DEFAULT NULL,
                                `campo3` varchar(255) DEFAULT NULL,
                                `label_a4` varchar(50) DEFAULT NULL,
                                `campo4` varchar(255) DEFAULT NULL,
                                `id_marca` bigint(20) NOT NULL,
                                `marca` varchar(30) NOT NULL,
                                `id_departamento` int(11) NOT NULL,
                                `departamento` varchar(30) NOT NULL,
                                `departamento_ing` varchar(30) NOT NULL,
                                `id_color` int(11) NOT NULL,
                                `color` varchar(30) NOT NULL,
                                `color_ingles` varchar(30) NOT NULL,
                                `id_talla` int(11) NOT NULL,
                                `talla` varchar(10) NOT NULL,
                                `talla_ingles` varchar(10) NOT NULL,
                                `total` int(10) NOT NULL,
                                `precio` float NOT NULL,
                                `precio_i` double DEFAULT NULL,
                                `precio_promocion` double DEFAULT NULL,
                                `promocion_estado` tinyint(1) DEFAULT NULL,
                                `descripcion` text NOT NULL,
                                `descripcion_ing` text NOT NULL,
                                `fecha` date NOT NULL,
                                `peso` varchar(255) NOT NULL,
                                `imagen1` varchar(255) NOT NULL,
                                `imagen2` varchar(255) NOT NULL,
                                `imagen3` varchar(255) NOT NULL,
                                `imagen4` varchar(255) NOT NULL,
                                `created_at` datetime DEFAULT NULL,
                                `codigo_barras` varchar(255) NOT NULL
                              ) ENGINE=FEDERATED DEFAULT CHARSET=utf8 CONNECTION='mysql://colmoda_sistemas:k(*v!zeqF*DQ@host3.caronboutique.com:3306/colmoda_prueba/producto_ps_sin_tienda';";
    $tabla['productos_mex'] = "CREATE TABLE IF NOT EXISTS `productos_mex` (
            `id_referencia` int(11) NOT NULL,
            `referencia` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
            `cant_xs` int(11) NOT NULL,
            `cant_s` int(11) NOT NULL,
            `cant_m` int(11) NOT NULL,
            `cant_l` int(11) NOT NULL,
            `cant_xl` int(11) NOT NULL,
            `cant_2xl` int(11) NOT NULL,
            `cant_3xl` int(11) NOT NULL,
            `cant_4xl` int(11) NOT NULL,
            `price_iva_inc` decimal(20,6) NOT NULL,
            `price_iva_excl` decimal(20,6) NOT NULL,
            `tasa_iva` decimal(20,6) NOT NULL,
            PRIMARY KEY (`id_referencia`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci ROW_FORMAT=COMPACT;";
    $valores = '
        <table class="table">
        <thead>
           <tr>
              <th>Nombre Tabla</th>
              <th>Existe</th>
           </tr>
        </thead>
        <tbody>
        ';
    /*
     * 
            * <tr>
            * <th scope="row">1</th>
            * <td>Mark</td>
            * <td>Otto</td>
            * <td>@mdo</td>
            * </tr>
        * 
     */
    foreach ($tabla as $key =>  $crearTabla) {
        $usuario->crearTabla = $crearTabla;
        $usuario->nTabla = $key;
        $valor = $usuario->validarTablas();
        
        $num_total_registros = $usuario->num_rows($valor);
        //$valores .= $key.' | num_total_registros - '.$num_total_registros.'<br>';
        if ($num_total_registros > 0) {
            if ($tablas = $usuario->fetch_array($valor)) {
                //$usr.="-" . $tablas["nombretabla"];
                //$usr.="-" . $tablas["existe"];
                if($tablas["existe"]==1){
                    $valores .= '<tr><th>'.$key.'</th><td class="alert alert-danger">ya existe</td></tr>';
                }
                else {
                   
                    
                }
                //$valores .= "hola mundo";
            }
            
        } else {
            $valores .= $usuario->instalarAplicacion(); 
            $valores .= '<tr><th>'.$key.' </th><td class="alert alert-success">Creado correctamente</td></tr>';
            //$valores .= "No".$num_total_registros;
            
        }
        
        
        
    }
    $insert  = array();  
    $insert["colmoda_permisos"] = "
        INSERT INTO `colmoda_permisos` (`id_permiso`, `nombre_permiso`) VALUES
	(1, 'Asesor Ventas'),
	(2, 'Asesor Ventas Call Center'),
	(3, 'Manager Call Center'),
	(4, 'Manager Ventas'),
	(5, 'Super Administrador');";
    $insert["colmoda_permisos_empleados"] = "
        insert into colmoda_permisos_empleados 
        select 1,e.id_employee,now(), null from ps_employee e;";
    
    foreach ($insert as $key =>  $insertarTablas) {
        $usuario->insertarTabla = $insertarTablas;
       
            $valo .= $usuario->insertarAplicacion(); 
            $valores .= '<tr><th>'.$key.' </th><td class="alert alert-success">Insertado correctamente</td></tr>';
            //$valores .= "No".$num_total_registros;
    }
    
    $valores .= '   </tbody>
                </table>';
    echo ''.$valores;
    //echo $num_total_registros;
}
if ($operacion == "registrarEmp") {
    $usuario->codigo = $_GET["documentoEmp"];
    $usuario->nombre = $_GET["nombreEmp"];
    $usuario->correo = $_GET["emailEmp"];
    $usuario->telefono = $_GET["telefonoEmp"];
    $usuario->profesion = $_GET["profesionEmp"];
    $usuario->clave = $_GET["passwordEmp"];
    $usuario->ciudad = $_GET["ciudad"];
    $resul = $usuario->registrarEmprendedor();
    echo $resul;
}
if ($operacion == "registrar") {
    $usuario->codigo = $_GET["documentoEmp"];
    $usuario->nombre = $_GET["nombreEmp"];
    $usuario->correo = $_GET["emailEmp"];
    $usuario->telefono = $_GET["telefonoEmp"];
    $usuario->profesion = $_GET["profesionEmp"];
    $usuario->clave = $_GET["passwordEmp"];
    $usuario->ciudad = $_GET["ciudad"];
    $resul = $usuario->registrarEmprendedor();
    echo $resul;
}
?>