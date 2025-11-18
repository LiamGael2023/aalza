<?php

ob_start();

require_once "../controladores/redhidrografica.controlador.php";
require_once "../modelos/redhidrografica.modelo.php";

class tablaRedHidrografica{

    public function mostrartablaRedHidrografica() {
        $item = null;
        $valor = null;

        $RedHidrografica = ControladorRedHidrografica::ctrMostrarRedHidrografica($item, $valor); 
        
        if (!is_array($RedHidrografica)) {
            $junta = [];
        }
        
        $datos = array();

        foreach ($RedHidrografica as $key => $RedHidrograficas) {
            
            $fechaingresoOriginal = $RedHidrograficas["fechaingreso"];
            if ($fechaingresoOriginal instanceof DateTime) {
                $fechaingreso = $fechaingresoOriginal->format('d/m/Y');
            } else {
                $fechaingreso = date('d/m/Y', strtotime($fechaingresoOriginal));
            }
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>';
            $descripcion = '<td>'.utf8_encode($RedHidrograficas["descripcion"]).'</td>';
            $categoria = trim($RedHidrograficas["nombre"]);
            $fechaingreso = '<td>'.$fechaingreso.'</td>';
            $ubicacion = '<td>'.utf8_encode($RedHidrograficas["ubicacion"]).'</td>';
            $botones = '<td class="sort-category py-0" style="width: 1px; white-space: nowrap;">'
                       . '<div class="btn-group" role="group">'
                       . '<a type="button" class="btn btn-sm btn-warning p-1 btnEditarRed" id='.$RedHidrograficas["id"].' data-bs-toggle="modal" data-bs-target=".bd-example-modal-lgEdit" title="Editar Registro"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>'
                       . '<a type="button" class="btn btn-sm btn-secondary" id='.$RedHidrograficas["id"].' onclick="redirectToDetail('.$RedHidrograficas["id"].')" title="Caudales Circulantes"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-wave-right-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 14h4v-4" /><path d="M3 12c.887 1.284 2.48 2.033 4 2c1.52 .033 3.113 -.716 4 -2s2.48 -2.033 4 -2c1.52 -.033 3 1 4 2l2 2" /></svg></a>'
                       . '<a type="button" class="btn btn-sm btn-danger p-1 btnEliminarRed" data-ideliminar='.$RedHidrograficas["id"].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-x">
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
                $descripcion,
                $categoria,
                $fechaingreso,
                $ubicacion,
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

$activarRedHidrografica = new tablaRedHidrografica();
$activarRedHidrografica->mostrartablaRedHidrografica();

?>