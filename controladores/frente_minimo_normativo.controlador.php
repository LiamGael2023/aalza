<?php

class ControladorFrenteMinimoNormativo {
    
    /**
     * Guardar frente mínimo normativo
     */
    static public function ctrGuardarFrenteMinimoNormativo() {
        if (isset($_POST["id_expediente"])) {
            
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "frente_normativo" => $_POST["frente_normativo"],
                "frente_proyectado" => $_POST["frente_proyectado"],
                "cumple" => $_POST["cumple"],
                "observaciones" => $_POST["observaciones"] ?? ""
            ];
            
            $respuesta = ModeloFrenteMinimoNormativo::mdlGuardarFrenteMinimoNormativo($datos);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Frente mínimo normativo guardado correctamente",
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
     * Mostrar frente mínimo normativo
     */
    static public function ctrMostrarFrenteMinimoNormativo($id_expediente) {
        return ModeloFrenteMinimoNormativo::mdlMostrarFrenteMinimoNormativo($id_expediente);
    }
    
    /**
     * Eliminar frente mínimo normativo
     */
    static public function ctrEliminarFrenteMinimoNormativo() {
        if (isset($_POST["id_expediente"])) {
            $respuesta = ModeloFrenteMinimoNormativo::mdlEliminarFrenteMinimoNormativo($_POST["id_expediente"]);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Frente mínimo normativo eliminado"
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