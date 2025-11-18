<?php

ob_start();
require_once "../controladores/persona.controlador.php";
require_once "../modelos/persona.modelo.php";

class tablaPersona{

    public function mostrartablaPersona() {
        $item = null;
        $valor = null;

        $persona = ControladorPersona::ctrMostrarPersona($item, $valor); 

        if (!is_array($persona)) {
            $persona = [];
        }
        
        $datos = array();

        foreach ($persona as $key => $personas) {
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $tipo = '<td>'.$personas["tipo"].'</td>';
            $tipodoc = '<td>'.$personas["tipodocumento"].'</td>';
            $nrodocumento = '<td>'. $personas["nrodocumento"].'</td>';
            $codigo = '<td>'.$personas["prefijo"].$personas["codigo"].'</td>';
            $razonsocial = '<td>'.utf8_encode($personas["razonsocial"]).'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-sm btn-warning p-1 btnEditarMarcaMedidor" id='.$personas["id"].' data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#exampleModalEditar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg></a>'
                       . '<a type="button" class="btn btn-sm btn-danger p-1 btnEliminarMarcaMedidor" data-idmarcamedidor='.$personas["id"].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3"></path>
                            <path d="M4 6v6c0 1.657 3.582 3 8 3c.537 0 1.062 -.02 1.57 -.058"></path>
                            <path d="M20 13.5v-7.5"></path>
                            <path d="M4 12v6c0 1.657 3.582 3 8 3c.384 0 .762 -.01 1.132 -.03"></path>
                            <path d="M22 22l-5 -5"></path>
                            <path d="M17 22l5 -5"></path>
                          </svg></a>'
                       . '</div></td>';
                        
            $fila = array(
                $numeroFila,
                $tipo,
                $tipodoc,
                $nrodocumento,
                $codigo,
                $razonsocial,
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

$activarPersona = new tablaPersona();
$activarPersona->mostrartablaPersona();

?>