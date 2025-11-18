<?php

ob_start();

require_once "../controladores/archivo.controlador.php";
require_once "../modelos/archivo.modelo.php";

class tablaArchivo{
    public function mostrartablaArchivo() {

        $item = "parent_id";
        $valor = isset($_COOKIE['id']) ? $_COOKIE['id'] : null;

        $archivo = ControladorArchivo::ctrMostrarArchivo($item, $valor); 
        if (!is_array($archivo)) {
            $archivo = [];
        }

        $datos = array();
        $baseURL = "https://www.chavimochic.gob.pe/SGRHI_app/vistas/modulos/";

        foreach ($archivo as $key => $archivos) {
            
            $correlativo = '<td style="text-align: left !important;">'.($key + 1).'</td>'; 
            
            $extension = strtolower(pathinfo($archivos["name"], PATHINFO_EXTENSION));
            $filePath = $baseURL . $archivos["path"];
            $physicalFilePath = "D:\\SISTEMAS\\minube\\vistas\\modulos\\" . $archivos["path"];

            if (is_file($physicalFilePath)) {
                if (file_exists($physicalFilePath)) {
                    $sizeInBytes = filesize($physicalFilePath);
                    if ($sizeInBytes < 1024) {
                        $size = $sizeInBytes . ' Bytes';
                    } elseif ($sizeInBytes < 1048576) {
                        $size = round($sizeInBytes / 1024, 2) . ' KB';
                    } elseif ($sizeInBytes < 1073741824) {
                        $size = round($sizeInBytes / 1048576, 2) . ' MB';
                    } else {
                        $size = round($sizeInBytes / 1073741824, 2) . ' GB';
                    }
                } else {
                    $size = "Archivo no encontrado";
                }
            } elseif (is_dir($physicalFilePath)) {
                $totalSizeInBytes = $this->getFolderSize($physicalFilePath);
                if ($totalSizeInBytes < 1024) {
                    $size = $totalSizeInBytes . ' Bytes';
                } elseif ($totalSizeInBytes < 1048576) {
                    $size = round($totalSizeInBytes / 1024, 2) . ' KB';
                } elseif ($totalSizeInBytes < 1073741824) {
                    $size = round($totalSizeInBytes / 1048576, 2) . ' MB';
                } else {
                    $size = round($totalSizeInBytes / 1073741824, 2) . ' GB';
                }
            }

            // Limitar longitud del nombre del archivo para evitar desbordes
            $maxLength = 80;
            $displayName = strlen($archivos["name"]) > $maxLength 
                ? substr($archivos["name"], 0, $maxLength - 3) . '...'
                : $archivos["name"];

            // Asignar íconos y enlaces según extensión
            if ($extension == 'jpeg' || $extension == 'jpg') {
                $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-jpg"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" /><path d="M5 15h3v4.5a1.5 1.5 0 0 1 -3 0" /></svg>';
                $numeroFila = '<td style="text-align: left !important;">' . $icono . '&nbsp;<a href="'.$filePath.'" download="'.$archivos["name"].'" title="'.$archivos["name"].'">'.$displayName.'</a></td>';
            } elseif ($extension == 'png') {
                $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-png"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M11 21v-6l3 6v-6" /></svg>';
                $numeroFila = '<td style="text-align: left !important;">' . $icono . '&nbsp;<a href="'.$filePath.'" download="'.$archivos["name"].'" title="'.$archivos["name"].'">'.$displayName.'</a></td>';
            } elseif ($extension == 'pdf') {
                $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M17 18h2" /><path d="M20 15h-3v6" /><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /></svg>';
                $numeroFila = '<td style="text-align: left !important;">' . $icono . '&nbsp;<a href="'.$filePath.'" download="'.$archivos["name"].'" title="'.$archivos["name"].'">'.$displayName.'</a></td>';
            } else {
                $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folder folder-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>';
                $numeroFila = '<td style="text-align: left !important;">' . $icono . '&nbsp;<a href="#" onclick="redirectToNav('.$archivos["id"].')" title="'.$archivos["name"].'">'.$displayName.'</a></td>';
            }

            $size = '<td style="text-align: left !important;">' . $size . '</td>';
            if (isset($archivos["created_at"])) {
    if ($archivos["created_at"] instanceof DateTime) {
        $created = $archivos["created_at"]->format('d/m/Y H:i');
    } else {
        $created = date('d/m/Y H:i', strtotime($archivos["created_at"]));
    }
} else {
    $created = '';
}


$fecha = '<td style="text-align: left !important;">' . $created . '</td>';


            $botones = '<td class="sort-category py-0" style="width: 1px; white-space: nowrap;">
                <div class="btn-group" role="group">
                    <a class="btn btn-sm btn-danger p-1 btnArchivoId" data-idarchivo='.$archivos["id"].'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" /><path d="M4 6v6c0 1.657 3.582 3 8 3c.537 0 1.062 -.02 1.57 -.058" /><path d="M20 13.5v-7.5" /><path d="M4 12v6c0 1.657 3.582 3 8 3c.384 0 .762 -.01 1.132 -.03" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                    </a>
                    <a class="btn btn-sm btn-info p-1" href="https://www.chavimochic.gob.pe/minube/shared/compartir.php?token='.$archivos["share_token"].'" target="_blank" title="Compartir">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-share"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M8.7 10.7l6.6 -3.4" /><path d="M8.7 13.3l6.6 3.4" /></svg>
                    </a>
                </div>
            </td>';

            $fila = array(
                $correlativo,
                $numeroFila,
                $size,
                $botones
            );

            $datos[] = $fila;
        }

        header('Content-Type: application/json');
        echo json_encode(array("data" => $datos));
        $output = ob_get_clean();
        echo $output;
    }

    private function getFolderSize($folderPath) {
        $totalSize = 0;
        if (is_dir($folderPath)) {
            $dir = opendir($folderPath);
            while (($file = readdir($dir)) !== false) {
                if ($file != '.' && $file != '..') {
                    $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
                    if (is_file($filePath)) {
                        $totalSize += filesize($filePath);
                    }
                    if (is_dir($filePath)) {
                        $totalSize += $this->getFolderSize($filePath);
                    }
                }
            }
            closedir($dir);
        }
        return $totalSize;
    }
}

$activarArchivo = new tablaArchivo();
$activarArchivo->mostrartablaArchivo();

?>
