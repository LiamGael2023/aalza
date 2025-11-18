<?php

require_once "../controladores/derechouso.controlador.php";
require_once "../modelos/derechouso.modelo.php";

class tablaDerechoUsoPoblacional{

    public function mostrartablaDerechoUsoPoblacional() {
        $item = null;
        $valor = null;

        $derechouso = ControladorDerechoUso::ctrMostrarDerechoUsoPoblacional($item, $valor); 

        if (count($derechouso) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($derechouso as $key => $derechousos) {
            
            if ($derechousos["estado"]=="Activo"){
                $estado = '<button type="button" class="btn btn-icon btn-success avtar-s mb-0" title="'.$derechousos["estado"].'"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg></button>';
            }else if($derechousos["estado"]=="Inactivo"){
                $estado = '<button type="button" class="btn btn-icon btn-danger avtar-s mb-0" title="'.$derechousos["estado"].'"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg></button>';
            }else if($derechousos["estado"]=="Extinto"){
                $estado = '<button type="button" class="btn btn-icon btn-info avtar-s mb-0" title="'.$derechousos["estado"].'"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg></button>';
            }else if($derechousos["estado"]=="Sancionado"){
                $estado = '<button type="button" class="btn btn-icon btn-warning avtar-s mb-0" title="'.$derechousos["estado"].'"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg></button>';
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

$activarDerechoUso = new tablaDerechoUsoPoblacional();
$activarDerechoUso->mostrartablaDerechoUsoPoblacional();

?>