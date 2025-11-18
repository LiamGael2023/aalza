<?php

class ControladorAlineamientoFachada {
    
    /**
     * Guardar alineamiento de fachada
     */
    static public function ctrGuardarAlineamientoFachada() {
        if (isset($_POST["id_expediente"])) {
            
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "alineamiento_normativo" => $_POST["alineamiento_normativo"],
                "alineamiento_proyectado" => $_POST["alineamiento_proyectado"],
                "cumple" => $_POST["cumple"],
                "observaciones" => $_POST["observaciones"] ?? ""
            ];
            
            $respuesta = ModeloAlineamientoFachada::mdlGuardarAlineamientoFachada($datos);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Alineamiento de fachada guardado correctamente",
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
     * Mostrar alineamiento de fachada
     */
    static public function ctrMostrarAlineamientoFachada($id_expediente) {
        return ModeloAlineamientoFachada::mdlMostrarAlineamientoFachada($id_expediente);
    }
    
    /**
     * Eliminar alineamiento de fachada
     */
    static public function ctrEliminarAlineamientoFachada() {
        if (isset($_POST["id_expediente"])) {
            $respuesta = ModeloAlineamientoFachada::mdlEliminarAlineamientoFachada($_POST["id_expediente"]);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Alineamiento de fachada eliminado"
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