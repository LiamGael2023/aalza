<?php

ob_start();
require_once "../controladores/comision.controlador.php";
require_once "../modelos/comision.modelo.php";

class tablaComision{

    public function mostrartablaComision() {
        $item = null;
        $valor = null;

        $comision = ControladorComision::ctrMostrarComision($item, $valor); 
        
        if (!is_array($comision)) {
            $comision = [];
        }
        
        $datos = array();

        foreach ($comision as $key => $comisiones) {
            
            if ($comisiones["junta"] == 0){
                $junta="No tiene";
            }else{
                $junta = $comisiones["junta"];
            }
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $junta = '<td>'.utf8_encode($junta).'</td>';
            $comision = '<td>'.utf8_encode($comisiones["comision"]).'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-light-warning btnEditarComision" id='.$comisiones["id"].' data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#exampleModalEditar"><i class="fas fa-edit"></i></a>'
                       . '<a type="button" class="btn btn-light-danger btnEliminarComision" data-idcomision='.$comisiones["id"].'><i class="feather icon-trash-2"></i></a>'
                       . '</div></td>';
                        
            $fila = array(
                $numeroFila,
                $comision,
                $junta,
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

$activarComision = new tablaComision();
$activarComision->mostrartablaComision();

?>