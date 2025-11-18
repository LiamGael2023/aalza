<?php

class ControladorRetiroMinimo {
    
    /**
     * Guardar retiro mínimo
     */
    static public function ctrGuardarRetiroMinimo() {
        if (isset($_POST["id_expediente"])) {
            
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "frontal_normativo" => $_POST["frontal_normativo"],
                "frontal_normativo_valor" => $_POST["frontal_normativo_valor"],
                "frontal_normativo_nota" => $_POST["frontal_normativo_nota"],
                "frontal_proyectado" => $_POST["frontal_proyectado"],
                "frontal_cumple" => $_POST["frontal_cumple"],
                "lateral_normativo" => $_POST["lateral_normativo"],
                "lateral_normativo_valor" => $_POST["lateral_normativo_valor"],
                "lateral_normativo_nota" => $_POST["lateral_normativo_nota"],
                "lateral_proyectado" => $_POST["lateral_proyectado"],
                "lateral_cumple" => $_POST["lateral_cumple"],
                "posterior_normativo" => $_POST["posterior_normativo"],
                "posterior_normativo_valor" => $_POST["posterior_normativo_valor"],
                "posterior_normativo_nota" => $_POST["posterior_normativo_nota"],
                "posterior_proyectado" => $_POST["posterior_proyectado"],
                "posterior_cumple" => $_POST["posterior_cumple"],
                "cumple_general" => $_POST["cumple_general"],
                "observaciones" => $_POST["observaciones"] ?? ""
            ];
            
            $respuesta = ModeloRetiroMinimo::mdlGuardarRetiroMinimo($datos);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Retiro mínimo guardado correctamente",
                    "cumple_general" => $datos["cumple_general"]
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
     * Mostrar retiro mínimo
     */
    static public function ctrMostrarRetiroMinimo($id_expediente) {
        return ModeloRetiroMinimo::mdlMostrarRetiroMinimo($id_expediente);
    }
    
    /**
     * Eliminar retiro mínimo
     */
    static public function ctrEliminarRetiroMinimo() {
        if (isset($_POST["id_expediente"])) {
            $respuesta = ModeloRetiroMinimo::mdlEliminarRetiroMinimo($_POST["id_expediente"]);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Retiro mínimo eliminado"
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