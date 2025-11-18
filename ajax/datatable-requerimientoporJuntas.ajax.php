<?php

ob_start();

require_once "../controladores/requerimiento.controlador.php";
require_once "../modelos/requerimiento.modelo.php";

class tablaRequerimiento{

    public function mostrartablaRequerimiento() {
        $item = "junta_id";
        $valor = isset($_COOKIE['junta_id']) ? $_COOKIE['junta_id'] : null;

        $requerimiento = ControladorRequerimiento::ctrMostrarRequerimientoJuntas($item, $valor); 
        
        if (!is_array($requerimiento)) {
            $requerimiento = [];
        }
        
        $datos = array();

        foreach ($requerimiento as $key => $requerimientos) {
            
            if ($requerimientos["tipo"]==1){
                $tipo = "Requerimiento";
            }else{
                $tipo = "Requerimiento Adicional";
            }
            
            $fechaOriginal = $requerimientos["fecha"];
            // Verificar si $fechaOriginal es un objeto DateTime
            if ($fechaOriginal instanceof DateTime) {
                $fecha = $fechaOriginal->format('d/m/Y');
            } else {
                $fecha = date('d/m/Y', strtotime($fechaOriginal));
            }
            $fechaInicio = $this->formatDate($requerimientos["fecha_inicio"]);
            
            if ($requerimientos["estado"]==0){
                $estado = '<button type="button" class="btn btn-outline-info btn-sm d-inline-flex"><i class="ti ti-info-circle me-1"></i>Registro</button>';
                $eliminar = '<a type="button" class="btn btn-light-danger btnEliminarMarcaMedidor" data-idmarcamedidor='.$requerimientos["id"].'><i class="feather icon-trash-2"></i></a>';
            }else if ($requerimientos["estado"]==1){
                $estado = '<button type="button" class="btn btn-outline-warning btn-sm d-inline-flex"><i class="ti ti-triangle me-1"></i>En Revisión</button>';
                $eliminar = '';
            }else if ($requerimientos["estado"]==2){
                $estado = '<button type="button" class="btn btn-outline-danger btn-sm d-inline-flex"><i class="ti ti-alert-triangle me-1"></i>Observado</button>';
                $eliminar = '';
            }else{
                $estado = '<button type="button" class="btn btn-outline-success btn-sm d-inline-flex"><i class="ti ti-circle-check me-1"></i>Finalizado</button>';
                $eliminar = '';
            }
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $nrorequerimiento = '<td>'.utf8_encode($requerimientos["nrorequerimiento"]).'</td>';
            $tipo = '<td>'.$tipo.'</td>';
            $fecha = '<td>'.$fecha.'</td>';
            $junta = '<td>'.utf8_encode($requerimientos["abreviatura"]).'</td>';
            $estadoReq = '<td>'.$estado.'</td>';
            $botones = '<td class="sort-category py-0" style="width: 1px; white-space: nowrap;">
  <div class="btn-group" role="group">
  <a type="button" href="#" class="btn btn-sm btn-warning p-1" role="button" aria-label="Editar" title="Detalle" onclick="redirectToRequerimientoDetail('.$requerimientos["id"].')">
    <!-- Icono editar -->
    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l11 0" /><path d="M9 12l11 0" /><path d="M9 18l11 0" /><path d="M5 6l0 .01" /><path d="M5 12l0 .01" /><path d="M5 18l0 .01" /></svg>
  </a>
  <a class="btn btn-sm btn-danger p-1 btnEliminarrequerimiento" data-idrequerimiento='.$requerimientos["id"].'>
    <!-- Icono borrar -->
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-x">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
      <path d="M4 6v6c0 1.657 3.582 3 8 3c.537 0 1.062 -.02 1.57 -.058" />
      <path d="M20 13.5v-7.5" />
      <path d="M4 12v6c0 1.657 3.582 3 8 3c.384 0 .762 -.01 1.132 -.03" />
      <path d="M22 22l-5 -5" />
      <path d="M17 22l5 -5" />
    </svg>
  </a>
</div>
</td>';
                        
            $fila = array(
                $numeroFila,
                $nrorequerimiento,
                $tipo,
                $fecha,
                $junta,
                $estadoReq,
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
    
    private function formatDate($date) {
        if ($date instanceof DateTime) {
            return $date->format('d/m/Y');
        } else {
            return date('d/m/Y', strtotime($date));
        }
    }
}

$activarJunta = new tablaRequerimiento();
$activarJunta->mostrartablaRequerimiento();

?>