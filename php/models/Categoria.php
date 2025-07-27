<?php
require_once 'conexion.php';

class Categoria {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    public function obtenerCategoriasPadre() {
        $sql = "SELECT * FROM categorias WHERE id_padre IS NULL";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerHijas($idPadre) {
    $sql = "SELECT * FROM categorias WHERE id_padre = :idPadre";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':idPadre', $idPadre, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
