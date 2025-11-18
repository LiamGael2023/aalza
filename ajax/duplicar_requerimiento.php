<?php
require_once "../controladores/requerimiento.controlador.php";
require_once "../modelos/requerimiento.modelo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idReq = $_POST["idReq"];
    $captacion = $_POST["captacion"];
    $fechaInicio = $_POST["fechaInicio"];
    $fechaTermino = $_POST["fechaTermino"];
    $tiempoOperacion = $_POST["tiempoOperacion"];
    $caudalNeto = $_POST["caudalNeto"];
    $caudalBruto = $_POST["caudalBruto"];
    $volumenFacturado = $_POST["volumenFacturado"];
    $volumenBruto = $_POST["volumenBruto"];
    $totalTuihma = $_POST["totalTuihma"];
    $eficiencia = $_POST["eficiencia"];
    $tarifa = $_POST["tarifa"];

    // Crear el nuevo requerimiento con los datos duplicados
    $datos = array(
        "idRequerimiento" => $idReq,
        "idBloqueCaptacion" => $captacion,
        "fecha_horaini" => $fechaInicio,
        "fecha_horatermino" => $fechaTermino,
        "tiempo_operacion" => $tiempoOperacion,
        "caudalneto" => $caudalNeto,
        "caudalbruto" => $caudalBruto,
        "volfacturado" => $volumenFacturado,
        "volbruto" => $volumenBruto,
        "totalTUIHMA" => $totalTuihma,
        "eficiencia" => $eficiencia,
        "tarifaTUIHMA" => $tarifa
    );

    $respuesta = ControladorRequerimiento::ctrDuplicarRequerimiento($datos);

    echo json_encode($respuesta);
}
?>