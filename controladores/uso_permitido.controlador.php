<?php

class ControladorUsoPermitido {
    
    /**
     * Guardar o actualizar uso permitido
     */
    static public function ctrGuardarUsoPermitido() {
        if (isset($_POST["id_expediente"])) {
            
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "uso_normativo" => $_POST["uso_normativo"],
                "uso_proyecto" => $_POST["uso_proyecto"],
                "observaciones" => $_POST["observaciones"] ?? ""
            ];
            
            $respuesta = ModeloUsoPermitido::mdlGuardarUsoPermitido($datos);
            
            $cumple = ($datos["uso_normativo"] === $datos["uso_proyecto"]);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Uso permitido guardado correctamente",
                    "cumple" => $cumple
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
     * Mostrar uso permitido (solo uno)
     */
    static public function ctrMostrarUsoPermitido($id_expediente) {
        return ModeloUsoPermitido::mdlMostrarUsoPermitido($id_expediente);
    }
    
    /**
     * Eliminar uso permitido
     */
    static public function ctrEliminarUsoPermitido() {
        if (isset($_POST["id_expediente"])) {
            $respuesta = ModeloUsoPermitido::mdlEliminarUsoPermitido($_POST["id_expediente"]);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Uso permitido eliminado"
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