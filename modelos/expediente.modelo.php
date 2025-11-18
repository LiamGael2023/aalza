<?php
require_once "conexion.php";

class ModeloExpediente {
    
    static public function MdlMostrarExpediente($tabla, $item, $valor) {
        $conn = Conexion::conectar();
        try {
            if ($item != null) {
                $sql = "SELECT * FROM $tabla WHERE $item = :valor";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql = "SELECT * FROM $tabla ORDER BY id_expediente DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $result ?: [];
        } catch (PDOException $e) {
            error_log("Error en MdlMostrarExpediente: " . $e->getMessage());
            return [];
        }
    }
    
    static public function mdlCrearExpediente($tabla, $datos) {
    $conn = Conexion::conectar();
    try {
        $sql = "INSERT INTO $tabla (
            numero_expediente, propietario, copropietario, zonificacion, ubicacion,
            estructura_urbana, partida_electronica, area_terreno, frente, derecha, 
            izquierda, fondo
        ) VALUES (
            :numero_expediente, :propietario, :copropietario, :zonificacion, :ubicacion,
            :estructura_urbana, :partida_electronica, :area_terreno, :frente, :derecha,
            :izquierda, :fondo
        )";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(":numero_expediente", $datos["numero_expediente"], PDO::PARAM_STR);
        $stmt->bindParam(":propietario", $datos["propietario"], PDO::PARAM_STR);
        $stmt->bindParam(":copropietario", $datos["copropietario"], PDO::PARAM_STR);
        $stmt->bindParam(":zonificacion", $datos["zonificacion"], PDO::PARAM_STR);
        $stmt->bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":estructura_urbana", $datos["estructura_urbana"], PDO::PARAM_STR);
        $stmt->bindParam(":partida_electronica", $datos["partida_electronica"], PDO::PARAM_STR);
        $stmt->bindParam(":area_terreno", $datos["area_terreno"], PDO::PARAM_STR);
        $stmt->bindParam(":frente", $datos["frente"], PDO::PARAM_STR);
        $stmt->bindParam(":derecha", $datos["derecha"], PDO::PARAM_STR);
        $stmt->bindParam(":izquierda", $datos["izquierda"], PDO::PARAM_STR);
        $stmt->bindParam(":fondo", $datos["fondo"], PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    } catch (PDOException $e) {
        error_log("Error en mdlCrearExpediente: " . $e->getMessage());
        return $e->getMessage();
    }
}

static public function mdlEditarExpediente($tabla, $datos) {
    $conn = Conexion::conectar();
    try {
        $sql = "UPDATE $tabla SET
            propietario = :propietario,
            copropietario = :copropietario,
            zonificacion = :zonificacion,
            ubicacion = :ubicacion,
            estructura_urbana = :estructura_urbana,
            partida_electronica = :partida_electronica,
            area_terreno = :area_terreno,
            frente = :frente,
            derecha = :derecha,
            izquierda = :izquierda,
            fondo = :fondo
        WHERE id_expediente = :id_expediente";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
        $stmt->bindParam(":propietario", $datos["propietario"], PDO::PARAM_STR);
        $stmt->bindParam(":copropietario", $datos["copropietario"], PDO::PARAM_STR);
        $stmt->bindParam(":zonificacion", $datos["zonificacion"], PDO::PARAM_STR);
        $stmt->bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":estructura_urbana", $datos["estructura_urbana"], PDO::PARAM_STR);
        $stmt->bindParam(":partida_electronica", $datos["partida_electronica"], PDO::PARAM_STR);
        $stmt->bindParam(":area_terreno", $datos["area_terreno"], PDO::PARAM_STR);
        $stmt->bindParam(":frente", $datos["frente"], PDO::PARAM_STR);
        $stmt->bindParam(":derecha", $datos["derecha"], PDO::PARAM_STR);
        $stmt->bindParam(":izquierda", $datos["izquierda"], PDO::PARAM_STR);
        $stmt->bindParam(":fondo", $datos["fondo"], PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    } catch (PDOException $e) {
        error_log("Error en mdlEditarExpediente: " . $e->getMessage());
        return "error: " . $e->getMessage();
    }
}
    
    static public function mdlEliminarExpediente($tabla, $id) {
        $conn = Conexion::conectar();
        try {
            $sql = "DELETE FROM $tabla WHERE id_expediente = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        } catch (PDOException $e) {
            error_log("Error en mdlEliminarExpediente: " . $e->getMessage());
            return "error";
        }
    }
    
    static public function mdlObtenerUltimoNumero($tabla) {
        $conn = Conexion::conectar();
        try {
            $sql = "SELECT numero_expediente FROM $tabla 
                    WHERE numero_expediente IS NOT NULL 
                    AND numero_expediente LIKE 'PRECAL-%' 
                    ORDER BY id_expediente DESC 
                    LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en mdlObtenerUltimoNumero: " . $e->getMessage());
            return null;
        }
    }
}