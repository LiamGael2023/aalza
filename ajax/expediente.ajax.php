<?php
require_once "../controladores/expediente.controlador.php";
require_once "../modelos/expediente.modelo.php";

// Verificar que se recibió una acción
if (!isset($_POST['accion'])) {
    echo json_encode(array(
        "success" => false,
        "message" => "No se especificó ninguna acción"
    ));
    exit;
}

$accion = $_POST['accion'];

try {
    switch ($accion) {
        case 'crear':
            crearExpediente();
            break;
            
        case 'editar':
            editarExpediente();
            break;
            
        case 'obtener':
            obtenerExpediente();
            break;
            
        case 'eliminar':
            eliminarExpediente();
            break;
            
        default:
            echo json_encode(array(
                "success" => false,
                "message" => "Acción no válida: " . $accion
            ));
    }
} catch (Exception $e) {
    echo json_encode(array(
        "success" => false,
        "message" => "Error del servidor: " . $e->getMessage()
    ));
}

// ============================================
// FUNCIÓN CREAR EXPEDIENTE
// ============================================
function crearExpediente() {
    // Generar número de expediente automáticamente
    $numero_expediente = generarNumeroExpediente();
    
    // SOLO los campos del modal
    $datos = array(
        "numero_expediente" => $numero_expediente,
        "propietario" => trim($_POST['propietario'] ?? ''),
        "copropietario" => !empty($_POST['copropietario']) ? trim($_POST['copropietario']) : null,
        "zonificacion" => $_POST['zonificacion'] ?? null,
        "ubicacion" => !empty($_POST['ubicacion']) ? trim($_POST['ubicacion']) : null,
        "estructura_urbana" => !empty($_POST['estructura_urbana']) ? trim($_POST['estructura_urbana']) : null,
        "partida_electronica" => !empty($_POST['partida_electronica']) ? trim($_POST['partida_electronica']) : null,
        "area_terreno" => !empty($_POST['area_terreno']) ? floatval($_POST['area_terreno']) : null,
        "frente" => !empty($_POST['frente']) ? floatval($_POST['frente']) : null,
        "derecha" => !empty($_POST['derecha']) ? floatval($_POST['derecha']) : null,
        "izquierda" => !empty($_POST['izquierda']) ? floatval($_POST['izquierda']) : null,
        "fondo" => !empty($_POST['fondo']) ? floatval($_POST['fondo']) : null
    );
    
    // Validar campos requeridos
    if (empty($datos['propietario'])) {
        echo json_encode(array(
            "success" => false,
            "message" => "El campo Propietario es obligatorio"
        ));
        return;
    }
    
    if (empty($datos['zonificacion'])) {
        echo json_encode(array(
            "success" => false,
            "message" => "El campo Zonificación es obligatorio"
        ));
        return;
    }
    
    if (empty($datos['ubicacion'])) {
        echo json_encode(array(
            "success" => false,
            "message" => "El campo Ubicación es obligatorio"
        ));
        return;
    }
    
    $respuesta = ControladorExpediente::ctrCrearExpediente($datos);
    
    if ($respuesta == "ok") {
        echo json_encode(array(
            "success" => true,
            "message" => "✓ Expediente creado exitosamente: " . $numero_expediente
        ));
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Error al crear el expediente: " . $respuesta
        ));
    }
}

