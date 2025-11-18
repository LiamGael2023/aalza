<?php

require_once "../controladores/medidor.controlador.php";
require_once "../modelos/medidor.modelo.php";

class tablaLoteCaptacionMedidor{

    public function mostrarLoteCaptacionMedidor() {
        $variable = isset($_POST['variable']) ? $_POST['variable'] : null;

        // Definir los valores para la consulta
        $item = 'idmedidor'; // Este debe ser el campo en tu base de datos para el filtro
        $valor = $variable; // Usar la variable obtenida

        $medidor = ControladorMedidor::ctrMostrarLoteCaptacionMedidor($item, $valor); 

        if (count($medidor) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($medidor as $key => $medidores) {
            $paquete = '<td>'. utf8_encode($medidores["paquete"]).'</td>';
            $estructura = '<td>'.utf8_encode($medidores["estructura"]).'</td>';
            $nombre = '<td>'.utf8_encode($medidores["Tipo"]).'</td>';
            $progresiva = '<td>'.$medidores["ProgresivaContinua"].'</td>';
            $lote = '<td>'.utf8_encode($medidores["lote"]).'</td>';
            $bloque = '<td>'.utf8_encode($medidores["bloque"]).'</td>';
            $comision = '<td>'.utf8_encode($medidores["comision"]).'</td>';
            $junta = '<td>'.utf8_encode($medidores["junta"]).'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-sm btn-danger p-1 btnEliminarModeloMedidor" data-idmodelomedidor='.$medidores["id"].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-x">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
      <path d="M4 6v6c0 1.657 3.582 3 8 3c.537 0 1.062 -.02 1.57 -.058" />
      <path d="M20 13.5v-7.5" />
      <path d="M4 12v6c0 1.657 3.582 3 8 3c.384 0 .762 -.01 1.132 -.03" />
      <path d="M22 22l-5 -5" />
      <path d="M17 22l5 -5" />
    </svg></a>'
                       . '</div></td>';
                        
            $fila = array(
                $paquete,
                $estructura,
                $nombre,
                $progresiva,
                $lote,
                $bloque,
                $comision,
                $junta,
                $botones
            );

            $datos[] = $fila;
        }

        echo json_encode(array("data" => $datos));
    }
}

$activarMedidor = new tablaLoteCaptacionMedidor();
$activarMedidor->mostrarLoteCaptacionMedidor();

?>