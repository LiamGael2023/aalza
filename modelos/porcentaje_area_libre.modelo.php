<?php
require_once "conexion.php";

class ModeloPorcentajeAreaLibre {
    
    /**
     * Guardar o actualizar porcentaje de área libre
     */
    static public function mdlGuardarPorcentajeAreaLibre($datos) {
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id_porcentaje_area FROM porcentaje_area_libre WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // ACTUALIZAR
                $sql = "UPDATE porcentaje_area_libre SET 
                        porcentaje_necesario = :porcentaje_necesario,
                        criterio_seleccionado = :criterio_seleccionado,
                        area_libre = :area_libre,
                        area_terreno = :area_terreno,
                        porcentaje_proyectado = :porcentaje_proyectado,
                        cumple = :cumple,
                        observaciones = :observaciones,
                        updated_at = CURRENT_TIMESTAMP
                        WHERE id_expediente = :id_expediente";
            } else {
                // INSERTAR
                $sql = "INSERT INTO porcentaje_area_libre 
                        (id_expediente, porcentaje_necesario, criterio_seleccionado, area_libre, 
                         area_terreno, porcentaje_proyectado, cumple, observaciones) 
                        VALUES (:id_expediente, :porcentaje_necesario, :criterio_seleccionado, :area_libre,
                                :area_terreno, :porcentaje_proyectado, :cumple, :observaciones)";
            }
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->bindParam(":porcentaje_necesario", $datos["porcentaje_necesario"], PDO::PARAM_STR);
            $stmt->bindParam(":criterio_seleccionado", $datos["criterio_seleccionado"], PDO::PARAM_STR);
            $stmt->bindParam(":area_libre", $datos["area_libre"], PDO::PARAM_STR);
            $stmt->bindParam(":area_terreno", $datos["area_terreno"], PDO::PARAM_STR);
            $stmt->bindParam(":porcentaje_proyectado", $datos["porcentaje_proyectado"], PDO::PARAM_STR);
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
     * Mostrar porcentaje de área libre
     */
    static public function mdlMostrarPorcentajeAreaLibre($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM porcentaje_area_libre WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Eliminar porcentaje de área libre
     */
    static public function mdlEliminarPorcentajeAreaLibre($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM porcentaje_area_libre WHERE id_expediente = :id_expediente");
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