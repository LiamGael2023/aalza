<?php

class ControladorPiso {
    
    /**
     * Guardar pisos del expediente
     */
    static public function ctrGuardarPisos() {
        if (isset($_POST["id_expediente"])) {
            
            // Validar que venga el ID del expediente
            if (empty($_POST["id_expediente"])) {
                echo json_encode([
                    "status" => "error",
                    "message" => "ID de expediente no especificado"
                ]);
                return;
            }
            
            // Preparar datos
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "sotanos" => isset($_POST["sotanos"]) ? $_POST["sotanos"] : [],
                "pisos" => isset($_POST["pisos"]) ? $_POST["pisos"] : [],
                "azotea" => isset($_POST["azotea"]) ? $_POST["azotea"] : null
            ];
            
            // Validar que haya al menos un nivel
            $totalNiveles = count($datos["sotanos"]) + count($datos["pisos"]) + (!empty($datos["azotea"]) ? 1 : 0);
            
            if ($totalNiveles === 0) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Debe seleccionar al menos un nivel"
                ]);
                return;
            }
            
            // Guardar en el modelo
            $respuesta = ModeloPiso::mdlGuardarPisos($datos);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Pisos guardados correctamente",
                    "total_niveles" => $totalNiveles
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error al guardar los pisos: " . $respuesta
                ]);
            }
        }
    }
    
    static public function ctrActualizarAreasPiso() {
    if (isset($_POST["id_piso"])) {
        $datos = [
            "id_piso" => $_POST["id_piso"],
            "area_nueva" => $_POST["area_nueva"],
            "area_existente" => $_POST["area_existente"],
            "area_demolicion" => $_POST["area_demolicion"],
            "area_ampliacion" => $_POST["area_ampliacion"],
            "area_remodelacion" => $_POST["area_remodelacion"]
        ];
        
        $respuesta = ModeloPiso::mdlActualizarAreasPiso($datos);
        
        if ($respuesta == "ok") {
            echo json_encode([
                "status" => "success",
                "message" => "Áreas actualizadas correctamente"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Error al actualizar las áreas"
            ]);
        }
    }
}
    
    /**
     * Mostrar pisos de un expediente
     */
    static public function ctrMostrarPisos($id_expediente) {
    $respuesta = ModeloPiso::mdlMostrarPisos($id_expediente);
    
    // Asegurar que siempre devuelva un array
    if (!$respuesta || !is_array($respuesta)) {
        return [];
    }
    
    return $respuesta;
}
    
    /**
     * Eliminar pisos de un expediente
     */
    static public function ctrEliminarPisos($id_expediente) {
        $respuesta = ModeloPiso::mdlEliminarPisos($id_expediente);
        return $respuesta;
    }
    
    static public function ctrListarPisos($id_expediente) {
        return ModeloPiso::mdlListarPisos($id_expediente);
    }
}