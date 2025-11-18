<?php

ob_start();

require_once "../controladores/lectura.controlador.php";
require_once "../modelos/lectura.modelo.php";

class tablaLecturaDetalle {

    public function mostrartablaLecturaDetalle() {
        $variable = isset($_POST['variable']) ? $_POST['variable'] : null;
        $item = 'idlectura';
        $valor = $variable;

        $lecturadetalle = ControladorLectura::ctrMostrarLecturaDetalle($item, $valor);

        if (count($lecturadetalle) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($lecturadetalle as $key => $lecdetalle) {
            $fechaOriginal = $lecdetalle["fechai"];
            $fechai = $fechaOriginal instanceof DateTime 
                ? $fechaOriginal->format('d/m/Y') 
                : date('d/m/Y', strtotime($fechaOriginal));
            
            $consumo = number_format($lecdetalle["volconsumo"] - $lecdetalle["lectura_anterior"], 0, '.', ',');
            $lectura_anterior = number_format($lecdetalle["lectura_anterior"], 0, '.', ',');
            $volconsumo = number_format($lecdetalle["volconsumo"], 0, '.', ',');
            
            $toma = $lecdetalle["nombre"];
            $tipo = $lecdetalle["Tipo"];
            
            $captacion = $toma . ' - ' . $tipo; 
            
            $lote = $lecdetalle["lotes_unidad_catastral"];
            
            $botones = '<div class="btn-group btn-group-sm" role="group">'
                     . '<a type="button" class="btn btn-sm btn-warning p-1 btnEditarrequerimiento" id='.$lecdetalle["id"].' data-bs-toggle="modal" data-bs-target=".bd-example-modal-lgEdit" title="Editar Registro"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>'
                     . '<a type="button" class="btn btn-sm btn-danger p-1 btnEliminarrequerimiento" data-id='.$lecdetalle["id"].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-x">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
      <path d="M4 6v6c0 1.657 3.582 3 8 3c.537 0 1.062 -.02 1.57 -.058" />
      <path d="M20 13.5v-7.5" />
      <path d="M4 12v6c0 1.657 3.582 3 8 3c.384 0 .762 -.01 1.132 -.03" />
      <path d="M22 22l-5 -5" />
      <path d="M17 22l5 -5" />
    </svg></a>'
                     . '</div>';
            
            $fila = array(
                $key + 1,  // Número de fila
                $lecdetalle["razonsocial"],
                $captacion,
                $lote,
                $lecdetalle["codigo"], // Código del medidor
                $fechai, // Fecha
                $lectura_anterior, // Lectura anterior
                $volconsumo, // Lectura actual
                $consumo, // Consumo
                $botones // Acciones en formato HTML
            );

            $datos[] = $fila;
        }

        echo json_encode(array("data" => $datos));
    }
}

$activarLecturaDetalle = new tablaLecturaDetalle();
$activarLecturaDetalle->mostrartablaLecturaDetalle();