<?php

class ControladorDensidadNeta {
    
    /**
     * Guardar densidad neta
     */
    static public function ctrGuardarDensidadNeta() {
        if (isset($_POST["id_expediente"])) {
            
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "coeficiente_edificacion" => $_POST["coeficiente_edificacion"],
                "coeficiente_normativo" => $_POST["coeficiente_normativo"],
                "numero_ocupantes" => $_POST["numero_ocupantes"],
                "densidad_proyectada" => $_POST["densidad_proyectada"],
                "cumple" => $_POST["cumple"],
                "observaciones" => $_POST["observaciones"] ?? "",
                "viviendas" => json_decode($_POST["viviendas"], true) ?? []
            ];
            
            $respuesta = ModeloDensidadNeta::mdlGuardarDensidadNeta($datos);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Densidad neta guardada correctamente",
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
     * Mostrar densidad neta
     */
    static public function ctrMostrarDensidadNeta($id_expediente) {
        return ModeloDensidadNeta::mdlMostrarDensidadNeta($id_expediente);
    }
    
    /**
     * Mostrar viviendas
     */
    static public function ctrMostrarViviendas($id_densidad) {
        return ModeloDensidadNeta::mdlMostrarViviendas($id_densidad);
    }
    
    /**
     * Eliminar densidad neta
     */
    static public function ctrEliminarDensidadNeta() {
        if (isset($_POST["id_expediente"])) {
            $respuesta = ModeloDensidadNeta::mdlEliminarDensidadNeta($_POST["id_expediente"]);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Densidad neta eliminada"
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