<?php
require_once "conexion.php";

class ModeloCoeficienteEdificacion {
    
    /**
     * Guardar o actualizar coeficiente de edificación
     */
    static public function mdlGuardarCoeficienteEdificacion($datos) {
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id_coef_edificacion FROM coeficiente_edificacion WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // ACTUALIZAR
                $sql = "UPDATE coeficiente_edificacion SET 
                        coef_normativo = :coef_normativo,
                        es_libre = :es_libre,
                        dscto_area_coef = :dscto_area_coef,
                        area_techada_total = :area_techada_total,
                        coef_proyectado = :coef_proyectado,
                        cumple = :cumple,
                        observaciones = :observaciones,
                        updated_at = CURRENT_TIMESTAMP
                        WHERE id_expediente = :id_expediente";
            } else {
                // INSERTAR
                $sql = "INSERT INTO coeficiente_edificacion 
                        (id_expediente, coef_normativo, es_libre, dscto_area_coef, 
                         area_techada_total, coef_proyectado, cumple, observaciones) 
                        VALUES (:id_expediente, :coef_normativo, :es_libre, :dscto_area_coef,
                                :area_techada_total, :coef_proyectado, :cumple, :observaciones)";
            }
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->bindParam(":coef_normativo", $datos["coef_normativo"], PDO::PARAM_STR);
            $stmt->bindParam(":es_libre", $datos["es_libre"], PDO::PARAM_INT);
            $stmt->bindParam(":dscto_area_coef", $datos["dscto_area_coef"], PDO::PARAM_STR);
            $stmt->bindParam(":area_techada_total", $datos["area_techada_total"], PDO::PARAM_STR);
            $stmt->bindParam(":coef_proyectado", $datos["coef_proyectado"], PDO::PARAM_STR);
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
     * Mostrar coeficiente de edificación
     */
    static public function mdlMostrarCoeficienteEdificacion($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM coeficiente_edificacion WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Eliminar coeficiente de edificación
     */
    static public function mdlEliminarCoeficienteEdificacion($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM coeficiente_edificacion WHERE id_expediente = :id_expediente");
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