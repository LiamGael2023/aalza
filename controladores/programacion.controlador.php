<?php

class ControladorProgramacion {

    static public function ctrIngresarProgramacion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["semanapro"])) {
            $tabla = "programacion";
            // Ajuste de los datos con los nuevos campos de la tabla
            $datos = array(
                "semana" => $_POST["semanapro"],
                "fecha_inicio" => $_POST["fechaInicio"],
                "fecha_fin" => $_POST["fechaFin"],
                "observacion" => $_POST["observacion"]
            );

            $respuesta = ModeloProgramacion::mdlIngresarProgramacion($tabla, $datos);

            if ($respuesta == "ok") {
                echo json_encode(array("status" => "success", "message" => "¡La programación ha sido guardada correctamente!"));
            } else {
                echo json_encode(array("status" => "error", "message" => $respuesta)); // Aquí se retorna el mensaje de error del modelo
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "¡La programación no puede ir vacía o llevar caracteres especiales!"));
        }
    }
    
    static public function ctrMostrarProgramacion($item, $valor){

		$tabla = "programacion";

		$respuesta = ModeloProgramacion::MdlMostrarProgramacion($tabla, $item, $valor);

		return $respuesta;
                
	}
        
    static public function ctrFinalizarProgramacion($id, $estado) {
        // Llamar al modelo para actualizar el estado en la base de datos
        $tabla = "programacion"; // Nombre de la tabla
        $respuesta = ModeloProgramacion::mdlFinalizarProgramacion($tabla, $id, $estado);
        return $respuesta;
    }    
}