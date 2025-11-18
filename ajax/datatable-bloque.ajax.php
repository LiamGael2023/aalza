<?php

ob_start();
require_once "../controladores/bloque.controlador.php";
require_once "../modelos/bloque.modelo.php";

class tablaBloque{

    public function mostrartablaBloque() {
        $item = null;
        $valor = null;

        $bloque = ControladorBloque::ctrMostrarBloque($item, $valor); 

        if (!is_array($bloque)) {
            $bloque = [];
        }
        
        $datos = array();

        foreach ($bloque as $key => $bloques) {
            
            if ($bloques["junta"] == 0){
                $junta="No tiene";
            }else{
                $junta = $bloques["junta"];
            }
            
            if ($bloques["comision"] == 0){
                $comision="No tiene";
            }else{
                $comision = $bloques["comision"];
            }   
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $junta = '<td>'.utf8_encode($junta).'</td>';
            $comision = '<td>'.utf8_encode($comision).'</td>';
            $codigo = '<td>'. utf8_encode($bloques["codigo"]).'</td>';
            $nombre = '<td>'.utf8_encode($bloques["nombre"]).'</td>';
            $abreviatura = '<td>'.utf8_encode($bloques["abreviatura"]).'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-light-warning btnEditarMarcaMedidor" id='.$bloques["id"].' data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#exampleModalEditar"><i class="fas fa-edit"></i></a>'
                       . '<a type="button" href="#" class="btn btn-light-secondary" title="Asignar Capatación" onclick="redirectToBloqueDetail('.$bloques["id"].')"><i class="fas fa-list"></i></a>'
                       . '<a type="button" class="btn btn-light-danger btnEliminarMarcaMedidor" data-idmarcamedidor='.$bloques["id"].'><i class="feather icon-trash-2"></i></a>'
                       . '</div></td>';
                        
            $fila = array(
                $numeroFila,
                $junta,
                $comision,
                $codigo,
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

$activarBloque = new tablaBloque();
$activarBloque->mostrartablaBloque();

?>