<?php

require_once "conexion.php";

class ModeloProgramacion {

    static public function mdlIngresarProgramacion($tabla, $datos) {
        $conn = Conexion::conectar();
        if ($conn === false) {
            return "error: No se pudo conectar a la base de datos.";
        }
        
        // Verificar si la semana ya existe
        $sql_check = "SELECT COUNT(*) AS count FROM $tabla WHERE semana = ?";
        $params_check = array($datos["semana"]);
        $stmt_check = sqlsrv_query($conn, $sql_check, $params_check);

        if ($stmt_check === false) {
            $errors = sqlsrv_errors();
            return "error: " . print_r($errors, true);
        }

        $row = sqlsrv_fetch_array($stmt_check, SQLSRV_FETCH_ASSOC);

        if ($row['count'] > 0) {
            // Si la semana ya existe, devolver un error
            return "error: La semana ya está registrada.";
        }

        $sql = "INSERT INTO $tabla (semana, fecha_inicio, fecha_fin, observacion) VALUES (?, ?, ?, ?)";
        $params = array($datos["semana"], $datos["fecha_inicio"], $datos["fecha_fin"], $datos["observacion"]);

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            $errors = sqlsrv_errors();
            return "error: " . print_r($errors, true);
        } else {
            return "ok";
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_free_stmt($stmt_check);
    }
    
    static public function MdlMostrarProgramacion($tabla, $item, $valor){

		$conn = Conexion::conectar();

                if ($item != null) {
                    $sql = "SELECT *,'PRO-SEM' + SUBSTRING(semana, 7, 2) + '-' + SUBSTRING(semana, 1, 4) AS SemanaFormateada FROM $tabla WHERE id = ? order by id desc";
                    $params = array($valor);

                    $stmt = sqlsrv_query($conn, $sql, $params);

                    if ($stmt === false) {
                        $errors = sqlsrv_errors();
                        error_log('Error en la consulta: ' . print_r($errors, true));
                        return []; // Asegúrate de que se devuelve un array vacío en caso de error
                    } else {
                        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                        if($result['semana']){
                            $result['semana'] = utf8_encode($result['semana']);
                        }
                        sqlsrv_free_stmt($stmt);
                        return $result ? [$result] : [];
                    }
                } else {
                    $sql = "SELECT *,'PRO-SEM' + SUBSTRING(semana, 7, 2) + '-' + SUBSTRING(semana, 1, 4) AS SemanaFormateada FROM $tabla order by id desc";

                    $stmt = sqlsrv_query($conn, $sql);

                    if ($stmt === false) {
                        $errors = sqlsrv_errors();
                        error_log('Error en la consulta: ' . print_r($errors, true));
                        return []; // Asegúrate de que se devuelve un array vacío en caso de error
                    } else {
                        $result = array();
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            
                            $result[] = $row;
                            
                        }
                        sqlsrv_free_stmt($stmt);
                        return $result;
                    }
                }

                sqlsrv_close($conn);

	}
        
        static public function mdlFinalizarProgramacion($tabla, $id, $estado) {
            $conn = Conexion::conectar(); // Conexión a la base de datos

            // Consulta SQL para actualizar el estado
            $sql = "UPDATE $tabla SET estado = ? WHERE id = ?";
            $params = array($estado, $id);

            // Ejecutar la consulta
            $stmt = sqlsrv_query($conn, $sql, $params);

            // Verificar si la consulta fue exitosa
            if ($stmt === false) {
                return json_encode(array("status" => "error", "message" => "Hubo un error al actualizar el estado"));
            } else {
                return json_encode(array("status" => "success", "message" => "La programación ha sido finalizada"));
            }

            // Liberar la consulta
            sqlsrv_free_stmt($stmt);
        }
}
