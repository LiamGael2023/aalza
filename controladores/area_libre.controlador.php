<?php

class ControladorAreaLibre {
    
    /**
     * Guardar configuración de área libre
     */
    static public function ctrGuardarConfigAreaLibre() {
        if (isset($_POST["id_expediente"])) {
            
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "id_piso_seleccionado" => $_POST["id_piso_seleccionado"] ?? null,
                "area_adicional" => $_POST["area_adicional"] ?? 0,
                "nota" => $_POST["nota"] ?? ""
            ];
            
            $respuesta = ModeloAreaLibre::mdlGuardarConfigAreaLibre($datos);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Configuración de área libre guardada"
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
     * Obtener configuración
     */
    static public function ctrObtenerConfigAreaLibre($id_expediente) {
        return ModeloAreaLibre::mdlObtenerConfigAreaLibre($id_expediente);
    }
}