// ============================================
// FUNCIÓN EDITAR EXPEDIENTE
// ============================================
function editarExpediente() {
    if (empty($_POST['id_expediente'])) {
        echo json_encode(array(
            "success" => false,
            "message" => "ID de expediente no especificado"
        ));
        return;
    }
    
    // SOLO los campos del modal
    $datos = array(
        "id_expediente" => intval($_POST['id_expediente']),
        "propietario" => trim($_POST['propietario'] ?? ''),
        "copropietario" => !empty($_POST['copropietario']) ? trim($_POST['copropietario']) : null,
        "zonificacion" => $_POST['zonificacion'] ?? null,
        "ubicacion" => !empty($_POST['ubicacion']) ? trim($_POST['ubicacion']) : null,
        "estructura_urbana" => !empty($_POST['estructura_urbana']) ? trim($_POST['estructura_urbana']) : null,
        "partida_electronica" => !empty($_POST['partida_electronica']) ? trim($_POST['partida_electronica']) : null,
        "area_terreno" => !empty($_POST['area_terreno']) ? floatval($_POST['area_terreno']) : null,
        "frente" => !empty($_POST['frente']) ? floatval($_POST['frente']) : null,
        "derecha" => !empty($_POST['derecha']) ? floatval($_POST['derecha']) : null,
        "izquierda" => !empty($_POST['izquierda']) ? floatval($_POST['izquierda']) : null,
        "fondo" => !empty($_POST['fondo']) ? floatval($_POST['fondo']) : null
    );
    
    $respuesta = ControladorExpediente::ctrEditarExpediente($datos);
    
    if ($respuesta == "ok") {
        echo json_encode(array(
            "success" => true,
            "message" => "✓ Expediente actualizado exitosamente"
        ));
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Error al actualizar el expediente: " . $respuesta
        ));
    }
}

// ============================================
// FUNCIÓN OBTENER EXPEDIENTE
// ============================================
function obtenerExpediente() {
    // Log para debugging
    error_log("=== OBTENER EXPEDIENTE ===");
    error_log("POST: " . print_r($_POST, true));
    
    if (empty($_POST['id_expediente'])) {
        $response = array(
            "success" => false,
            "message" => "ID de expediente no especificado",
            "debug_post" => $_POST
        );
        error_log("Error: ID no especificado");
        echo json_encode($response);
        return;
    }
    
    $item = "id_expediente";
    $valor = intval($_POST['id_expediente']);
    
    error_log("Buscando expediente con ID: " . $valor);
    
    $respuesta = ControladorExpediente::ctrMostrarExpediente($item, $valor);
    
    error_log("Resultado de la consulta: " . print_r($respuesta, true));
    
    if (!empty($respuesta) && is_array($respuesta)) {
        $response = array(
            "success" => true,
            "data" => $respuesta[0]
        );
        error_log("Expediente encontrado exitosamente");
        echo json_encode($response);
    } else {
        $response = array(
            "success" => false,
            "message" => "No se encontró el expediente con ID: " . $valor,
            "debug_query_result" => $respuesta
        );
        error_log("Expediente no encontrado");
        echo json_encode($response);
    }
}

// ============================================
// FUNCIÓN ELIMINAR EXPEDIENTE
// ============================================
function eliminarExpediente() {
    if (empty($_POST['id_expediente'])) {
        echo json_encode(array(
            "success" => false,
            "message" => "ID de expediente no especificado"
        ));
        return;
    }
    
    $id = intval($_POST['id_expediente']);
    
    if ($id <= 0) {
        echo json_encode(array(
            "success" => false,
            "message" => "ID de expediente inválido"
        ));
        return;
    }
    
    $respuesta = ControladorExpediente::ctrEliminarExpediente($id);
    
    if ($respuesta == "ok") {
        echo json_encode(array(
            "success" => true,
            "message" => "✓ Expediente eliminado exitosamente"
        ));
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Error al eliminar el expediente: " . $respuesta
        ));
    }
}

// ============================================
// FUNCIÓN GENERAR NÚMERO DE EXPEDIENTE
// ============================================
function generarNumeroExpediente() {
    $ultimo = ControladorExpediente::ctrObtenerUltimoNumero();
    
    if ($ultimo && isset($ultimo['numero_expediente'])) {
        // Extraer el número del formato PRECAL-000007-2025
        if (preg_match('/PRECAL-(\d+)-(\d{4})/', $ultimo['numero_expediente'], $matches)) {
            $numero = intval($matches[1]) + 1;
            $anio = date('Y');
        } else {
            $numero = 1;
            $anio = date('Y');
        }
    } else {
        $numero = 1;
        $anio = date('Y');
    }
    
    return sprintf("PRECAL-%06d-%s", $numero, $anio);
}
?>