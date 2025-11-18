<?php

class ControladorAreaLoteNormativo {
    
    /**
     * Guardar área de lote normativo
     */
    static public function ctrGuardarAreaLoteNormativo() {
        if (isset($_POST["id_expediente"])) {
            
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "area_normativa" => $_POST["area_normativa"],
                "area_proyectada" => $_POST["area_proyectada"],
                "cumple" => $_POST["cumple"],
                "observaciones" => $_POST["observaciones"] ?? ""
            ];
            
            $respuesta = ModeloAreaLoteNormativo::mdlGuardarAreaLoteNormativo($datos);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Área de lote normativo guardada correctamente",
                    "cumple" => $datos["cumple"]
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error al guardar: " . $respuesta
                ]);
            }
        }
    }
    
    /**
     * Mostrar área de lote normativo
     */
    static public function ctrMostrarAreaLoteNormativo($id_expediente) {
        return ModeloAreaLoteNormativo::mdlMostrarAreaLoteNormativo($id_expediente);
    }
    
    /**
     * Eliminar área de lote normativo
     */
    static public function ctrEliminarAreaLoteNormativo() {
        if (isset($_POST["id_expediente"])) {
            $respuesta = ModeloAreaLoteNormativo::mdlEliminarAreaLoteNormativo($_POST["id_expediente"]);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Área de lote normativo eliminada"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error al eliminar"
                ]);
            }
        }
    }
}