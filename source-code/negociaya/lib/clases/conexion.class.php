<?php
// muestra alguna información adicional para debug en caso de ser true
$conexion_debug = true;

class Conexion
{
    /*nombre del usuario del manejador de base de datos*/
    private $_usuario;
    /*Contraseña del usuario del manejador de base de datos*/
    private $_contrasena;
    /*Nombre del servidor del manejador de base de datos*/
    private $_servidor;
    /*nombre de la Base de Datos*/
    private $_bd;

    /*Es el identificador del enlace a la base de datos*/
    private $_enlace;

    /*Son el número de registros seleccionados cuando se realiza un
    SELECT en la base de datos o el número de registros afectados cuando
    se realiza un UPDATE, DELETE o INSERT en la base de datos*/
    private $_registrosAfecctados = 0;
    
    /*Ultimo error arrojado por el manejador de la Base de Datos
    Es un Array de 4 posiciones la primera, con indice 0, y la tercera con indice "numero"
    son el número del error; y la segunda, con indice 1, y la cuarta con indice "texto"
    es el texto arrojado por el error*/
    private $_error;
    
    /*Guarda el último SQL ejecutado*/
    private $_sql;
    
    /*Resultado de una consulta o una ejecución en la base de datos*/
    private $_resultado;
    
    //El constructor nos conecta la base de datos
    public function Conexion($usuario = "", $contrasena = "", $servidor = "", $bd = "", $driver = "")
    {
        //Se colocan los parametros necesarios para iniciar la conexion con la base de datos
        if ($usuario == "") {
            $this->setUsuario("negociay_anuncio");
            // $this->setUsuario("jeyson_bd");
        } else {
            $this->setUsuario($usuario);
        }
        
        if ($contrasena == "") {
            $this->setContrasena("ALx!W/WC.g-G");
            // $this->setContrasena("jeyson2008");
        } else {
            $this->setContrasena($contrasena);
        }
        
        if ($servidor == "") {
            $this->setServidor("localhost");
        } else {
            $this->setServidor($servidor);
        }
        
        if ($bd == "") {
            $this->setBd("negociay_anuncio");
            // $this->setBd("jeyson_bd");
        } else {
            $this->setBd($bd);
        }
        
        //Se coloca por defecto que no hay error
        $this->_setError(0);
        
        //Se abrela conexion con la base de datos
        //La conexión se debe inicializar después de crear el objeto
        //$this->conectar();
    }

    // Destructor
    /*public function __destruct(){
        @mysql_close($this->getEnlace());
    }*/
    
    //Analizadores
    public function getUsuario()
    {
        return $this->_usuario;
    }
    
    public function getContrasena()
    {
        return $this->_contrasena;
    }
    
    public function getServidor()
    {
        return $this->_servidor;
    }
    
    public function getBd()
    {
        return $this->_bd;
    }
    
    public function &getEnlace()
    {
        return $this->_enlace;
    }
    
    public function getRegistrosAfecctados()
    {
        return $this->_registrosAfecctados;
    }
    
    public function getError($cual = "array")
    {
        if (($cual === "numero") || ($cual === 0) || ($cual === "texto") || ($cual === 1) || ($cual === "info") || ($cual === 2)) {
            return $this->_error[$cual];
        } else {
            return $this->_error;
        }
    }
    
    public function getSql()
    {
        return $this->_sql;
    }
    
    public function getTextoError($info = false)
    {
        $return = "Error (".$this->getError("numero")."): ".$this->getError("texto");
        
        if ($info)
        {
            $return .= " (".$this->getError("info").")";
        }
        
        return $return;
    }
    
    private function &_getResultado()
    {
        return $this->_resultado;
    }

    //Modificadores
    public function setUsuario($usuario)
    {
        $this->_usuario = $usuario;
    }
    
    public function setContrasena($contrasena)
    {
        $this->_contrasena = $contrasena;
    }
    
    public function setServidor($servidor)
    {
        $this->_servidor = $servidor;
    }
    
    public function setBd($bd)
    {
        $this->_bd = $bd;
    }
    
    public function setEnlace(&$enlace)
    {
        $this->_enlace = $enlace;
    }
    
    private function _setRegistrosAfecctados($registrosAfecctados)
    {
        $this->_registrosAfecctados = $registrosAfecctados;
    }
    
