<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../controladores/piso.controlador.php";
require_once "../modelos/piso.modelo.php";

class AjaxPiso {
    
    public $id_expediente;
    public $accion;
    
    public function ajaxGuardarPisos() {
        ControladorPiso::ctrGuardarPisos();
    }
    
    public function ajaxMostrarPisos() {
        $respuesta = ControladorPiso::ctrMostrarPisos($this->id_expediente);
        echo json_encode($respuesta);
    }
    
    public function ajaxEliminarPisos() {
        $respuesta = ControladorPiso::ctrEliminarPisos($this->id_expediente);
        if ($respuesta == "ok") {
            echo json_encode([
                "status" => "success",
                "message" => "Pisos eliminados correctamente"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Error al eliminar los pisos"
            ]);
        }
    }
}

// Detectar la acción
if (isset($_POST["accion"])) {
    
    $accion = $_POST["accion"];
    
    // PRIORIDAD 1: Listar/Mostrar (para el cálculo de área libre)
    if ($accion == "listar" || $accion == "mostrar") {
        $id_expediente = $_POST["id_expediente"];
        error_log("=== AJAX PISO - LISTAR ===");
        error_log("ID Expediente: " . $id_expediente);
        
        $pisos = ControladorPiso::ctrMostrarPisos($id_expediente);
        
        error_log("Pisos encontrados: " . (is_array($pisos) ? count($pisos) : 0));
        error_log("Datos pisos: " . print_r($pisos, true));
        
        // Asegurar que siempre devuelva un array
        if (!$pisos || !is_array($pisos)) {
            echo json_encode([]);
        } else {
            echo json_encode($pisos);
        }
        exit;
    }
    
    // Guardar pisos
    if ($accion == "guardarPisos") {
        $pisos = new AjaxPiso();
        $pisos->ajaxGuardarPisos();
        exit;
    }
    
    // Mostrar pisos (para la tabla)
    if ($accion == "mostrarPisos") {
        $pisos = new AjaxPiso();
        $pisos->id_expediente = $_POST["id_expediente"];
        $pisos->ajaxMostrarPisos();
        exit;
    }
    
    // Actualizar áreas
    if ($accion == "actualizarAreas") {
        ControladorPiso::ctrActualizarAreasPiso();
        exit;
    }
    
    // Eliminar pisos
    if ($accion == "eliminarPisos") {
        $pisos = new AjaxPiso();
        $pisos->id_expediente = $_POST["id_expediente"];
        $pisos->ajaxEliminarPisos();
        exit;
    }
    
    // Si llegamos aquí, la acción no es válida
    echo json_encode([
        "status" => "error",
        "message" => "Acción no reconocida: " . $accion
    ]);
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>