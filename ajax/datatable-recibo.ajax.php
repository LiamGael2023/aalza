<?php

ob_start();

require_once "../controladores/recibo.controlador.php";
require_once "../modelos/recibo.modelo.php";

class tablaRecibo{

    public function mostrartablaRecibo() {
        $item = null;
        $valor = null;

        $recibo = ControladorRecibo::ctrMostrarRecibo($item, $valor); 
        
        if (!is_array($recibo)) {
            $recibo = [];
        }
        
        $datos = array();

        foreach ($recibo as $key => $recibos) {
            
            $fecha = $recibos["fecha_emision"];
            if ($fecha instanceof DateTime) {
                $fecha_emision = $fecha->format('d/m/Y');
            } else {
                $fecha_emision = date('d/m/Y', strtotime($fecha));
            }
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $lectura = '<td>'.utf8_encode($recibos["lectura"]).'</td>';
            $correlativo = '<td>'."001-".$recibos["correlativo"].'</td>';
            $fechaemision = '<td>'.$fecha_emision.'</td>';
            $rangofechas = '<td>'.utf8_encode($recibos["rango_fechas"]).'</td>';
            $consumo = '<td>' . number_format($recibos["sumconsumo"], 0, '.', ',') . '</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a target="_blank" href="repositorio/pdf/recibo.php?id='.$recibos["id"].'" class="btn btn-sm btn-danger p-1"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pdf"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v8h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-2z" /><path d="M3 12h2a2 2 0 1 0 0 -4h-2v8" /><path d="M17 12h3" /><path d="M21 8h-4v8" /></svg></a>'
                       . '</div></td>';
                        
            $fila = array(
                $numeroFila,
                $correlativo,
                $lectura,
                $fechaemision,
                $rangofechas,
                $consumo,
                $botones
            );

            $datos[] = $fila;
        }

        header('Content-Type: application/json');
        echo json_encode(array("data" => $datos));

        // Captura la salida y la imprime
        $output = ob_get_clean();
        echo $output;
    }
}

$activarRecibo = new tablaRecibo();
$activarRecibo->mostrartablaRecibo();

?>