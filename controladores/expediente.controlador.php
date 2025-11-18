<?php
class ControladorExpediente {
    
    // Método existente - Mostrar expedientes
    static public function ctrMostrarExpediente($item, $valor){
        $tabla = "expedientes";
        $respuesta = ModeloExpediente::MdlMostrarExpediente($tabla, $item, $valor);
        return $respuesta;
    }
    
    // NUEVO - Crear expediente
    static public function ctrCrearExpediente($datos){
        $tabla = "expedientes";
        $respuesta = ModeloExpediente::mdlCrearExpediente($tabla, $datos);
        return $respuesta;
    }
    
    // NUEVO - Editar expediente
    static public function ctrEditarExpediente($datos){
        $tabla = "expedientes";
        $respuesta = ModeloExpediente::mdlEditarExpediente($tabla, $datos);
        return $respuesta;
    }
    
    // NUEVO - Eliminar expediente
    static public function ctrEliminarExpediente($id){
        $tabla = "expedientes";
        $respuesta = ModeloExpediente::mdlEliminarExpediente($tabla, $id);
        return $respuesta;
    }
    
    // NUEVO - Obtener último número
    static public function ctrObtenerUltimoNumero(){
        $tabla = "expedientes";
        $respuesta = ModeloExpediente::mdlObtenerUltimoNumero($tabla);
        return $respuesta;
    }
}
?>