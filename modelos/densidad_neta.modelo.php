<?php
require_once "conexion.php";

class ModeloDensidadNeta {
    
    /**
     * Guardar o actualizar densidad neta
     */
    static public function mdlGuardarDensidadNeta($datos) {
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id_densidad FROM densidad_neta WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // ACTUALIZAR
                $sql = "UPDATE densidad_neta SET 
                        coeficiente_edificacion = :coeficiente_edificacion,
                        coeficiente_normativo = :coeficiente_normativo,
                        numero_ocupantes = :numero_ocupantes,
                        densidad_proyectada = :densidad_proyectada,
                        cumple = :cumple,
                        observaciones = :observaciones,
                        updated_at = CURRENT_TIMESTAMP
                        WHERE id_expediente = :id_expediente";
                
                $stmt = $db->prepare($sql);
                $id_densidad = $existe['id_densidad'];
            } else {
                // INSERTAR
                $sql = "INSERT INTO densidad_neta 
                        (id_expediente, coeficiente_edificacion, coeficiente_normativo, 
                         numero_ocupantes, densidad_proyectada, cumple, observaciones) 
                        VALUES (:id_expediente, :coeficiente_edificacion, :coeficiente_normativo,
                                :numero_ocupantes, :densidad_proyectada, :cumple, :observaciones)";
                
                $stmt = $db->prepare($sql);
            }
            
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->bindParam(":coeficiente_edificacion", $datos["coeficiente_edificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":coeficiente_normativo", $datos["coeficiente_normativo"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_ocupantes", $datos["numero_ocupantes"], PDO::PARAM_INT);
            $stmt->bindParam(":densidad_proyectada", $datos["densidad_proyectada"], PDO::PARAM_STR);
            $stmt->bindParam(":cumple", $datos["cumple"], PDO::PARAM_INT);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                // Obtener ID de densidad
                if (!$existe) {
                    $id_densidad = $db->lastInsertId();
                }
                
                // Eliminar viviendas anteriores
                $stmt = $db->prepare("DELETE FROM densidad_viviendas WHERE id_densidad = :id_densidad");
                $stmt->bindParam(":id_densidad", $id_densidad, PDO::PARAM_INT);
                $stmt->execute();
                
                // Insertar nuevas viviendas
                if (!empty($datos["viviendas"])) {
                    $sql = "INSERT INTO densidad_viviendas 
                            (id_densidad, num_dormitorios, num_personas, num_unidades, total_ocupantes) 
                            VALUES (:id_densidad, :num_dormitorios, :num_personas, :num_unidades, :total_ocupantes)";
                    
                    foreach ($datos["viviendas"] as $vivienda) {
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(":id_densidad", $id_densidad, PDO::PARAM_INT);
                        $stmt->bindParam(":num_dormitorios", $vivienda["num_dormitorios"], PDO::PARAM_INT);
                        $stmt->bindParam(":num_personas", $vivienda["num_personas"], PDO::PARAM_INT);
                        $stmt->bindParam(":num_unidades", $vivienda["num_unidades"], PDO::PARAM_INT);
                        $stmt->bindParam(":total_ocupantes", $vivienda["total_ocupantes"], PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
                
                return "ok";
            } else {
                return "error";
            }
            
        } catch (Exception $e) {
            return "error: " . $e->getMessage();
        }
    }
    
    /**
     * Mostrar densidad neta
     */
    static public function mdlMostrarDensidadNeta($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM densidad_neta WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Mostrar viviendas de una densidad
     */
    static public function mdlMostrarViviendas($id_densidad) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM densidad_viviendas 
                                  WHERE id_densidad = :id_densidad 
                                  ORDER BY num_dormitorios ASC");
            $stmt->bindParam(":id_densidad", $id_densidad, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Eliminar densidad neta
     */
    static public function mdlEliminarDensidadNeta($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM densidad_neta WHERE id_expediente = :id_expediente");
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