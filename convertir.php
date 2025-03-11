<?php

require "bdMysql.php";
require "bdSqlite.php";


creaDbMysql();

convertirDatos(consultas::$sqlGastosPuntuales);
convertirDatos(consultas::$sqlGastosFijos);
convertirDatos(consultas::$sqlIngresosFijos);
convertirDatos(consultas::$sqlIngresosPuntuales);

echo"Terminado";

/******************************************************************************************************* */
/******************************************************************************************************* */
//crea la base de datos en mysql para despues rellenarla
function creaDbMysql()
{
    $dbMysql = new bdMysql();
    $dbMysql->crearEstructuraMysql();
}
