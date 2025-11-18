<?php

ob_start();

require_once "../controladores/redhidrografica.controlador.php";
require_once "../modelos/redhidrografica.modelo.php";

class tablaReserva{

    public function mostrartablaReserva() {
        $item = null;
        $valor = null;

        $reserva = ControladorRedHidrografica::ctrMostrarReserva($item, $valor); 
        
        if (!is_array($reserva)) {
            $reserva = [];
        }
        
        $datos = array();

        foreach ($reserva as $key => $reservas) {
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $nombre = '<td>'.$reservas["docref"].'</td>';

            // Convertimos la fecha a formato d/m/Y
            if ($reservas["fecha_ini"] instanceof DateTime) {
                $fechaFormateada = $reservas["fecha_ini"]->format('d/m/Y'); // Formato día/mes/año
            } else {
                $fechaFormateada = $reservas["fecha_ini"]; // En caso de que no sea un objeto DateTime
            }

            $abreviatura = '<td>'.$fechaFormateada.'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-light-secondary" id='.$reservas["id"].' onclick="redirectToDetail('.$reservas["id"].')" title="Reserva"><i class="fas fa-edit"></i></a>'
                       . '<a type="button" class="btn btn-light-danger btnEliminarJunta" data-idjunta='.$reservas["id"].'><i class="feather icon-trash-2"></i></a>'
                       . '</div></td>';
                        
            $fila = array(
                $numeroFila,
                $nombre,
                $abreviatura,
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

$activarReserva = new tablaReserva();
$activarReserva->mostrartablaReserva();

?>
