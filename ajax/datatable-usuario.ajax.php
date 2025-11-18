<?php

ob_start();

require_once "../controladores/usuariosistema.controlador.php";
require_once "../modelos/usuariosistema.modelo.php";

class tablaUsuarios{

    public function mostrartablaUsuarios() {
        $item = null;
        $valor = null;

        $usuariosistema = ControladorUsuarioSistema::ctrMostrarUsuarioSistema($item, $valor); 
        
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
            $nombre = '<td>'.utf8_encode($usuariosistemas["nombre"]).'</td>';
            $usuario = '<td>'.utf8_encode($usuariosistemas["usuario"]).'</td>';
            $perfil = '<td>'.utf8_encode($usuariosistemas["descripcion"]).'</td>';
            $estado = '<td>'.$estado.'</td>';
            $ultimologin = '<td>' . $fechaFormateada . '</td>';
            
            $botones = '<td class="sort-category py-0" style="width: 1px; white-space: nowrap;">
  <div class="btn-group" role="group">
  <a type="button" class="btn btn-sm btn-warning p-1 btnEditarUsuario" idedit='.$usuariosistemas["id"].' role="button" aria-label="Editar" title="Editar" data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#exampleModalEditar">
    <!-- Icono editar -->
    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
  </a>
  <a class="btn btn-sm btn-danger p-1 btnEliminarUsuario" data-id='.$usuariosistemas["id"].'>
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
                $nombre,
                $usuario,
                $perfil,
                $estado,
                $ultimologin,
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

$activarUsuarios = new tablaUsuarios();
$activarUsuarios->mostrartablaUsuarios();

?>