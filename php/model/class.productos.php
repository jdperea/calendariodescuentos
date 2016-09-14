<?php

class productos extends MySQL {

    var $price_iva_inc = "";

    function updateInventarioProductos() {
        $insert = parent::registro("UPDATE ps_stock_available as pa, (
                select i.id_producto,i.total from ps_stock_available as s
                inner join producto_ps_mex as i on i.id_producto=s.id_product_attribute
                where s.id_product_attribute!=0 and i.id_referencia = " . $this->id_referencia . ") as sf
                SET pa.quantity = sf.total
                where pa.id_product_attribute=sf.id_producto;");
        if (!$insert) {
            return "No";
        } else {
            return "Si";
        }
    }

    function registrarProducto() {
        $insert = parent::registro("INSERT INTO productos_mex (`id_referencia`, `referencia`, `cant_xs`, `cant_s`, `cant_m`, `cant_l`, `cant_xl`, `cant_2xl`, `cant_3xl`, `cant_4xl`, `price_iva_inc`, `price_iva_excl`, `tasa_iva`) VALUES (" . $this->id_referencia_nueva . ", '" . $this->referencia_nueva . "', 0, 0, 0, 0, 0, 0, 0, 0, 10000, 10000, 0.16);");
        if (!$insert) {
            return "No";
        } else {
            return "Si";
        }
    }
    
    function getProductos(){
        $consulta = parent::consulta("SELECT p.id_producto_referencia as id_referencia, p.referencia FROM referencia_con_id p where p.referencia like '%".$this->referencia."%' and p.id_producto_referencia not in (select pm.id_referencia from productos_mex pm)");
        return $consulta;
    }
    function getDescuentosProductos(){
        $consulta = parent::consulta("SELECT pc.referencia,pc.fecha_lanzamiento, pc.diferenciasemanas, 
                pc.id_categoria, ifnull(d.linea,d1.linea)
                FROM producto_coleccion pc
                left JOIN calendario_categoria cc ON  (pc.diferenciasemanas BETWEEN 0 AND cc.linea AND (cc.id_categoria = IFNULL(pc.id_categoria,1)))
                left JOIN descuentos d on (pc.id_categoria = d.categoria)
                left JOIN descuentos d1 on (d1.categoria = 1)");
        return $consulta;
    }

}

?>