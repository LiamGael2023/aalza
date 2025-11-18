<?php

require_once "../controladores/lote.controlador.php";
require_once "../modelos/lote.modelo.php";

class tablaLote{

    public function mostrartablaLote() {
        $item = null;
        $valor = null;

        $lote = ControladorLote::ctrMostrarLote($item, $valor); 

        if (count($lote) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($lote as $key => $lotes) {
            
            if ($lotes["junta"] == 0){
                $junta="No tiene";
            }else{
                $junta = $lotes["junta"];
            }
            
            if ($lotes["comision"] == 0){
                $comision="No tiene";
            }else{
                $comision = $lotes["comision"];
            }   
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $junta = '<td>'. utf8_encode($junta).'</td>';
            $comision = '<td>'.utf8_encode($comision).'</td>';
            $bloque = '<td>'.utf8_encode($lotes["bloque"]).'</td>';
            $nropredio = '<td>'.utf8_encode($lotes["nro_predio"]).'</td>';
            $codigo = '<td>'.utf8_encode($lotes["codigo"]).'</td>';
            $unidad_catastral = '<td>'.utf8_encode($lotes["unidad_catastral"]).'</td>';
            $area_total = '<td>'.$lotes["area_total"].'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-light-warning btnEditarMarcaMedidor" id='.$lotes["id"].' data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#exampleModalEditar"><i class="fas fa-edit"></i></a>'
                       . '<a type="button" class="btn btn-light-danger btnEliminarMarcaMedidor" data-idmarcamedidor='.$lotes["id"].'><i class="feather icon-trash-2"></i></a>'
                       . '</div></td>';
                        
            $fila = array(
                $numeroFila,
                $junta,
                $comision,
                $bloque,
                $nropredio,
                $codigo,
                $unidad_catastral,
                $area_total,
                $botones
            );

            $datos[] = $fila;
        }

        echo json_encode(array("data" => $datos));
    }
}

$activarLote = new tablaLote();
$activarLote->mostrartablaLote();

?>