<?php
require_once "../modelos/conexion.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
    $id_expediente = $_POST["id_expediente"];
    $usos_agregados = $_POST["usos_agregados"]; // NUEVO
    $datos_normativos = $_POST["datos_normativos"];
    $datos_proyectados = $_POST["datos_proyectados"];
    $total_normativo = $_POST["total_normativo"];
    $total_proyectado = $_POST["total_proyectado"];
    $cumple = $_POST["cumple"];
    $observaciones = $_POST["observaciones"];
    
    try {
        $db = Conexion::conectar();
        
        // Verificar si ya existe
        $stmt = $db->prepare("SELECT id FROM estacionamiento WHERE id_expediente = :id_expediente");
        $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
        $stmt->execute();
        $existe = $stmt->fetch();
        
        if ($existe) {
            // Actualizar
            $stmt = $db->prepare("UPDATE estacionamiento SET 
                usos_agregados = :usos_agregados,
                datos_normativos = :datos_normativos,
                datos_proyectados = :datos_proyectados,
                total_normativo = :total_normativo,
                total_proyectado = :total_proyectado,
                cumple = :cumple,
                observaciones = :observaciones,
                updated_at = CURRENT_TIMESTAMP
                WHERE id_expediente = :id_expediente");
        } else {
            // Insertar
            $stmt = $db->prepare("INSERT INTO estacionamiento 
                (id_expediente, usos_agregados, datos_normativos, datos_proyectados, total_normativo, total_proyectado, cumple, observaciones) 
                VALUES (:id_expediente, :usos_agregados, :datos_normativos, :datos_proyectados, :total_normativo, :total_proyectado, :cumple, :observaciones)");
        }
        
        $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
        $stmt->bindParam(":usos_agregados", $usos_agregados, PDO::PARAM_STR);
        $stmt->bindParam(":datos_normativos", $datos_normativos, PDO::PARAM_STR);
        $stmt->bindParam(":datos_proyectados", $datos_proyectados, PDO::PARAM_STR);
        $stmt->bindParam(":total_normativo", $total_normativo, PDO::PARAM_INT);
        $stmt->bindParam(":total_proyectado", $total_proyectado, PDO::PARAM_INT);
        $stmt->bindParam(":cumple", $cumple, PDO::PARAM_INT);
        $stmt->bindParam(":observaciones", $observaciones, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Estacionamiento guardado correctamente",
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
            $stmt = $db->prepare("SELECT * FROM estacionamiento WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            $estacionamiento = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($estacionamiento ? $estacionamiento : null);
            
        } catch (Exception $e) {
            echo json_encode(null);
        }
    }
    
    if ($_POST["accion"] == "eliminar") {
        $id_expediente = $_POST["id_expediente"];
        
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM estacionamiento WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Estacionamiento eliminado correctamente"
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