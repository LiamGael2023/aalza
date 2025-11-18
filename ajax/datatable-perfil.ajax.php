<?php

ob_start();

require_once "../controladores/perfilsistema.controlador.php";
require_once "../modelos/perfilsistema.modelo.php";

class tablaPerfil{

    public function mostrartablaPerfil() {
        $item = null;
        $valor = null;

        $usuariosistema = ControladorPerfilSistema::ctrMostrarPerfilSistema($item, $valor); 
        
        if (!is_array($usuariosistema)) {
            $usuariosistema = [];
        }
        
        $datos = array();

        foreach ($usuariosistema as $key => $usuariosistemas) {
            
            $fechaLogin = $usuariosistemas["ultimo_login"];

            if ($fechaLogin instanceof DateTime) {
                $fechaFormateada = $fechaLogin->format('d/m/Y H:i:s');
            } else {
                $fechaFormateada = ''; // O algún mensaje como "Sin registro"
            }
            
            $estadousuario = $usuariosistemas["estado"];
            
            if($estadousuario != 0){

                $estado = '<td><button class="btn btn-success btn-xs btn-sm btnActivar" idUsuario="'.$usuariosistemas["id"].'" estadoUsuario="0">Activado</button></td>';
                    
            }else{

                $estado = '<td><button class="btn btn-danger btn-xs btn-sm btnActivar" idUsuario="'.$usuariosistemas["id"].'" estadoUsuario="1">Desactivado</button></td>';

            } 
            
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>'; // Aplicar estilo directamente
            $perfil = '<td>'.utf8_encode($usuariosistemas["descripcion"]).'</td>';
            $botones = '<td>'
                       . '<div class="btn-group btn-group-sm" role="group">'
                       . '<a type="button" class="btn btn-light-warning btnEditarUsuario" idedit='.$usuariosistemas["id"].' onclick="redirectToDetail('.$usuariosistemas["id"].')"><i class="fas fa-list"></i></a>'
                       . '<a type="button" class="btn btn-light-danger btnEliminarUsuario" data-id='.$usuariosistemas["id"].'><i class="feather icon-trash-2"></i></a>'
                       . '</div></td>';
                        
            $fila = array(
                $numeroFila,
                $perfil,
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

$activarPerfil = new tablaPerfil();
$activarPerfil->mostrartablaPerfil();

?>