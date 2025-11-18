<?php
require_once "conexion.php";

class ModeloAreaLoteNormativo {
    
    /**
     * Guardar o actualizar área de lote normativo
     */
    static public function mdlGuardarAreaLoteNormativo($datos) {
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id_area_lote FROM area_lote_normativo WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // ACTUALIZAR
                $sql = "UPDATE area_lote_normativo SET 
                        area_normativa = :area_normativa,
                        area_proyectada = :area_proyectada,
                        cumple = :cumple,
                        observaciones = :observaciones,
                        updated_at = CURRENT_TIMESTAMP
                        WHERE id_expediente = :id_expediente";
            } else {
                // INSERTAR
                $sql = "INSERT INTO area_lote_normativo 
                        (id_expediente, area_normativa, area_proyectada, cumple, observaciones) 
                        VALUES (:id_expediente, :area_normativa, :area_proyectada, :cumple, :observaciones)";
            }
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->bindParam(":area_normativa", $datos["area_normativa"], PDO::PARAM_STR);
            $stmt->bindParam(":area_proyectada", $datos["area_proyectada"], PDO::PARAM_STR);
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
     * Mostrar área de lote normativo
     */
    static public function mdlMostrarAreaLoteNormativo($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM area_lote_normativo WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Eliminar área de lote normativo
     */
    static public function mdlEliminarAreaLoteNormativo($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM area_lote_normativo WHERE id_expediente = :id_expediente");
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