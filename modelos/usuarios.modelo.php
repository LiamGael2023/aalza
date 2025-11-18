<?php

require_once "conexion.php";

class ModeloUsuarios {

    /*=============================================
    MOSTRAR USUARIOS
    =============================================*/
    static public function mdlMostrarUsuarios($tabla, $item, $valor) {

        $stmt = null;
        $link = Conexion::conectar();

        if ($item != null) {
            $stmt = $link->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":$item", $valor, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $link->prepare("SELECT * FROM $tabla");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $stmt = null; // Cierra conexión
    }

    /*=============================================
    ACTUALIZAR USUARIO
    =============================================*/
    static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2) {

        $link = Conexion::conectar();
        $stmt = $link->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":$item1", $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":$item2", $valor2, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null;
    }
}
