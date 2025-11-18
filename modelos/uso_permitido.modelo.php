<?php
require_once "conexion.php";

class ModeloUsoPermitido {
    
    /**
     * Guardar o actualizar uso permitido
     */
    static public function mdlGuardarUsoPermitido($datos) {
        try {
            $db = Conexion::conectar();
            
            // Verificar si cumple (si los usos son iguales)
            $cumple = ($datos["uso_normativo"] === $datos["uso_proyecto"]) ? 1 : 0;
            
            // Verificar si ya existe un registro para este expediente
            $stmt = $db->prepare("SELECT id_uso FROM usos_permitidos WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // ACTUALIZAR registro existente
                $sql = "UPDATE usos_permitidos SET 
                        uso_normativo = :uso_normativo,
                        uso_proyecto = :uso_proyecto,
                        cumple = :cumple,
                        observaciones = :observaciones,
                        updated_at = CURRENT_TIMESTAMP
                        WHERE id_expediente = :id_expediente";
            } else {
                // INSERTAR nuevo registro
                $sql = "INSERT INTO usos_permitidos 
                        (id_expediente, uso_normativo, uso_proyecto, cumple, observaciones) 
                        VALUES (:id_expediente, :uso_normativo, :uso_proyecto, :cumple, :observaciones)";
            }
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->bindParam(":uso_normativo", $datos["uso_normativo"], PDO::PARAM_STR);
            $stmt->bindParam(":uso_proyecto", $datos["uso_proyecto"], PDO::PARAM_STR);
            $stmt->bindParam(":cumple", $cumple, PDO::PARAM_INT);
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
     * Mostrar uso permitido de un expediente (solo uno)
     */
    static public function mdlMostrarUsoPermitido($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM usos_permitidos 
                                  WHERE id_expediente = :id_expediente 
                                  LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Eliminar uso permitido
     */
    static public function mdlEliminarUsoPermitido($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM usos_permitidos WHERE id_expediente = :id_expediente");
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