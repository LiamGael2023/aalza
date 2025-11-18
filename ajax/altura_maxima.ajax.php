<?php
require_once "../modelos/conexion.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        $id_expediente = $_POST["id_expediente"];
        $tipo_altura = $_POST["tipo_altura"];
        $ancho_via = $_POST["ancho_via"];
        $retiro = $_POST["retiro"];
        $altura_normativa = $_POST["altura_normativa"];
        $altura_proyectada = $_POST["altura_proyectada"];
        $cumple = $_POST["cumple"];
        $observaciones = $_POST["observaciones"];
        
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id FROM altura_maxima WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // Actualizar
                $stmt = $db->prepare("UPDATE altura_maxima SET 
                    tipo_altura = :tipo_altura,
                    ancho_via = :ancho_via,
                    retiro = :retiro,
                    altura_normativa = :altura_normativa,
                    altura_proyectada = :altura_proyectada,
                    cumple = :cumple,
                    observaciones = :observaciones,
                    updated_at = CURRENT_TIMESTAMP
                    WHERE id_expediente = :id_expediente");
            } else {
                // Insertar
                $stmt = $db->prepare("INSERT INTO altura_maxima 
                    (id_expediente, tipo_altura, ancho_via, retiro, altura_normativa, altura_proyectada, cumple, observaciones) 
                    VALUES (:id_expediente, :tipo_altura, :ancho_via, :retiro, :altura_normativa, :altura_proyectada, :cumple, :observaciones)");
            }
            
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->bindParam(":tipo_altura", $tipo_altura, PDO::PARAM_STR);
            $stmt->bindParam(":ancho_via", $ancho_via, PDO::PARAM_STR);
            $stmt->bindParam(":retiro", $retiro, PDO::PARAM_STR);
            $stmt->bindParam(":altura_normativa", $altura_normativa, PDO::PARAM_STR);
            $stmt->bindParam(":altura_proyectada", $altura_proyectada, PDO::PARAM_STR);
            $stmt->bindParam(":cumple", $cumple, PDO::PARAM_INT);
            $stmt->bindParam(":observaciones", $observaciones, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Altura máxima guardada correctamente",
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
            $stmt = $db->prepare("SELECT * FROM altura_maxima WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            $altura = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($altura ? $altura : null);
            
        } catch (Exception $e) {
            echo json_encode(null);
        }
    }
    
    if ($_POST["accion"] == "eliminar") {
        $id_expediente = $_POST["id_expediente"];
        
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("DELETE FROM altura_maxima WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Altura máxima eliminada correctamente"
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