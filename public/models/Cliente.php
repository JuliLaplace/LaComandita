<?php
    class Cliente{

        public $idCliente;
        public $nombre;

        public static function TraerTiempoPedido($codigoPedido, $codigoMesa)
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();


            $consultaPedido = $objAccesoDatos->prepararConsulta("SELECT tiempoEstimado FROM pedidos WHERE codigoPedido = :codigoPedido AND codigoMesa = :codigoMesa AND fechaBaja IS NULL");
            $consultaPedido->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_STR);
            $consultaPedido->bindValue(':codigoMesa', $codigoMesa, PDO::PARAM_STR);
            $consultaPedido->execute();


            $tiempoEstimado = $consultaPedido->fetchColumn();
            

            return $tiempoEstimado !== false ? $tiempoEstimado : null;
        }
    }

    
?>