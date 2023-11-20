<?php
class Encuesta
{

    public $id;
    public $notaMozo;
    public $notaCocina;
    public $notaMesa;
    public $notaRestaurante;
    public $resena;
    public $codigoPedido;

    public function cargarUno()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO encuestas (notaMozo, notaCocina, notaMesa, notaRestaurante, resena, codigoPedido) VALUES (:notaMozo, :notaCocina, :notaMesa, :notaRestaurante, :resena, :codigoPedido)");

        $consulta->bindValue(':notaMozo', $this->notaMozo, PDO::PARAM_INT);
        $consulta->bindValue(':notaCocina', $this->notaCocina, PDO::PARAM_INT);
        $consulta->bindValue(':notaMesa', $this->notaMesa, PDO::PARAM_INT);
        $consulta->bindValue(':notaRestaurante', $this->notaRestaurante, PDO::PARAM_INT);
        $consulta->bindValue(':resena', $this->resena, PDO::PARAM_STR);
        $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);

        $consulta->execute();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, notaMozo, notaCocina, notaMesa, notaRestaurante, reseña, codigoPedido FROM encuestas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Encuesta');
    }

    public static function obtenerEncuesta($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, notaMozo, notaCocina, notaMesa, notaRestaurante, reseña, codigoPedido FROM encuestas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Encuesta');
    }
}
