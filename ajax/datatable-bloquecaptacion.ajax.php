<?php

require_once "../controladores/bloque.controlador.php";
require_once "../modelos/bloque.modelo.php";

class tablaAsignarBloqueCaptacion {

    public function mostrartablaAsignarBloqueCaptacion() {
        // Obtener el valor de la variable enviada desde JavaScript
        $variable = isset($_POST['variable']) ? $_POST['variable'] : null;

        // Definir los valores para la consulta
        $item = 'idbloque'; // Este debe ser el campo en tu base de datos para el filtro
        $valor = $variable; // Usar la variable obtenida

        $derechousolotes = ControladorBloque::ctrMostrarBloqueCaptacion($item, $valor);

        if (count($derechousolotes) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($derechousolotes as $key => $derechousos) {
                       
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>';
            $estructura = '<td>'. utf8_encode($derechousos["captacion"]).'</td>';
            $tipo = '<td>'.utf8_encode($derechousos["tipo"]).'</td>';
            $progresiva = '<td>'.utf8_encode($derechousos["ProgresivaContinua"]).'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-light-danger btnEliminarMarcaMedidor" data-idmarcamedidor='.$derechousos["id"].'><i class="feather icon-trash-2"></i></a>'
                       . '</div></td>';
            
            $fila = array(
                $numeroFila,
                $estructura,
                $tipo,
                $progresiva,
                $botones
            );

            $datos[] = $fila;
        }

        echo json_encode(array("data" => $datos));
    }
}

$activarBloqueCaptacion = new tablaAsignarBloqueCaptacion();
$activarBloqueCaptacion->mostrartablaAsignarBloqueCaptacion();

?>
