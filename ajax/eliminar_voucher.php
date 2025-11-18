<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el parámetro 'imagen' está presente
    if (isset($_POST['imagen'])) {
        $imagen = $_POST['imagen'];

        // Conectar a la base de datos
        $serverNameRP = "DESKTOP-9QOO5RP\\SQLEXPRESS";
        $connectionOptionsRP = array(
            "Database" => "sgrhi",
            "Uid" => "sa",
            "PWD" => "WDelements123"
        );
        $connRP = sqlsrv_connect($serverNameRP, $connectionOptionsRP);

        if ($connRP === false) {
            die("Error de conexión: " . print_r(sqlsrv_errors(), true));
        }

        // Eliminar el registro de la tabla
        $sql = "DELETE FROM voucher_requerimiento WHERE imagen = ?";
        $stmt = sqlsrv_query($connRP, $sql, array($imagen));

        if ($stmt === false) {
            echo "Error al eliminar el voucher: " . print_r(sqlsrv_errors(), true);
        } else {
            echo "Voucher eliminado con éxito.";
        }

        // Cerrar la conexión
        sqlsrv_close($connRP);
    } else {
        echo "No se proporcionó el nombre de la imagen.";
    }
} else {
    echo "Método no permitido.";
}
?>
