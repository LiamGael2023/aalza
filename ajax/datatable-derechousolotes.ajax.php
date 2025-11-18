<?php

require_once "../controladores/derechouso.controlador.php";
require_once "../modelos/derechouso.modelo.php";

class tablaAsignarLote {

    public function mostrartablaAsignarLote() {
        // Obtener el valor de la variable enviada desde JavaScript
        $variable = isset($_POST['variable']) ? $_POST['variable'] : null;

        // Definir los valores para la consulta
        $item = 'idderecho'; // Este debe ser el campo en tu base de datos para el filtro
        $valor = $variable; // Usar la variable obtenida

        $derechousolotes = ControladorDerechoUso::ctrMostrarLoteAsignadosDerechoUso($item, $valor);

        if (count($derechousolotes) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($derechousolotes as $key => $derechousos) {
                       
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>';
            $junta = '<td>'. utf8_encode($derechousos["junta"]).'</td>';
            $comision = '<td>'.utf8_encode($derechousos["comision"]).'</td>';
            $bloque = '<td>'.utf8_encode($derechousos["bloque"]).'</td>';
            $lote = '<td>'.utf8_encode($derechousos["lote"]).'</td>';
            $areatotal = '<td>'.$derechousos["areatotal"].' ha</td>';
            $arealicencia = '<td>'.$derechousos["arealicencia"].' ha</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-light-danger btnEliminarDerechousoLote" data-idDerechousoLote="'.$derechousos["id"].'"><i class="feather icon-trash-2"></i></a>'
                       . '</div></td>';
            
            $fila = array(
                $numeroFila,
                $lote,
                $areatotal,
                $arealicencia,
                $comision,
                $bloque,
                $junta,
                $botones
            );

            $datos[] = $fila;
        }

        echo json_encode(array("data" => $datos));
    }
}

$activarDerechoUsoLote = new tablaAsignarLote();
$activarDerechoUsoLote->mostrartablaAsignarLote();

?>
