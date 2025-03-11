<!--Este archivo gestiona la base de datos sqlite-->
<?php

require "/xampp/htdocs/convertirSqliteToMysql/consultas.php";

//funcion para obtener todos los datos de una columna sqlite.
function convertirDatos($consultaSqlite)
{
    try {
        // Conexión a la base de datos SQLite
        $db = new SQLite3('./database/MisCuentas.db');

        // Consulta de datos
        $resultado = $db->query($consultaSqlite);

        if(strpos($consultaSqlite,"gastospuntuales"))
        {
            copiarAMysqlGastosPuntuales($resultado);
        }
        if(strpos($consultaSqlite,"gastosfijos"))
        {
            copiarAMysqlGastosFijos($resultado);
        }
        if(strpos($consultaSqlite,"ingresosfijos"))
        {
            copiarAMysqlIngresosFijo($resultado);
        }
        if(strpos($consultaSqlite,"ingresospuntuales"))
        {
            copiarAMysqlIngresosPuntuales($resultado);   
        }

        $db->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function copiarAMysqlGastosPuntuales($resultado)
{
    echo "Copiando Gastos Puntuales" . "<br>";
    $conexionMysql = new bdMysql();
    $stmt = $conexionMysql->prepare("INSERT IGNORE INTO gastospuntuales (concepto, cantidad, dia, mes, anio, tipogastocorriente) 
                                 VALUES (?, ?, ?, ?, ?, ?)");

    // Vincular los parámetros
    $stmt->bind_param("sdiiis", $concepto, $cantidad, $dia, $mes, $anio, $tipogastocorriente);

    while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)) {
        //echo $fila['concepto'] . " " . $fila['cantidad'] . "€ " . $fila['dia'] . "/" . $fila['mes'] . "/" . $fila['anio'] . ". Tipo->" . $fila['tipogastocorriente'] . "<br>";
        // Asignar los valores a las variables vinculadas
        $concepto = $fila['concepto'];
        $cantidad = $fila['cantidad'];
        $dia = $fila['dia'];
        $mes = $fila['mes'];
        $anio = $fila['anio'];
        $tipogastocorriente = $fila['tipogastocorriente'];

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            echo "Error al insertar la fila: " . $stmt->error . "<br>";
        } else {
            //echo "Fila insertada correctamente: " . $concepto . "<br>";
        }
    }
    $stmt->close();
    echo "Final copiando Gastos Puntuales" . "<br>";
}

//funcion que copia a mysql los gastos fijos
function copiarAMysqlGastosFijos($resultado)
{
    echo "copiando gastos fijos" . "<br>";
    $conexionMysql = new bdMysql();
    $stmt = $conexionMysql->prepare("INSERT IGNORE INTO gastosfijos (conceptogastosfijos, cantidadfijamensualgasto,tipogastofijo) 
                                 VALUES (?, ?, ?)");

    // Vincular los parámetros
    $stmt->bind_param("sds", $conceptogastosfijos, $cantidadfijamensualgasto,$tipogastofijo);

    while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)) {

        $conceptogastosfijos = $fila['conceptogastosfijos'];
        $cantidadfijamensualgasto = $fila['cantidadfijamensualgasto'];
        $tipogastofijo = $fila['tipogastofijo'];

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            echo "Error al insertar la fila: " . $stmt->error . "<br>";
        } else {
            //echo "Fila insertada correctamente: " . $concepto . "<br>";
        }
    }
    $stmt->close();
    echo "Final copiando Gastos Fijos" . "<br>";
}

function copiarAMysqlIngresosFijo($resultado)
{
    echo "copiando ingresos fijos" . "<br>";
    $conexionMysql = new bdMysql();
    $stmt = $conexionMysql->prepare("INSERT IGNORE INTO ingresosfijos (conceptoingresosfijos, cantidadfijamensualingresosfijos) 
                                 VALUES (?, ?)");

    // Vincular los parámetros
    $stmt->bind_param("sd", $conceptoingresosfijos, $cantidadfijamensualingresosfijos);

    while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)) {

        $conceptoingresosfijos = $fila['conceptoingresosfijos'];
        $cantidadfijamensualingresosfijos = $fila['cantidadfijamensualingresosfijos'];

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            echo "Error al insertar la fila: " . $stmt->error . "<br>";
        } else {
            //echo "Fila insertada correctamente: " . $concepto . "<br>";
        }
    }
    $stmt->close();
    echo "Final copiando ingresos Fijos" . "<br>";
}

//copia a la base de datos mysql los datos provenientes de una consulta sqlite
function copiarAMysqlIngresosPuntuales($resultado)
{
    echo "Copiando Ingresos Puntuales" . "<br>";
    $conexionMysql = new bdMysql();
    $stmt = $conexionMysql->prepare("INSERT IGNORE INTO ingresospuntuales (conceptoingresospuntuales, cantidadingresospuntuales, diaingresospuntuales, mesingresospuntuales, anioingresospuntuales) 
                                 VALUES (?, ?, ?, ?, ?)");

    // Vincular los parámetros
    $stmt->bind_param("sdiii", $conceptoingresospuntuales, $cantidadingresospuntuales, $diaingresospuntuales, $mesingresospuntuales, $anioingresospuntuales);

    while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)) {
        
        //echo $fila['conceptoingresospuntuales'] . " " . $fila['cantidadingresospuntuales'] . "€ " . $fila['diaingresospuntuales'] . "/" . $fila['mesingresospuntuales'] . "/" . $fila['anioingresospuntuales']  . "<br>";
        
        $conceptoingresospuntuales = $fila['conceptoingresospuntuales'];
        $cantidadingresospuntuales = $fila['cantidadingresospuntuales'];
        $diaingresospuntuales = $fila['diaingresospuntuales'];
        $mesingresospuntuales = $fila['mesingresospuntuales'];
        $anioingresospuntuales = $fila['anioingresospuntuales'];

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            echo "Error al insertar la fila: " . $stmt->error . "<br>";
        } else {
            //echo "Fila insertada correctamente: " . $concepto . "<br>";
        }
    }
    $stmt->close();
    echo "Final copiando Ingresos Puntuales" . "<br>";
}

?>