<?php
require_once "conexion.php";

class ModeloAlineamientoFachada {
    
    /**
     * Guardar o actualizar alineamiento de fachada
     */
    static public function mdlGuardarAlineamientoFachada($datos) {
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id_alineamiento FROM alineamiento_fachada WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // ACTUALIZAR
                $sql = "UPDATE alineamiento_fachada SET 
                        alineamiento_normativo = :alineamiento_normativo,
                        alineamiento_proyectado = :alineamiento_proyectado,
                        cumple = :cumple,
                        observaciones = :observaciones,
                        updated_at = CURRENT_TIMESTAMP
                        WHERE id_expediente = :id_expediente";
            } else {
                // INSERTAR
                $sql = "INSERT INTO alineamiento_fachada 
                        (id_expediente, alineamiento_normativo, alineamiento_proyectado, cumple, observaciones) 
                        VALUES (:id_expediente, :alineamiento_normativo, :alineamiento_proyectado, :cumple, :observaciones)";
            }
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->bindParam(":alineamiento_normativo", $datos["alineamiento_normativo"], PDO::PARAM_STR);
            $stmt->bindParam(":alineamiento_proyectado", $datos["alineamiento_proyectado"], PDO::PARAM_STR);
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
     * Mostrar alineamiento de fachada
     */
    static public function mdlMostrarAlineamientoFachada($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM alineamiento_fachada WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Eliminar alineamiento de fachada
     */
    static public function mdlEliminarAlineamientoFachada($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM alineamiento_fachada WHERE id_expediente = :id_expediente");
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