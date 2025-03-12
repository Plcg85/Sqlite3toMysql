<?php
//drop tables gastospuntuales,gastosfijos,ingresospuntuales,ingresosfijos;

require "bdMysql.php";
require "bdSqlite.php";

recibirBaseDatos(); //se recibe la base de datos proveniente del script comprobarFormulario.js y se copia en el directorio adecuado para que pueda ser leido

creaDbMysql(); // crea la base de datos y las tablas para pasar datos de una base de datos a otra.

//estos metodos estan en el script bdSqlite.php
convertirDatos(consultas::$sqlGastosPuntuales);
convertirDatos(consultas::$sqlGastosFijos);
convertirDatos(consultas::$sqlIngresosFijos);
convertirDatos(consultas::$sqlIngresosPuntuales);

borrarArchivo(); //se debe borrar la base de datos del directorio ./database/ para que pueda ser utilizado en la siguiente ejecucion


echo "Terminado";

/******************************************************************************************************* */
/******************************************************************************************************* */
//recibe la base de datos desde index.html y la coloca en el directorio ./database/
function recibirBaseDatos()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
        // Ruta de destino
        $directorioDestino = "./database/";

        // Verificar que la carpeta ./database/ exista, si no, crearla
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0777, true); // Crear la carpeta con permisos
        }

        // Obtener información del archivo
        $nombreArchivo = $_FILES['archivo']['name']; // Nombre del archivo subido
        $rutaTemporal = $_FILES['archivo']['tmp_name']; // Ruta temporal del archivo en el servidor

        // Definir la ruta final del archivo
        $rutaDestino = $directorioDestino . $nombreArchivo;

        // Mover el archivo a la carpeta ./database/
        if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
            echo "Archivo subido exitosamente a la ruta: " . $rutaDestino;
        } else {
            echo "Error al mover el archivo a la carpeta destino.";
        }
    } else {
        echo "No se ha recibido ningún archivo.";
    }
}

//borra el archivo de la base de datos en la ruta ./database/
function borrarArchivo()
{
    // Ruta del archivo
    $archivo = "./database/MisCuentas.db";

    // Verificar si el archivo existe
    if (file_exists($archivo)) {
        // Intentar borrar el archivo
        if (unlink($archivo)) {
            echo "El archivo 'MisCuentas.db' se ha borrado correctamente.";
        } else {
            echo "Error: No se pudo borrar el archivo.";
        }
    } else {
        echo "El archivo 'MisCuentas.db' no existe en el directorio.";
    }
}

//crea la base de datos en mysql para despues rellenarla
function creaDbMysql()
{
    $dbMysql = new bdMysql();
    $dbMysql->crearEstructuraMysql();
}
