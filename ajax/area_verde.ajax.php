<?php
require_once "../modelos/conexion.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        $id_expediente = $_POST["id_expediente"];
        $cantidad_personas = $_POST["cantidad_personas"];
        $m2_por_persona = $_POST["m2_por_persona"];
        $area_verde_normativa = $_POST["area_verde_normativa"];
        $area_verde_proyectada = $_POST["area_verde_proyectada"];
        $cumple = $_POST["cumple"];
        $observaciones = $_POST["observaciones"];
        
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id FROM area_verde WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // Actualizar
                $stmt = $db->prepare("UPDATE area_verde SET 
                    cantidad_personas = :cantidad_personas,
                    m2_por_persona = :m2_por_persona,
                    area_verde_normativa = :area_verde_normativa,
                    area_verde_proyectada = :area_verde_proyectada,
                    cumple = :cumple,
                    observaciones = :observaciones,
                    updated_at = CURRENT_TIMESTAMP
                    WHERE id_expediente = :id_expediente");
            } else {
                // Insertar
                $stmt = $db->prepare("INSERT INTO area_verde 
                    (id_expediente, cantidad_personas, m2_por_persona, area_verde_normativa, area_verde_proyectada, cumple, observaciones) 
                    VALUES (:id_expediente, :cantidad_personas, :m2_por_persona, :area_verde_normativa, :area_verde_proyectada, :cumple, :observaciones)");
            }
            
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->bindParam(":cantidad_personas", $cantidad_personas, PDO::PARAM_INT);
            $stmt->bindParam(":m2_por_persona", $m2_por_persona, PDO::PARAM_STR);
            $stmt->bindParam(":area_verde_normativa", $area_verde_normativa, PDO::PARAM_STR);
            $stmt->bindParam(":area_verde_proyectada", $area_verde_proyectada, PDO::PARAM_STR);
            $stmt->bindParam(":cumple", $cumple, PDO::PARAM_INT);
            $stmt->bindParam(":observaciones", $observaciones, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Área verde guardada correctamente",
                    "cumple" => intval($cumple)
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error al guardar"
                ]);
            }
            
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
    
    if ($_POST["accion"] == "mostrar") {
        $id_expediente = $_POST["id_expediente"];
        
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM area_verde WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            $areaVerde = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($areaVerde ? $areaVerde : null);
            
        } catch (Exception $e) {
            echo json_encode(null);
        }
    }
    
    if ($_POST["accion"] == "eliminar") {
        $id_expediente = $_POST["id_expediente"];
        
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM area_verde WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Área verde eliminada correctamente"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error al eliminar"
                ]);
            }
            
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>