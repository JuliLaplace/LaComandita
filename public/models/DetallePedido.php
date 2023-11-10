<?php 
class DetallePedido{

    public $id;
    public $codigoPedido;
    public $idProducto;
    public $tiempoCalculado;
    public $estado;

    public function __construct() {}

    public function crearDetalleProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO detallepedido (codigopedido, idproducto, tiempocalculado, estado) VALUES (:codigopedido, :idproducto, :tiempocalculado, :estado)");
        
        $consulta->bindValue(':codigopedido', $this->codigoPedido, PDO::PARAM_STR);
        $consulta->bindValue(':tiempocalculado', $this->tiempoCalculado, PDO::PARAM_INT);
        $consulta->bindValue(':idproducto', $this->idProducto, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);

    
        $consulta->execute();
     
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM detallepedido");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'DetallePedido');

    }


}


?>