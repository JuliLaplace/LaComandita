<?php
    class Cliente{

        public $idCliente;
        public $nombre;
        
        public static function TraerTiempoPedido($codigo){
            
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(tiempocalculado) AS tiempocalculado_maximo FROM detallepedido WHERE codigopedido = :codigo");
            $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            $consulta->execute();
    
            return $consulta->fetchColumn();

        }
    }

    
?>