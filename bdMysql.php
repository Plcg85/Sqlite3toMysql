<?php

class bdMysql
{
    private $_SERVER = "localhost";
    private $_USER = "root";
    private $_PASS = "";
    private $_NOMBREBD = "MisCuentas";
    public $_CONNECTION;

    //constructor
    function __construct()
    {
        $this->_CONNECTION = new mysqli($this->_SERVER, $this->_USER, $this->_PASS, $this->_NOMBREBD);

        if ($this->_CONNECTION->connect_error) {
            die("Error de conexion: " . $this->_CONNECTION->connect_error);
        }
    }

    //destructor
    //hay que tener en cuenta que es llamado cuando el objeto deja de estar en primer plano o es destruido por el programador a mano unset($dbMysql)
    function __destruct()
    {
        // Cerrar la conexión a la base de datos al destruir el objeto
        if (isset($this->_CONNECTION)) {
            $this->_CONNECTION->close();
            echo "Conexión MySQL cerrada.<br>";
        }
    }

    /**************************************************************************************/
    /**************************************************************************************/

    function crearEstructuraMysql()
    {
        $this->crearTablaGastosPuntuales();
        $this->crearTablaGastosFijos();
        $this->crearTablaIngresosFijos();
        $this->crearTablaIngresosPuntuales();
    }

    //crea la tabla Gastos puntuales si no existe
    function crearTablaGastosPuntuales()
    {
        // Crear la tabla
        $sql = "CREATE TABLE IF NOT EXISTS gastospuntuales (
            id INT AUTO_INCREMENT PRIMARY KEY,
            concepto VARCHAR(100) NOT NULL,
            cantidad  FLOAT NOT NULL,
            dia INT NOT NULL,
            mes INT NOT NULL,
            anio INT NOT NULL,
            tipogastocorriente VARCHAR(50),
            UNIQUE (concepto, cantidad, dia, mes, anio, tipogastocorriente))";
        $this->ejecutarSentenciasCreadoTablas($sql);
    }
    //crear la tabla GAstos fijos
    function crearTablaGastosFijos()
    {
        // Crear la tabla
        $sql = "CREATE TABLE IF NOT EXISTS gastosfijos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            conceptogastosfijos VARCHAR(100) NOT NULL,
            cantidadfijamensualgasto  FLOAT NOT NULL,
            tipogastofijo VARCHAR(50),
            UNIQUE (conceptogastosfijos, cantidadfijamensualgasto, tipogastofijo))";
        $this->ejecutarSentenciasCreadoTablas($sql);
    }
    //crear la tabla ingresos fijos
    function crearTablaIngresosFijos()
    {
        // Crear la tabla
        $sql = "CREATE TABLE IF NOT EXISTS ingresosfijos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            conceptoingresosfijos VARCHAR(100) NOT NULL,
            cantidadfijamensualingresosfijos  FLOAT NOT NULL,
            UNIQUE (conceptoingresosfijos, cantidadfijamensualingresosfijos))";
        $this->ejecutarSentenciasCreadoTablas($sql);
    }
    //crear la tabla ingresos puntuales
    function crearTablaIngresosPuntuales()
    {
        // Crear la tabla
        $sql = "CREATE TABLE IF NOT EXISTS ingresospuntuales (
            id INT AUTO_INCREMENT PRIMARY KEY,
            conceptoingresospuntuales VARCHAR(100) NOT NULL,
            cantidadingresospuntuales  FLOAT NOT NULL,
            diaingresospuntuales INT NOT NULL,
            mesingresospuntuales INT NOT NULL,
            anioingresospuntuales INT NOT NULL,
            UNIQUE (conceptoingresospuntuales, cantidadingresospuntuales, mesingresospuntuales,anioingresospuntuales))";
        $this->ejecutarSentenciasCreadoTablas($sql);
    }
    //esta funcion es llamada por todas las que crean tablas
    function ejecutarSentenciasCreadoTablas($sentencia)
    {
        if ($this->_CONNECTION->query($sentencia) === TRUE) {
            echo "Tabla creada exitosamente.<br>";
        } else {
            echo "Error al crear la tabla: " . "<br>";
        }
    }
    //metodo prepare para sentencias preparadas
    // Método para preparar una consulta
    public function prepare($query)
    {
        $stmt = $this->_CONNECTION->prepare($query);

        // Verificar si la consulta fue preparada correctamente
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->_CONNECTION->error);
        }

        return $stmt; // Retorna el objeto mysqli_stmt
    }
}
