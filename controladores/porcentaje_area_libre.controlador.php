<?php

class ControladorPorcentajeAreaLibre {
    
    /**
     * Guardar porcentaje de área libre
     */
    static public function ctrGuardarPorcentajeAreaLibre() {
        if (isset($_POST["id_expediente"])) {
            
            $datos = [
                "id_expediente" => $_POST["id_expediente"],
                "porcentaje_necesario" => $_POST["porcentaje_necesario"],
                "criterio_seleccionado" => $_POST["criterio_seleccionado"],
                "area_libre" => $_POST["area_libre"],
                "area_terreno" => $_POST["area_terreno"],
                "porcentaje_proyectado" => $_POST["porcentaje_proyectado"],
                "cumple" => $_POST["cumple"],
                "observaciones" => $_POST["observaciones"] ?? ""
            ];
            
            $respuesta = ModeloPorcentajeAreaLibre::mdlGuardarPorcentajeAreaLibre($datos);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Porcentaje de área libre guardado correctamente",
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
     * Mostrar porcentaje de área libre
     */
    static public function ctrMostrarPorcentajeAreaLibre($id_expediente) {
        return ModeloPorcentajeAreaLibre::mdlMostrarPorcentajeAreaLibre($id_expediente);
    }
    
    /**
     * Eliminar porcentaje de área libre
     */
    static public function ctrEliminarPorcentajeAreaLibre() {
        if (isset($_POST["id_expediente"])) {
            $respuesta = ModeloPorcentajeAreaLibre::mdlEliminarPorcentajeAreaLibre($_POST["id_expediente"]);
            
            if ($respuesta == "ok") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Porcentaje de área libre eliminado"
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