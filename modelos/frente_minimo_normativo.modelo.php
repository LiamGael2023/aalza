<?php
require_once "conexion.php";

class ModeloFrenteMinimoNormativo {
    
    /**
     * Guardar o actualizar frente mínimo normativo
     */
    static public function mdlGuardarFrenteMinimoNormativo($datos) {
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id_frente_minimo FROM frente_minimo_normativo WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // ACTUALIZAR
                $sql = "UPDATE frente_minimo_normativo SET 
                        frente_normativo = :frente_normativo,
                        frente_proyectado = :frente_proyectado,
                        cumple = :cumple,
                        observaciones = :observaciones,
                        updated_at = CURRENT_TIMESTAMP
                        WHERE id_expediente = :id_expediente";
            } else {
                // INSERTAR
                $sql = "INSERT INTO frente_minimo_normativo 
                        (id_expediente, frente_normativo, frente_proyectado, cumple, observaciones) 
                        VALUES (:id_expediente, :frente_normativo, :frente_proyectado, :cumple, :observaciones)";
            }
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->bindParam(":frente_normativo", $datos["frente_normativo"], PDO::PARAM_STR);
            $stmt->bindParam(":frente_proyectado", $datos["frente_proyectado"], PDO::PARAM_STR);
            $stmt->bindParam(":cumple", $datos["cumple"], PDO::PARAM_INT);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
            
        } catch (Exception $e) {
            return "error: " . $e->getMessage();
        }
    }
    
    /**
     * Mostrar frente mínimo normativo
     */
    static public function mdlMostrarFrenteMinimoNormativo($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM frente_minimo_normativo WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Eliminar frente mínimo normativo
     */
    static public function mdlEliminarFrenteMinimoNormativo($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM frente_minimo_normativo WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
            
        } catch (Exception $e) {
            return "error: " . $e->getMessage();
        }
    }
}