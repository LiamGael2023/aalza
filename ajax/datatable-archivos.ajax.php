<?php

ob_start();

require_once "../controladores/archivo.controlador.php";
require_once "../modelos/archivo.modelo.php";

class tablaArchivo {
    public function mostrartablaArchivo() {
        $item = null;
        $valor = null;

        // Obtener los datos desde el controlador que hace la consulta al procedimiento almacenado
        $archivo = ControladorArchivo::ctrMostrarArchivo($item, $valor); 
        
        if (!is_array($archivo)) {
            $archivo = [];
        }
        
        $datos = array();

        // Definir la URL base correcta (solo para la descarga)
        $baseURL = "https://www.chavimochic.gob.pe/SGRHI_app/vistas/modulos/uploads/";

        foreach ($archivo as $key => $archivos) {
            // Obtener la extensión del archivo
            $extension = strtolower(pathinfo($archivos["name"], PATHINFO_EXTENSION));

            // Mantener el nombre original del archivo sin modificarlo
            $filePath = $baseURL . $archivos["path"];

            // Ruta física del archivo en el servidor
            // Asegúrate de usar la ruta correcta en el sistema de archivos del servidor
            $physicalFilePath = "D:\\SISTEMAS\\SGRHI\\vistas\\modulos\\" . $archivos["path"];

            // Verificar si es un archivo o una carpeta
            if (is_file($physicalFilePath)) {
                // Si es un archivo, calcular el tamaño del archivo
                if (file_exists($physicalFilePath)) {
                    $sizeInBytes = filesize($physicalFilePath); // Obtener el tamaño en bytes

                    // Convertir a tamaño adecuado (KB, MB, GB)
                    if ($sizeInBytes < 1024) {
                        $size = $sizeInBytes . ' Bytes'; // Mostrar en bytes si es menor a 1KB
                    } elseif ($sizeInBytes < 1048576) {
                        $sizeInKB = round($sizeInBytes / 1024, 2); // Convertir a KB
                        $size = $sizeInKB . ' KB'; // Mostrar en KB
                    } elseif ($sizeInBytes < 1073741824) {
                        $sizeInMB = round($sizeInBytes / 1048576, 2); // Convertir a MB
                        $size = $sizeInMB . ' MB'; // Mostrar en MB
                    } else {
                        $sizeInGB = round($sizeInBytes / 1073741824, 2); // Convertir a GB
                        $size = $sizeInGB . ' GB'; // Mostrar en GB
                    }
                } else {
                    $size = "Archivo no encontrado"; // Mostrar mensaje si el archivo no existe
                }
            } elseif (is_dir($physicalFilePath)) {
                // Si es una carpeta, calcular el tamaño total de la carpeta
                $totalSizeInBytes = $this->getFolderSize($physicalFilePath); // Llamada a la función que calcula el tamaño de la carpeta

                // Convertir a tamaño adecuado (KB, MB, GB)
                if ($totalSizeInBytes < 1024) {
                    $size = $totalSizeInBytes . ' Bytes'; // Mostrar en bytes si es menor a 1KB
                } elseif ($totalSizeInBytes < 1048576) {
                    $totalSizeInKB = round($totalSizeInBytes / 1024, 2); // Convertir a KB
                    $size = $totalSizeInKB . ' KB'; // Mostrar en KB
                } elseif ($totalSizeInBytes < 1073741824) {
                    $sizeInMB = round($totalSizeInBytes / 1048576, 2); // Convertir a MB
                    $size = $sizeInMB . ' MB'; // Mostrar en MB
                } else {
                    $sizeInGB = round($totalSizeInBytes / 1073741824, 2); // Convertir a GB
                    $size = $sizeInGB . ' GB'; // Mostrar en GB
                }
            }

            // Asignar íconos dependiendo de la extensión y generar enlaces
            if ($extension == 'jpeg' || $extension == 'jpg') {
                $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-jpg"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" /><path d="M5 15h3v4.5a1.5 1.5 0 0 1 -3 0" /></svg>';
                $numeroFila = '<td style="text-align: left !important;">' . $icono . '&nbsp;<a href="'.$filePath.'" download="'.$archivos["name"].'">'.$archivos["name"].'</a></td>';
            } elseif ($extension == 'png') {
                $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-png"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M11 21v-6l3 6v-6" /></svg>';
                $numeroFila = '<td style="text-align: left !important;">' . $icono . '&nbsp;<a href="'.$filePath.'" download="'.$archivos["name"].'">'.$archivos["name"].'</a></td>';
            } elseif ($extension == 'pdf') {
                $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M17 18h2" /><path d="M20 15h-3v6" /><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /></svg>';
                $numeroFila = '<td style="text-align: left !important;">' . $icono . '&nbsp;<a href="'.$filePath.'" download="'.$archivos["name"].'">'.$archivos["name"].'</a></td>';
            } else {
                $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folder folder-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>';
                $numeroFila = '<td style="text-align: left !important;">' . $icono . '&nbsp;<a href="#" onclick="redirectToNav('.$archivos["id"].')">'.$archivos["name"].'</a></td>';
            }

            // Mostrar el tamaño del archivo
            $size = '<td style="text-align: left !important;">' . $size . '</td>';

            // Botones de Editar y Eliminar
            $botones = '<td class="sort-category py-0" style="width: 1px; white-space: nowrap;">
                <div class="btn-group" role="group">
                    <a class="btn btn-sm btn-danger p-1 btnEliminarArchivo" data-idarchivo='.$archivos["id"].' title="Eliminar">
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
                    <a class="btn btn-sm btn-info p-1" href="https://www.chavimochic.gob.pe/SGRHI_app/shared/compartir.php?token='.$archivos["share_token"].'" target="_blank" title="Compartir">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-share"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M8.7 10.7l6.6 -3.4" /><path d="M8.7 13.3l6.6 3.4" /></svg>
                    </a>
                </div>
            </td>';
            
            $fila = array(
                $numeroFila,  // Deja esta celda vacía
                $size,  // Muestra el tamaño en MB, KB o GB
                $botones   // Aquí agregamos los botones de acción
            );

            $datos[] = $fila;
        }

        // Devolver los datos en formato JSON
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

    // Función para calcular el tamaño de una carpeta
    private function getFolderSize($folderPath) {
        $totalSize = 0;
        
        // Verifica si la carpeta existe
        if (is_dir($folderPath)) {
            // Abre el directorio
            $dir = opendir($folderPath);

            // Lee el contenido del directorio
            while (($file = readdir($dir)) !== false) {
                // Ignora los directorios "." y ".."
                if ($file != '.' && $file != '..') {
                    $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

                    // Si es un archivo, suma su tamaño
                    if (is_file($filePath)) {
                        $totalSize += filesize($filePath);
                    }
                    // Si es una carpeta, llama recursivamente a la función
                    if (is_dir($filePath)) {
                        $totalSize += $this->getFolderSize($filePath);  // Llamada recursiva
                    }
                }
            }

            // Cierra el directorio
            closedir($dir);
        }

        return $totalSize;
    }
}

$activarArchivo = new tablaArchivo();
$activarArchivo->mostrartablaArchivo();

?>
