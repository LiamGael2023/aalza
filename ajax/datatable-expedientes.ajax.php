<?php

ob_start();

require_once "../controladores/expediente.controlador.php";
require_once "../modelos/expediente.modelo.php";

class TablaExpediente {
    
    public function mostrarTablaExpediente() {

        $item = null;
        $valor = null;

        $expedientes = ControladorExpediente::ctrMostrarExpediente($item, $valor); 

        if (!is_array($expedientes)) {
            $expedientes = [];
        }

        $datos = [];

        foreach ($expedientes as $key => $exp) {

            // --- Obtener datos de manera segura ---
            $id_expediente = $exp["id_expediente"] ?? 0;
            $numero_expediente = $exp["numero_expediente"] ?? "Sin número";
            $propietario = $exp["propietario"] ?? "---";
            $zonificacion = $exp["zonificacion"] ?? "---";
            $ubicacion = $exp["ubicacion"] ?? "---";
            $area_terreno = $exp["area_terreno"] ?? "0.00";
            $created_at = $exp["created_at"] ?? null;

            // --- Formatear fecha ---
            $fechaCreacion = $this->formatDate($created_at);

            // --- Columnas ---
            $numeroFila = '<td style="text-align: center;">' . ($key + 1) . '</td>';
            
            $colNumeroExpediente = '<td>' . htmlspecialchars($numero_expediente) . '</td>';
            
            $colPropietario = '<td>' . htmlspecialchars($propietario) . '</td>';
            
            $colZonificacion = '<td>' . htmlspecialchars($zonificacion) . '</td>';
            
            $colUbicacion = '<td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="' . htmlspecialchars($ubicacion) . '">' 
                          . htmlspecialchars($ubicacion) . '</td>';
            
            $colAreaTerreno = '<td style="text-align: right;">' . number_format($area_terreno, 2) . ' m²</td>';
            
            $colFechaCreacion = '<td style="text-align: center;">' . htmlspecialchars($fechaCreacion) . '</td>';

            // --- Botones ---
            $botones = '
<td class="sort-category py-0" style="width: 1px; white-space: nowrap;">
  <div class="btn-group" role="group">
    <button class="btn btn-sm btn-info p-1 btnVerExpediente" 
            data-id="' . (int)$id_expediente . '" 
            title="Ver Detalle">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
        <circle cx="12" cy="12" r="3"></circle>
      </svg>
    </button>
    <button class="btn btn-sm btn-warning p-1 btnEditarExpediente" 
            data-id="' . (int)$id_expediente . '" 
            title="Editar"
            onclick="console.log(\'ID desde onclick:\', ' . (int)$id_expediente . ')">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
      </svg>
    </button>
    <button class="btn btn-sm btn-danger p-1 btnEliminarExpediente"
            data-id="' . (int)$id_expediente . '"
            data-numero="' . htmlspecialchars($numero_expediente) . '"
            title="Eliminar">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
      </svg>
    </button>
  </div>
</td>';

            // --- Armar fila final ---
            $fila = [
                $numeroFila,
                $colNumeroExpediente,
                $colPropietario,
                $colZonificacion,
                $colUbicacion,
                $colAreaTerreno,
                $colFechaCreacion,
                $botones
            ];

            $datos[] = $fila;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["data" => $datos]);

        // Limpia buffer
        ob_end_flush();
    }

    private function formatDate($date) {
        if (empty($date) || $date === '0000-00-00' || $date === null) {
            return '-';
        }

        // Si viene en formato DateTime
        if ($date instanceof DateTime) {
            return $date->format('d/m/Y');
        }

        // Si viene en string
        $timestamp = strtotime($date);
        if ($timestamp === false || $timestamp <= 0) {
            return '-';
        }

        return date('d/m/Y', $timestamp);
    }
}

$activarExpediente = new TablaExpediente();
$activarExpediente->mostrarTablaExpediente();

?>