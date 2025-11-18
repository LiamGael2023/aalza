<?php

require_once "../controladores/derechouso.controlador.php";
require_once "../modelos/derechouso.modelo.php";

class tablaDerechoUsoOtrosUsos{

    public function mostrartablaDerechoUsoOtrosUsos() {
        $item = null;
        $valor = null;

        $derechouso = ControladorDerechoUso::ctrMostrarDerechoUsoOtrosUsos($item, $valor); 

        if (count($derechouso) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($derechouso as $key => $derechousos) {
            
            if ($derechousos["estado"]=="Activo"){
                $estado = '<button type="button" class="btn btn-icon btn-success avtar-s mb-0" title="'.$derechousos["estado"].'"><i class="ti ti-circle-check"></i></button>';
            }else if($derechousos["estado"]=="Inactivo"){
                $estado = '<button type="button" class="btn btn-icon btn-danger avtar-s mb-0" title="'.$derechousos["estado"].'"><i class="ti ti-alert-triangle"></i></button>';
            }else if($derechousos["estado"]=="Extinto"){
                $estado = '<button type="button" class="btn btn-icon btn-info avtar-s mb-0" title="'.$derechousos["estado"].'"><i class="ti ti-info-circle"></i></button>';
            }else if($derechousos["estado"]=="Sancionado"){
                $estado = '<button type="button" class="btn btn-icon btn-warning avtar-s mb-0" title="'.$derechousos["estado"].'"><i class="ti ti-triangle"></i></button>';
            }
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $resolucion = '<td>'. utf8_encode($derechousos["resolucion"]).'</td>';
            $usuario = '<td>'.utf8_encode($derechousos["razonsocial"]).'</td>';
            $tipousuario = '<td>'.utf8_encode($derechousos["tipouso"]).'</td>';
            $estado = '<td>'.$estado.'</td>';
                        
            $fila = array(
                $numeroFila,
                $resolucion,
                $usuario,
                $tipousuario,
                $estado
            );

            $datos[] = $fila;
        }

        echo json_encode(array("data" => $datos));
    }
}

$activarDerechoUso = new tablaDerechoUsoOtrosUsos();
$activarDerechoUso->mostrartablaDerechoUsoOtrosUsos();

?>