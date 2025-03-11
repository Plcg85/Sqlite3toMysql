<?php
    class consultas
    {
        //Este fichero guarda las consultas a la base de datos sqlite

        //listar todos los gastos puntuales
        static $sqlGastosPuntuales = "SELECT * FROM gastospuntuales;";

        //listar todos los gastos fijos
        static $sqlGastosFijos = "SELECT * FROM gastosfijos;";

        //listar todos los ingresos fijos
        static $sqlIngresosFijos = "SELECT * FROM ingresosfijos;";

        //listar todos los ingresos puntuales
        static $sqlIngresosPuntuales = "SELECT * FROM ingresospuntuales;";
    }

?>