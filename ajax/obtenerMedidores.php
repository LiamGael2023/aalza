<?php
require_once '../controladores/medidorempresa.controlador.php';
require_once '../modelos/medidorempresa.modelo.php';

$idlectura = $_GET["idl"] ?? null;
$idjunta = $_GET["idj"] ?? null;

if (!$idlectura) {
    echo json_encode([]);
    exit;
}

$item = null;
$valor = $idlectura;
$valor2 = $idjunta;

$medidores = ControladorMedidorEmpresa::ctrMostrarMedidorEmpresaselect($item, $valor, $valor2);
error_log('Medidores obtenidos: ' . print_r($medidores, true));
// Retorna los datos como JSON
header('Content-Type: application/json');
echo json_encode($medidores);