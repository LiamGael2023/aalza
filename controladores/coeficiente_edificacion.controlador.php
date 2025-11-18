<?php

class ControladorCoeficienteEdificacion {
    
    /**
     * Guardar coeficiente de edificación
     */
    static public function ctrGuardarCoeficienteEdificacion() {
        if (isset($_POST["id_expediente"])) {
            
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "coef_normativo" => $_POST["coef_normativo"],
                "es_libre" => $_POST["es_libre"],
                "dscto_area_coef" => $_POST["dscto_area_coef"],
                "area_techada_total" => $_POST["area_techada_total"],
                "coef_proyectado" => $_POST["coef_proyectado"],
                "cumple" => $_POST["cumple"],
                "observaciones" => $_POST["observaciones"] ?? ""
            ];
            
            $respuesta = ModeloCoeficienteEdificacion::mdlGuardarCoeficienteEdificacion($datos);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Coeficiente de edificación guardado correctamente",
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
     * Mostrar coeficiente de edificación
     */
    static public function ctrMostrarCoeficienteEdificacion($id_expediente) {
        return ModeloCoeficienteEdificacion::mdlMostrarCoeficienteEdificacion($id_expediente);
    }
    
    /**
     * Eliminar coeficiente de edificación
     */
    static public function ctrEliminarCoeficienteEdificacion() {
        if (isset($_POST["id_expediente"])) {
            $respuesta = ModeloCoeficienteEdificacion::mdlEliminarCoeficienteEdificacion($_POST["id_expediente"]);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Coeficiente de edificación eliminado"
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