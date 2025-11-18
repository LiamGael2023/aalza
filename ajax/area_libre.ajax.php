<?php
require_once "../modelos/conexion.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardarConfig") {
        $id_expediente = $_POST["id_expediente"];
        $id_piso_seleccionado = $_POST["id_piso_seleccionado"];
        $area_adicional = $_POST["area_adicional"];
        $nota = $_POST["nota"] ?? '';
        
        try {
            $db = Conexion::conectar();
            
            // Verificar si ya existe
            $stmt = $db->prepare("SELECT id_config FROM area_libre_config WHERE id_expediente = :id_expediente");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            $existe = $stmt->fetch();
            
            if ($existe) {
                // Actualizar
                $stmt = $db->prepare("UPDATE area_libre_config SET 
                    id_piso_seleccionado = :id_piso, 
                    area_adicional = :area_adicional,
                    nota = :nota,
                    updated_at = CURRENT_TIMESTAMP
                    WHERE id_expediente = :id_expediente");
            } else {
                // Insertar
                $stmt = $db->prepare("INSERT INTO area_libre_config 
                    (id_expediente, id_piso_seleccionado, area_adicional, nota) 
                    VALUES (:id_expediente, :id_piso, :area_adicional, :nota)");
            }
            
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->bindParam(":id_piso", $id_piso_seleccionado, PDO::PARAM_INT);
            $stmt->bindParam(":area_adicional", $area_adicional, PDO::PARAM_STR);
            $stmt->bindParam(":nota", $nota, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Configuración guardada"
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
    
    if ($_POST["accion"] == "obtenerConfig") {
        $id_expediente = $_POST["id_expediente"];
        
        try {
            $db = Conexion::conectar();
            $stmt = $db->prepare("SELECT * FROM area_libre_config WHERE id_expediente = :id_expediente LIMIT 1");
            $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
            $stmt->execute();
            
            $config = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($config ? $config : null);
            
        } catch (Exception $e) {
            echo json_encode(null);
        }
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>