<?php
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../controladores/usuariosistema.controlador.php";
require_once "../modelos/usuariosistema.modelo.php";

class AjaxUsuarios{

	public $activarUsuario;
	public $activarId;

        public function ajaxActivarUsuario(){

		$tabla = "usuarios";

		$item1 = "estado";
		$valor1 = $this->activarUsuario;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloUsuarioSistema::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

	}
        
        public function ajaxCrearUsuarios() {
            
                $respuesta = ControladorUsuarioSistema::ctrIngresarUsuario();
                echo $respuesta;
                
        }
        
        public $idedit;
        
        public function ajaxEditarUsuarios(){

            $item = "id";
            $valor = $this->idedit;

            $respuesta = ControladorUsuarioSistema::ctrMostrarUsuarioSistema($item, $valor);
            
                        
            if ($respuesta) {
                echo json_encode($respuesta);
            } else {
                // Envía un JSON válido con mensaje de error o vacío
                echo json_encode(['error' => 'Usuario no encontrado']);
            }

        }
        
        public function ajaxUsuarioEdit() {
            $respuesta = ControladorUsuarioSistema::ctrEditarUsuarioSistema();
            echo $respuesta;
        }
        
        public function ajaxUsuariosDelete() {
            $respuesta = ControladorUsuarioSistema::ctrBorrarUsuario();
            echo $respuesta;
        }
        
}


/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["activarUsuario"])){

	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();

}

if (isset($_POST["nuevoNombre"])) {
    $crear = new AjaxUsuarios();
    $crear->ajaxCrearUsuarios();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["idedit"])) {
        $editar = new AjaxUsuarios();
        $editar->idedit = $_POST["idedit"];
        $editar->ajaxEditarUsuarios();
    }
}

if (isset($_POST["editarIdUsuario"])) {
    $crear = new AjaxUsuarios();
    $crear->ajaxUsuarioEdit();
}

if (isset($_POST["id"])) {
    $crear = new AjaxUsuarios();
    $crear->ajaxUsuariosDelete();
}