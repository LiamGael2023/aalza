<?php
require_once "conexion.php";

class ModeloPiso {
    
    /**
     * Guardar pisos de un expediente
     */
    static public function mdlGuardarPisos($datos) {
        try {
            $db = Conexion::conectar();
            $db->beginTransaction();
            
            // 1. Eliminar pisos anteriores del expediente
            $stmt = $db->prepare("DELETE FROM pisos WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $datos["id_expediente"], PDO::PARAM_INT);
            $stmt->execute();
            
            // 2. Preparar la inserción
            $sql = "INSERT INTO pisos (id_expediente, tipo_nivel, numero_nivel, nombre_nivel, orden) 
                    VALUES (:id_expediente, :tipo_nivel, :numero_nivel, :nombre_nivel, :orden)";
            $stmt = $db->prepare($sql);
            
            $orden = 0;
            
            // 3. Insertar sótanos (orden negativo, de más profundo a menos profundo)
            if (!empty($datos["sotanos"])) {
                // Ordenar sótanos de 3 a 1
                usort($datos["sotanos"], function($a, $b) {
                    return strcmp($b, $a); // Orden descendente
                });
                
                foreach ($datos["sotanos"] as $sotano) {
                    $numero = null;
                    if (preg_match('/\d+/', $sotano, $matches)) {
                        $numero = (int)$matches[0];
                    }
                    
                    $stmt->execute([
                        ":id_expediente" => $datos["id_expediente"],
                        ":tipo_nivel" => "sotano",
                        ":numero_nivel" => $numero,
                        ":nombre_nivel" => $sotano,
                        ":orden" => $orden++
                    ]);
                }
            }
            
            // 4. Insertar pisos (orden positivo)
            if (!empty($datos["pisos"])) {
                foreach ($datos["pisos"] as $piso) {
                    $numero = null;
                    if (preg_match('/\d+/', $piso, $matches)) {
                        $numero = (int)$matches[0];
                    }
                    
                    $stmt->execute([
                        ":id_expediente" => $datos["id_expediente"],
                        ":tipo_nivel" => "piso",
                        ":numero_nivel" => $numero,
                        ":nombre_nivel" => $piso,
                        ":orden" => $orden++
                    ]);
                }
            }
            
            // 5. Insertar azotea (último orden)
            if (!empty($datos["azotea"])) {
                $stmt->execute([
                    ":id_expediente" => $datos["id_expediente"],
                    ":tipo_nivel" => "azotea",
                    ":numero_nivel" => null,
                    ":nombre_nivel" => $datos["azotea"],
                    ":orden" => $orden++
                ]);
            }
            
            $db->commit();
            return "ok";
            
        } catch (Exception $e) {
            if (isset($db)) {
                $db->rollBack();
            }
            return "error: " . $e->getMessage();
        }
    }
    
    static public function mdlActualizarAreasPiso($datos) {
    try {
        $db = Conexion::conectar();
        $sql = "UPDATE pisos SET 
                area_nueva = :area_nueva,
                area_existente = :area_existente,
                area_demolicion = :area_demolicion,
                area_ampliacion = :area_ampliacion,
                area_remodelacion = :area_remodelacion
                WHERE id_piso = :id_piso";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":area_nueva", $datos["area_nueva"], PDO::PARAM_STR);
        $stmt->bindParam(":area_existente", $datos["area_existente"], PDO::PARAM_STR);
        $stmt->bindParam(":area_demolicion", $datos["area_demolicion"], PDO::PARAM_STR);
        $stmt->bindParam(":area_ampliacion", $datos["area_ampliacion"], PDO::PARAM_STR);
        $stmt->bindParam(":area_remodelacion", $datos["area_remodelacion"], PDO::PARAM_STR);
        $stmt->bindParam(":id_piso", $datos["id_piso"], PDO::PARAM_INT);
        
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
     * Mostrar pisos de un expediente
     */
    /**
 * Mostrar pisos de un expediente
 */
static public function mdlMostrarPisos($id_expediente) {
    try {
        $db = Conexion::conectar();
        
        $stmt = $db->prepare("SELECT * FROM pisos WHERE id_expediente = :id_expediente ORDER BY orden ASC");
        $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Asegurar que siempre devuelva un array
        return $resultado ? $resultado : [];
        
    } catch (Exception $e) {
        error_log("Error en mdlMostrarPisos: " . $e->getMessage());
        return [];
    }
}
    
    /**
     * Eliminar pisos de un expediente
     */
    static public function mdlEliminarPisos($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM pisos WHERE id_expediente = :id_expediente");
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
    
    /**
     * Contar pisos por tipo
     */
    static public function mdlContarPisosPorTipo($id_expediente) {
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT tipo_nivel, COUNT(*) as total 
                                  FROM pisos 
                                  WHERE id_expediente = :id_expediente 
                                  GROUP BY tipo_nivel");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            $resultado = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultado[$row['tipo_nivel']] = $row['total'];
            }
            
            return $resultado;
            
        } catch (Exception $e) {
            return [];
        }
    }
    
    static public function mdlListarPisos($id_expediente) {
    try {
        $db = Conexion::conectar();
        $stmt = $db->prepare("SELECT * FROM pisos WHERE id_expediente = :id_expediente ORDER BY orden_piso");
        $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        return [];
    }
}
}