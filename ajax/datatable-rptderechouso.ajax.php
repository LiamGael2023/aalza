<?php

require_once "../controladores/derechouso.controlador.php";
require_once "../modelos/derechouso.modelo.php";

class tablaRptDerechoUso{

    public function mostrartablaRptDerechoUso() {
        $item = null;
        $valor = null;

        // Captura el filtro de Razón Social
        $razonSocial = isset($_GET['razonSocial']) ? $_GET['razonSocial'] : null;

        $derechouso = ControladorDerechoUso::ctrMostrarRptDerechoUso($item, $valor, $razonSocial);

        if (count($derechouso) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($derechouso as $key => $derechousos) {
                
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $razonsocial = '<td>'. utf8_encode($derechousos["razonsocial"]).'</td>';
            $tipodoc = '<td>'.utf8_encode($derechousos["tipodoc"]).'</td>';
            $nrodocumento = '<td>'.utf8_encode($derechousos["nrodocumento"]).'</td>';
            $unidad_catastral = '<td>'.utf8_encode($derechousos["unidad_catastral"]).'</td>';
            $areatotal = '<td>'.utf8_encode($derechousos["areatotal"]).'</td>';
            $arealicencia = '<td>'.utf8_encode($derechousos["arealicencia"]).'</td>';
            $junta = '<td>'.utf8_encode($derechousos["junta"]).'</td>';
            $tipouso = '<td>'.utf8_encode($derechousos["tipouso"]).'</td>';
            $vol_otorgado = '<td>'.utf8_encode($derechousos["vol_otorgado"]).'</td>';
            $resolucion = '<td>'.utf8_encode($derechousos["resolucion"]).'</td>';
                        
            $fila = array(
                $numeroFila,
                $razonsocial,
                $tipodoc,
                $nrodocumento,
                $resolucion,
                $unidad_catastral,
                $areatotal,
                $arealicencia,
                $vol_otorgado,
                $junta
            );

            $datos[] = $fila;
        }

        echo json_encode(array("data" => $datos));
    }
}

$activarDerechoUso = new tablaRptDerechoUso();
$activarDerechoUso->mostrartablaRptDerechoUso();

?>