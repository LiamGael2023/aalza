<?php

require_once "../controladores/captacion.controlador.php";
require_once "../modelos/captacion.modelo.php";

class tablaCaptacion{

    public function mostrartablaCaptacion() {
        $item = null;
        $valor = null;

        $captacion = ControladorCaptacion::ctrMostrarCaptacion($item, $valor); 

        if (count($captacion) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($captacion as $key => $captaciones) {
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $estructura = '<td>'.utf8_encode($captaciones["estructura"]).'</td>';
            $nombre = '<td>'.utf8_encode($captaciones["nombre"]).'</td>';
            $progresiva = '<td>'.$captaciones["progresiva"].'</td>';
            $obrapaquete = '<td>'.utf8_encode($captaciones["obrapaquete"]).'</td>';
            $junta = '<td>'.utf8_encode($captaciones["junta"]).'</td>';
            $comision = '<td>'.utf8_encode($captaciones["comision"]).'</td>';
            $bloque = '<td>'.utf8_encode($captaciones["bloque"]).'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-light-warning btnEditarMarcaMedidor" id='.$captaciones["id"].' data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#exampleModalEditar"><i class="fas fa-edit"></i></a>'
                       . '<a type="button" class="btn btn-light-danger btnEliminarMarcaMedidor" data-idmarcamedidor='.$captaciones["id"].'><i class="feather icon-trash-2"></i></a>'
                       . '</div></td>';
                        
            $fila = array(
                $numeroFila,
                $estructura,
                $nombre,
                $progresiva,
                $obrapaquete,
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

$activarCaptacion = new tablaCaptacion();
$activarCaptacion->mostrartablaCaptacion();

?>