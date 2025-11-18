<?php
require_once 'modelos/conexion.php';

$id_expediente = 15;

echo "<h2>Test Pisos - Expediente $id_expediente</h2>";

try {
    $db = Conexion::conectar();
    
    // Verificar tablas que contienen 'piso'
    echo "<h3>Tablas con 'piso':</h3>";
    $stmt = $db->query("SHOW TABLES LIKE '%piso%'");
    $tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<pre>";
    print_r($tablas);
    echo "</pre>";
    
    // Intentar leer de la tabla 'pisos'
    echo "<h3>Pisos en la tabla 'pisos':</h3>";
    $stmt = $db->prepare("SELECT * FROM pisos WHERE id_expediente = :id_expediente");
    $stmt->bindParam(":id_expediente", $id_expediente, PDO::PARAM_INT);
    $stmt->execute();
    $pisos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p><strong>Cantidad:</strong> " . count($pisos) . "</p>";
    echo "<pre>";
    print_r($pisos);
    echo "</pre>";
    
    // Mostrar estructura de la tabla
    echo "<h3>Estructura de la tabla 'pisos':</h3>";
    $stmt = $db->query("DESCRIBE pisos");
    $estructura = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border='1'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th></tr>";
    foreach ($estructura as $campo) {
        echo "<tr>";
        echo "<td>{$campo['Field']}</td>";
        echo "<td>{$campo['Type']}</td>";
        echo "<td>{$campo['Null']}</td>";
        echo "<td>{$campo['Key']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Verificar el área libre del cuadro de pisos
    echo "<h3>Cálculo de Área Libre:</h3>";
    
    if (count($pisos) > 0) {
        $totalAreaPisos = 0;
        $totalAreaAdicional = 0;
        
        foreach ($pisos as $piso) {
            // Verificar qué campos tiene
            echo "<p><strong>Piso:</strong> {$piso['nombre_nivel']}</p>";
            echo "<p>Campos disponibles:</p>";
            echo "<pre>";
            print_r(array_keys($piso));
            echo "</pre>";
            
            // Intentar obtener áreas
            $areaPiso = isset($piso['area_piso']) ? floatval($piso['area_piso']) : 0;
            $areaAdicional = isset($piso['area_adicional']) ? floatval($piso['area_adicional']) : 0;
            
            $totalAreaPisos += $areaPiso;
            $totalAreaAdicional += $areaAdicional;
            
            echo "<p>Área Piso: $areaPiso, Área Adicional: $areaAdicional</p>";
        }
        
        echo "<hr>";
        echo "<p><strong>Total Área Pisos:</strong> $totalAreaPisos m²</p>";
        echo "<p><strong>Total Área Adicional:</strong> $totalAreaAdicional m²</p>";
        
        $areaTerreno = 3719.98; // Tu área de terreno
        $areaLibre = $areaTerreno - ($totalAreaPisos + $totalAreaAdicional);
        
        echo "<p><strong>Área Terreno:</strong> $areaTerreno m²</p>";
        echo "<p><strong>Área Libre Calculada:</strong> $areaLibre m²</p>";
    } else {
        echo "<p style='color: red;'><strong>NO HAY PISOS REGISTRADOS</strong></p>";
        echo "<p>Debes ir al tab de PISOS y configurar los pisos del proyecto primero.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Error:</strong> {$e->getMessage()}</p>";
}
?>