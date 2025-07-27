<?php
require_once(__DIR__ . '/../models/Categoria.php');


class CategoriaController {
    public function obtenerHijas() {
        $idPadre = $_GET['id_padre'] ?? null;

        if ($idPadre === null) {
            echo json_encode([]);
            return;
        }

        $categoriaModel = new Categoria();
        $hijas = $categoriaModel->obtenerHijas($idPadre);

        header('Content-Type: application/json');
        echo json_encode($hijas);
    }
}
