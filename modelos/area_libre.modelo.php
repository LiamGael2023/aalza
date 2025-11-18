<?php
require_once "conexion.php";

class ModeloAreaLibre {
    
    /**
     * Guardar o actualizar configuración de área libre
     */
    static public function mdlGuardarConfigAreaLibre($datos) {
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe configuración
            $stmt = $db->prepare("SELECT id_config FROM area_libre_config WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // Actualizar
                $sql = "UPDATE area_libre_config SET 
                        id_piso_seleccionado = :id_piso_seleccionado,
                        area_adicional = :area_adicional,
                        nota = :nota
                        WHERE id_expediente = :id_expediente";
            } else {
                // Insertar
                $sql = "INSERT INTO area_libre_config 
                        (id_expediente, id_piso_seleccionado, area_adicional, nota) 
                        VALUES (:id_expediente, :id_piso_seleccionado, :area_adicional, :nota)";
            }
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->bindParam(":id_piso_seleccionado", $datos["id_piso_seleccionado"], PDO::PARAM_INT);
            $stmt->bindParam(":area_adicional", $datos["area_adicional"], PDO::PARAM_STR);
            $stmt->bindParam(":nota", $datos["nota"], PDO::PARAM_STR);
            
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
     * Obtener configuración de área libre
     */
    static public function mdlObtenerConfigAreaLibre($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM area_libre_config WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
}