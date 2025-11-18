<?php

require_once "../controladores/archivo.controlador.php";
require_once "../modelos/archivo.modelo.php";

class AjaxArchivo {
    public function ajaxCrearArchivo() {
        $respuesta = ControladorArchivo::ctrIngresarArchivo();
        echo $respuesta;
    }
    
    public function ajaxCrearArchivoId() {
        $respuesta = ControladorArchivo::ctrIngresarArchivoId();
        echo $respuesta;
    }
    
    public function ajaxCrearArchivoNombre() {
        // Verifica si se han recibido archivos y el nombre de la carpeta
        if (isset($_FILES['archivonombre'])) {
            error_log(print_r($_FILES['archivonombre'], true));
            // Llamamos al controlador para procesar el archivo y guardar el nombre en la base de datos
            $respuesta = ControladorArchivo::ctrIngresarArchivoNombre($_FILES['archivonombre']);
            echo $respuesta;  // Devolvemos la respuesta del controlador
        } else {
            echo json_encode(array("status" => "error", "message" => "No se ha seleccionado ningún archivo o falta el nombre de la carpeta."));
        }
    }
    
    public function ajaxCrearArchivoNombreid() {
        // Verifica si se han recibido archivos y el nombre de la carpeta
        if (isset($_FILES['archivonombreid'])) {
            error_log(print_r($_FILES['archivonombreid'], true));
            // Llamamos al controlador para procesar el archivo y guardar el nombre en la base de datos
            $respuesta = ControladorArchivo::ctrIngresarArchivoNombreid($_FILES['archivonombreid']);
            echo $respuesta;  // Devolvemos la respuesta del controlador
        } else {
            echo json_encode(array("status" => "error", "message" => "No se ha seleccionado ningún archivo o falta el nombre de la carpeta."));
        }
    }
    
    public function ajaxArchivoDelete() {
            $respuesta = ControladorArchivo::ctrBorrarArchivo();
            echo $respuesta;
    }
}


if (isset($_POST["nombre"])) {
    $crear = new AjaxArchivo();
    $crear->ajaxCrearArchivo();
}

if (isset($_POST["nombreid"])) {
    $crear = new AjaxArchivo();
    $crear->ajaxCrearArchivoId();
}

if (isset($_FILES["archivonombre"])) {
    $crear = new AjaxArchivo();
    $crear->ajaxCrearArchivoNombre();
}

if (isset($_FILES["archivonombreid"])) {
    $crear = new AjaxArchivo();
    $crear->ajaxCrearArchivoNombreid();
}

if (isset($_POST["idarchivo"])) {
    $crear = new AjaxArchivo();
    $crear->ajaxArchivoDelete();
}