<?php

ob_start();

require_once "../controladores/lectura.controlador.php";
require_once "../modelos/lectura.modelo.php";

class tablaLecturas{

    public function mostrartablaLecturas() {
        $item = null;
        $valor = null;

        $lectura = ControladorLectura::ctrMostrarLecturas($item, $valor); 
        
        if (!is_array($lectura)) {
            $lectura = [];
        }
        
        $datos = array();

        foreach ($lectura as $key => $lecturas) {
            
            $fechaingresoOriginal = $lecturas["fecha_inicio"];
            if ($fechaingresoOriginal instanceof DateTime) {
                $fechaingreso = $fechaingresoOriginal->format('d/m/Y');
            } else {
                $fechaingreso = date('d/m/Y', strtotime($fechaingresoOriginal));
            }
            
            $fechaterminoOriginal = $lecturas["fecha_termino"];
            if ($fechaterminoOriginal instanceof DateTime) {
                $fechatermino = $fechaterminoOriginal->format('d/m/Y');
            } else {
                $fechatermino = date('d/m/Y', strtotime($fechaterminoOriginal));
            }
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $lectura = '<td>'.utf8_encode($lecturas["lectura"]).'</td>';
            $fechaini = '<td>'.$fechaingreso.'</td>';
            $fechafin = '<td>'.$fechatermino.'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-sm btn-warning p-1 btnEditarLectura" id='.$lecturas["id"].' data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#exampleModalEditar"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>'
                       . '<a type="button" href="#" class="btn btn-sm btn-secondary p-1" title="Toma de Lecturas" onclick="redirectToLecturaDetail('.$lecturas["id"].')"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-wave-right-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 14h4v-4" /><path d="M3 12c.887 1.284 2.48 2.033 4 2c1.52 .033 3.113 -.716 4 -2s2.48 -2.033 4 -2c1.52 -.033 3 1 4 2l2 2" /></svg></a>'
                       . '<a type="button" class="btn btn-sm btn-danger p-1 btnEliminarLectura" data-idjunta='.$lecturas["id"].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-x">
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
                $numeroFila,
                $lectura,
                $fechaini,
                $fechafin,
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

$activarLectura = new tablaLecturas();
$activarLectura->mostrartablaLecturas();

?>