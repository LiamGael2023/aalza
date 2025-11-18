<?php
header('Content-Type: application/json');

require_once "../controladores/redhidrografica.controlador.php";
require_once "../modelos/redhidrografica.modelo.php";

$formulaTexto = $_POST['formula'];
$tipo = $_POST['tipo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['datos'])) {
        echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos.']);
        exit;
    }

    $datos = $_POST['datos'];

    if (!is_array($datos) || count($datos) !== 26) {
        echo json_encode(['status' => 'error', 'message' => 'Datos incorrectos. Se requieren 25 elementos.']);
        exit;
    }

    $id = $datos[25];
    $alturaDatos = array_slice($datos, 1, 24); // Los primeros 24 elementos son las alturas

    // Calcular horaDatos reemplazando H en la fórmula con cada altura
    if ($tipo == 'Altura') {
        $horaDatos = array_map(function($altura) use ($formulaTexto) {
            // Verifica si la altura es un guion "-"
            if ($altura === '-') {
                return '-'; // Retorna un guion si la altura es un guion
            }
            
            // Verifica si la altura es 0
            if ($altura == 0) {
                return 0; // Retorna 0 directamente si la altura es 0
            }

            // Si la altura no es 0 ni guion, reemplaza H y evalúa la fórmula
            $formulaEvaluada = str_replace("H", $altura, $formulaTexto); // Reemplaza H con el valor de altura
            eval("\$resultado = $formulaEvaluada;"); // Ejecuta la fórmula y almacena el resultado en $resultado
            return $resultado; // Devuelve el resultado para cada altura
        }, $alturaDatos);
        
        // Asegúrate de que horaDatos mantenga el guion en las posiciones correctas
        foreach ($alturaDatos as $index => $altura) {
            if ($altura === '-') {
                $horaDatos[$index] = '-'; // Asegúrate de que el índice correspondiente tenga un guion
            }
        }
        
        // **Depuración con error_log para revisar los datos antes de actualizar**
        error_log("ID: " . $id);  // Registra el ID
        error_log("Altura Datos: " . print_r($alturaDatos, true));  // Registra las alturas
        error_log("Hora Datos: " . print_r($horaDatos, true));  // Registra las horas calculadas

        $resultado = ModeloRedHidrografica::mdlActualizarCaudalCirculante($id, $alturaDatos, $horaDatos);

        if ($resultado) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la base de datos.']);
        }
    } elseif ($tipo == 'Medición') {
        // Si el tipo es "Medición", solo muestra un mensaje sin hacer el cálculo
        $horaDatos = $alturaDatos;
        
        error_log("ID: " . $id);  // Registra el ID
        error_log("Altura Datos (Medición): " . print_r($alturaDatos, true));  // Registra las alturas
        error_log("Hora Datos (Medición): " . print_r($horaDatos, true));  // Las horas son las mismas que las alturas

        $resultado = ModeloRedHidrografica::mdlActualizarCaudalCirculante($id, $alturaDatos, $horaDatos);

        if ($resultado) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la base de datos.']);
        } 
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
    }
}