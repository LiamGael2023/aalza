<?php
require_once "conexion.php";

class ModeloRetiroMinimo {
    
    /**
     * Guardar o actualizar retiro mínimo
     */
    static public function mdlGuardarRetiroMinimo($datos) {
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id_retiro FROM retiro_minimo WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // ACTUALIZAR
                $sql = "UPDATE retiro_minimo SET 
                        frontal_normativo = :frontal_normativo,
                        frontal_normativo_valor = :frontal_normativo_valor,
                        frontal_normativo_nota = :frontal_normativo_nota,
                        frontal_proyectado = :frontal_proyectado,
                        frontal_cumple = :frontal_cumple,
                        lateral_normativo = :lateral_normativo,
                        lateral_normativo_valor = :lateral_normativo_valor,
                        lateral_normativo_nota = :lateral_normativo_nota,
                        lateral_proyectado = :lateral_proyectado,
                        lateral_cumple = :lateral_cumple,
                        posterior_normativo = :posterior_normativo,
                        posterior_normativo_valor = :posterior_normativo_valor,
                        posterior_normativo_nota = :posterior_normativo_nota,
                        posterior_proyectado = :posterior_proyectado,
                        posterior_cumple = :posterior_cumple,
                        cumple_general = :cumple_general,
                        observaciones = :observaciones,
                        updated_at = CURRENT_TIMESTAMP
                        WHERE id_expediente = :id_expediente";
            } else {
                // INSERTAR
                $sql = "INSERT INTO retiro_minimo 
                        (id_expediente, frontal_normativo, frontal_normativo_valor, frontal_normativo_nota, frontal_proyectado, frontal_cumple,
                         lateral_normativo, lateral_normativo_valor, lateral_normativo_nota, lateral_proyectado, lateral_cumple,
                         posterior_normativo, posterior_normativo_valor, posterior_normativo_nota, posterior_proyectado, posterior_cumple,
                         cumple_general, observaciones) 
                        VALUES (:id_expediente, :frontal_normativo, :frontal_normativo_valor, :frontal_normativo_nota, :frontal_proyectado, :frontal_cumple,
                                :lateral_normativo, :lateral_normativo_valor, :lateral_normativo_nota, :lateral_proyectado, :lateral_cumple,
                                :posterior_normativo, :posterior_normativo_valor, :posterior_normativo_nota, :posterior_proyectado, :posterior_cumple,
                                :cumple_general, :observaciones)";
            }
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->bindParam(":frontal_normativo", $datos["frontal_normativo"], PDO::PARAM_STR);
            $stmt->bindParam(":frontal_normativo_valor", $datos["frontal_normativo_valor"], PDO::PARAM_STR);
            $stmt->bindParam(":frontal_normativo_nota", $datos["frontal_normativo_nota"], PDO::PARAM_STR);
            $stmt->bindParam(":frontal_proyectado", $datos["frontal_proyectado"], PDO::PARAM_STR);
            $stmt->bindParam(":frontal_cumple", $datos["frontal_cumple"], PDO::PARAM_INT);
            $stmt->bindParam(":lateral_normativo", $datos["lateral_normativo"], PDO::PARAM_STR);
            $stmt->bindParam(":lateral_normativo_valor", $datos["lateral_normativo_valor"], PDO::PARAM_STR);
            $stmt->bindParam(":lateral_normativo_nota", $datos["lateral_normativo_nota"], PDO::PARAM_STR);
            $stmt->bindParam(":lateral_proyectado", $datos["lateral_proyectado"], PDO::PARAM_STR);
            $stmt->bindParam(":lateral_cumple", $datos["lateral_cumple"], PDO::PARAM_INT);
            $stmt->bindParam(":posterior_normativo", $datos["posterior_normativo"], PDO::PARAM_STR);
            $stmt->bindParam(":posterior_normativo_valor", $datos["posterior_normativo_valor"], PDO::PARAM_STR);
            $stmt->bindParam(":posterior_normativo_nota", $datos["posterior_normativo_nota"], PDO::PARAM_STR);
            $stmt->bindParam(":posterior_proyectado", $datos["posterior_proyectado"], PDO::PARAM_STR);
            $stmt->bindParam(":posterior_cumple", $datos["posterior_cumple"], PDO::PARAM_INT);
            $stmt->bindParam(":cumple_general", $datos["cumple_general"], PDO::PARAM_INT);
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
     * Mostrar retiro mínimo
     */
    static public function mdlMostrarRetiroMinimo($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM retiro_minimo WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Eliminar retiro mínimo
     */
    static public function mdlEliminarRetiroMinimo($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM retiro_minimo WHERE id_expediente = :id_expediente");
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