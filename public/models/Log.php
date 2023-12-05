<?php


class Log {

    public $id;
    public $usuario;
    public $fecha;
    public $metodo;
    public $url;
    
    public function __construct() {

    }

    public function crearUno() {

        $fechaActual = date('Y-m-d H:i:s');
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO logs (usuario, fecha, metodo, url) VALUES (:usuario, :fecha, :metodo, :url)");
        $consulta -> bindParam(':usuario', $this->usuario);
        $consulta -> bindParam(':fecha', $fechaActual);
        $consulta -> bindParam(':metodo', $this->metodo);
        $consulta -> bindParam(':url', $this->url);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM logs;");
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Log');
    }

}
?>

