<?php

ob_start();

require_once "../controladores/medidorempresa.controlador.php";
require_once "../modelos/medidorempresa.modelo.php";

require_once '../lib/phpqrcode/qrlib.php';

class tablaMedidorEmpresa{

    public function mostrartablaMedidorEmpresa() {
        $item = null;
        $valor = null;

        $medidor = ControladorMedidorEmpresa::ctrMostrarMedidorEmpresa($item, $valor); 
        
        if (!is_array($medidor)) {
            $medidor = [];
        }
        
        $datos = array();

        foreach ($medidor as $key => $medidores) {
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $medidor = '<td>'.$medidores["codigo"].'</td>';
            $persona = '<td>'.$medidores["razonsocial"].'</td>';
            $abreviatura = '<td>'.utf8_encode($medidores["abreviatura"]).'</td>';
            
            $qrData = $medidores['id'];  // Usamos el id como contenido del QR

            // Generar el QR y guardarlo en un archivo temporal
            $tempDir = 'temp_qr_codes/';  // Carpeta temporal donde guardaremos los códigos QR generados
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);  // Crear la carpeta si no existe
            }
            $fileName = $tempDir . 'qr_' . $medidores['id'] . '.png';  // Nombre del archivo QR
            QRcode::png($qrData, $fileName, 'L', 4, 2);  // Generar el QR en formato PNG

            // Aquí pasamos la ruta del archivo y no el Base64
            $qrImagePath = $fileName;

            // Modificar la imagen QR para que al hacer clic se abra el modal
            $qrImageUrl = 'https://www.chavimochic.gob.pe/SGRHI_app/ajax/' . $qrImagePath;

$qr = '<td><img src="' . $qrImageUrl . '" alt="QR" width="100" height="100"></td>';

            
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-sm btn-warning p-1 btnEditarMedidorEmpresa" id='.$medidores["id"].' data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#exampleModalEditar"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l11 0" /><path d="M9 12l11 0" /><path d="M9 18l11 0" /><path d="M5 6l0 .01" /><path d="M5 12l0 .01" /><path d="M5 18l0 .01" /></svg></a>'
                       . '<a type="button" class="btn btn-sm btn-danger p-1 btnEliminarJunta" data-idjunta='.$medidores["id"].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-x">
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
                $medidor,
                $persona,
                $abreviatura,
                $qr,
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

$activarmedidorempresa = new tablaMedidorEmpresa();
$activarmedidorempresa->mostrartablaMedidorEmpresa();

?>