    private function _setError($error = "")
    {
        if ($error === "") {
            $this->_error = array(@mysql_errno($this->getEnlace()), @mysql_error($this->getEnlace()), $this->getSql());
            $this->_error["numero"] = $this->_error[0];
            $this->_error["texto"] = $this->_error[1];
            $this->_error["info"] = $this->_error[2];
        } elseif (is_array($error)) {
            $this->_error = $error;
            if (!isset($error["numero"]) || !isset($error["texto"]) || !isset($error["info"]))
            {
                $this->_error["numero"] = $this->_error[0];
                $this->_error["texto"] = $this->_error[1];
                $this->_error["info"] = $this->_error[2];
            }
        } elseif ($error === 0) {
            $this->_error = array(0, "", "", "numero" => 0, "texto" => "", "info" => "");
        }
    }
    
    private function _setSql($sql)
    {
        $this->_sql = $sql;
    }
    
    private function _setResultado(&$resultado)
    {
        $this->_resultado = $resultado;
    }

    // Funciones
    // Abre la conexion a la base de datos
    public function conectar()
    {
        $this->setEnlace(@mysql_connect($this->getServidor(), $this->getUsuario(), $this->getContrasena()));
        if ($this->getEnlace() === false) {
            (@mysql_errno() == 2003) ? $this->_setError(array(2003, "No Hay Conexión a la Base de Datos")) : $this->_setError(array(@mysql_errno(), @mysql_error()));
        }
        
        return $this->getEnlace();
    }
    
    //Realiza una consulta en la BD.  Retorna true en caso de exito y false de lo contrario
    public function consultar($SQL)
    {
        $this->_setSql($SQL);
        $this->_setResultado(@mysql_db_query($this->getBd(), $this->getSql(), $this->getEnlace()));
        if ($this->_getResultado()) {
            $this->_setRegistrosAfecctados(@mysql_num_rows($this->_getResultado()));
            $this->_setError(0);
            return true;
        } else {
            $this->_setRegistrosAfecctados(0);
            if ($this->getEnlace() !== false) {
                $this->_setError();
            } else {
                $this->_setError(array(2003, "No Hay Conexión a la Base de Datos"));
            }
            return false;
        }
    }
    
    //Ejecuta una consulta en la BD (INSERT, UPDATE, DROP).  Retorna true en caso de exito y false de lo contrario
    public function ejecutar($SQL)
    {
        $this->_setSql($SQL);
        $this->_setResultado(@mysql_db_query($this->getBd(), $this->getSql(), $this->getEnlace()));
        if ($this->_getResultado()) {
            $this->_setRegistrosAfecctados(@mysql_affected_rows($this->getEnlace()));
            $this->_setError(0);
            return true;
        } else {
            $this->_setRegistrosAfecctados(0);
            if ($this->getEnlace() !== false) {
                $this->_setError();
            } else {
                $this->_setError(array(2003, "No Hay Conexión a la Base de Datos"));
            }
            return false;
        }
    }
    
    //Desconecta la BD
    public function desconectar()
    {
        @mysql_close($this->getEnlace());
    }
    
    //Imprime el último error devuelto por la base de datos
    public function printError($info = false)
    {
        echo "Error Número: ".$this->getError("numero").".  ".$this->getError("texto");
        
        if ($info)
        {
            echo " (".$this->getError("info").")";
        }
    }
    
    //Obtiene el último id autoincrement generado por la base de datos
    public function getIdGenerado()
    {
        return @mysql_insert_id($this->getEnlace());
    }

    //Combierte el resultado de una consulta en una matriz, retorna false en caso de error
    public function consulta2matriz($liberar = true)
    {
        if (!$this->getRegistrosAfecctados()) {
            return false;
        }
        $matriz = array();
        $this->resetResultado();
        while (($registro = $this->sacarRegistro())) {
            $matriz[] = $registro;
        }
        if ($liberar) {
            @mysql_free_result($this->_getResultado());
        }
        return ((count($matriz) == 0) ? false : $matriz);
    }
    
    //Extrae un Registro del resultado de una consulta y lo devuelve como un array
    public function sacarRegistro()
    {
        return @mysql_fetch_array($this->_getResultado(), MYSQL_ASSOC);
    }
    
    public function resetResultado()
    {
        @mysql_data_seek($this->_getResultado(), 0);
    }
    
    //Empieza una transaccion
    public function iniciarTransaccion()
    {
        $this->ejecutar("SET AUTOCOMMIT = 0");
        $this->ejecutar("START TRANSACTION");
    }
    
    //Finaliza una transaccion
    public function finalizarTransaccion($commit = true)
    {//si commit es false se hace ROLLBACK
        if ($commit === true) {
            $this->ejecutar("COMMIT");
        } else {
            $this->ejecutar("ROLLBACK");
        }
        $this->ejecutar("SET AUTOCOMMIT = 1");
    }
}
?>
