<?php

/*
 * @Juandp
 * jdperea59@gmail.com
 */

class usuario extends MySQL {

    var $id_employee = "";
    var $id_profile = "";
    var $lastname = "";
    var $firstname = "";
    var $active = "";

    function autenticarEmpleado() {
        $cookie = _COOKIE_KEY_;
        $consulta = parent::consulta("Select e.id_employee,  e.id_profile, e.lastname, e.firstname, e.active, p.id_permiso, p.nombre_permiso, pe.img_empleado
         from ps_employee e
         left join colmoda_permisos_empleados pe on (e.id_employee = pe.id_empleado)
         left join colmoda_permisos p on (pe.id_permiso = p.id_permiso)  where e.email='" . $this->codigo . "' and e.passwd=md5('" . $cookie . $this->clave . "') and e.active = 1;");
        $num_total_registros = parent::num_rows($consulta);
        if ($num_total_registros > 0) {
            $usr = "";
            if ($usuario = parent::fetch_array($consulta)) {
                $usr = $usuario["id_employee"];
                $usr.="-" . $usuario["id_profile"];
                $usr.="-" . $usuario["lastname"];
                $usr.="-" . $usuario["firstname"];
                $usr.="-" . $usuario["active"];
                $usr.="-" . $usuario["id_permiso"];
                $usr.="-" . $usuario["nombre_permiso"];
                $usr.="-" . $usuario["img_empleado"];
            }
            return $usr;
        } else {
            $usr = "No";
            return $usr;
        }
    }

    function registrarVisitante() {
        $insert = parent::registro("INSERT INTO colmoda_visita_mod_ordenes (ip_visita) values('" . $this->dirIP . "');");
        if (!$insert) {
            return "No";
        } else {
            return "Si";
        }
    }
    
    function validarTablas() {
        //$consulta = parent::consulta("select payment from ps_orders GROUP by payment;");
        $consulta = parent::consulta("select t2.TABLE_NAME nombretabla, IFNULL( t1.cant,'0') existe from information_schema.TABLES as t2
left join (select TABLE_NAME, '1' as cant from information_schema.TABLES 
where TABLE_NAME in ('".$this->nTabla."') and TABLE_SCHEMA='"._DB_NAME_."') t1
on (t2.TABLE_NAME = t1.TABLE_NAME)
where t2.TABLE_NAME in ('".$this->nTabla."') and t2.TABLE_SCHEMA='"._DB_NAME_."';");
        return $consulta;
    }

}
