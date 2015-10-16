<?php
class Usuario
{
    private $_id;

    private $_nombre;

    private $_email;

    private $_telefono;

    private $_contrasena;

    private $_administrador;

    private $_mostrar_tel;

    // Getters

    public function getId()
    {
        return $this->_id;
    }

    public function getNombre()
    {
        return $this->_nombre;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getTelefono()
    {
        return $this->_telefono;
    }

    public function getContrasena($encriptar = false)
    {
        if ($encriptar === true)
        {
            return $this->_encriptar($this->_contrasena);
        }
        
        return $this->_contrasena;
    }

    public function _encriptar($cadena)
    {
        return sha1($cadena);
    }

    public function getAdministrador()
    {
        return $this->_administrador;
    }

    public function getMostrar_tel()
    {
        return $this->_mostrar_tel;
    }

    public function getAtributosClass()
    {
        $vars = array_keys(get_object_vars($this));
        
        foreach ($vars as $valor)
        {
            $atributos[substr($valor, 1)] = substr($valor, 1);
        }
        
        return $atributos;
    }

    public function getAtributos()
    {
        $atributos = array();
        
        $atributos_class = $this->getAtributosClass();
        
        foreach ($atributos_class as $valor)
        {
            eval('$atributos[$valor] = $this->get'.ucwords($valor).'();');
        }
        
        return $atributos;
    }

    // Setters

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function setNombre($nombre)
    {
        $this->_nombre = $nombre;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function setTelefono($telefono)
    {
        $this->_telefono = $telefono;
    }

    public function setContrasena($contrasena)
    {
        $this->_contrasena = $contrasena;
    }

    public function setAdministrador($administrador)
    {
        $this->_administrador = $administrador;
    }

    public function setMostrar_tel($mostrar_tel)
    {
        $this->_mostrar_tel = $mostrar_tel;
    }

    public function setAtributos($atributos)
    {
        if (is_array($atributos))
        {
            $atributos_class = $this->getAtributosClass();
            
            foreach ($atributos_class as $valor)
            {
                if (isset($atributos[$valor]))
                {
                    eval('$this->set'.ucwords($valor).'($atributos["'.$valor.'"]);');
                }
            }
        }
    }

    // Agrega un Usuario a la base de datos
    public function guardar($conexion = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $atributos_class = $this->getAtributosClass();
            unset($atributos_class['id']);
            
            $SQL = "INSERT INTO usuario (".implode(", ", $atributos_class).")\n VALUES ('".$this->getNombre()."', '".$this->getEmail()."', '".$this->getTelefono()."', '".$this->getContrasena(true)."', '".$this->getAdministrador()."', '".$this->getMostrar_tel()."')";
            
            // print "SQL = <pre>$SQL</pre><hr>";
            
            if ($conexion->ejecutar($SQL))
            {
                $this->setId($conexion->getIdGenerado());
                return true;
            }
            
            return false;
        }
        
        return false;
    }

    // Edita un Usuario de la base de datos
    public function editar($conexion = false, $ignorar_vacios = true)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $valores_editar = $this->getAtributos();
            
            // print "valores_editar = <pre>";print_r($valores_editar);print "</pre><hr>";
            
            if ($this->cargarBD($conexion))
            {
                $valores_bd = $this->getAtributos();
                
                // print "valores_bd = <pre>";print_r($valores_bd);print "</pre><hr>";
                
                $valores_sql = array();
                foreach ($valores_editar as $clave => $valor)
                {
                    if (($valores_bd[$clave] != $valor) && !(strlen($valor) == 0 && $ignorar_vacios))
                    {
                        $valores_sql[] = "$clave = '$valor'";
                    }
                }
                
                if (count($valores_sql) != 0)
                {
                    $SQL = "UPDATE usuario SET ".implode(", ", $valores_sql)." WHERE id = ".$this->getId()."\n";
                    
                    // print "SQL = <pre>$SQL</pre><hr>";
                }
                else
                {
                    return -1;
                }
                
                // return true;
                return $conexion->ejecutar($SQL);
            }
        }
        
        return false;
    }

    // Elimina un Usuario de la base de datos
    public function eliminar($conexion = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $SQL = "DELETE FROM usuario WHERE id = ".$this->getId()."\n";
            
            return $conexion->ejecutar($SQL);
        }
        
        return false;
    }

    // Busca un Usuario en la BD a través del Id del objeto actual y coloca estos valores en los atributos del objeto
    public function cargarBD($conexion = false, $porEmail = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $atributos_class = $this->getAtributosClass();
            
            if ($porEmail)
            {
                $SQL = "SELECT ".implode(", ", $atributos_class)." FROM usuario WHERE email = '".$this->getEmail()."'\n";
            }
            else
            {
                $SQL = "SELECT ".implode(", ", $atributos_class)." FROM usuario WHERE id = ".$this->getId()."\n";
            }
            
            if ($conexion->consultar($SQL))
            {
                if ($conexion->getRegistrosAfecctados() > 0)
                {
                    $row = $conexion->sacarRegistro();
                    
                    $this->setAtributos($row);
                    
                    return true;
                }
            }
        }
        
        return false;
    }

    // Retorna un array de objetos Usuario con los valores en BD, se puede usar paginación
    public function listar($conexion = false, $totalxpagina = 20, $pagina = 0, $ordenar_por = '', $ordenar_dir = '')
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $SQL = 'SELECT count(id) AS total FROM usuario';
            
            if ($conexion->consultar($SQL))
            {
                $row = $conexion->sacarRegistro();
                
                $total_bd = $row["total"];
                
                $atributos_class = $this->getAtributosClass();
                
                $SQL = "SELECT ".implode(", ", $atributos_class)." FROM usuario";
                
                if ($ordenar_por != '' && $ordenar_dir != '')
                {
                    $SQL .= "\nORDER BY $ordenar_por $ordenar_dir";
                }
                
                if ($totalxpagina > 0 && $pagina >= 0)
                {
                    $SQL .= "\nLIMIT $pagina, $totalxpagina";
                }
                
                if ($conexion->consultar($SQL))
                {
                    $objetos = array();
                    $i = 0;
                    while ($row = $conexion->sacarRegistro())
                    {
                        $objetos[$i] = new Usuario();
                        $objetos[$i]->setAtributos($row);
                        $i++;
                    }
                    
                    if (count($objetos) > 0)
                    {
                        return array("total_bd" => $total_bd, "objetos" => $objetos);
                    }
                }
            }
        }
        
        return false;
    }
    
    // Valida el usuario y la contraseña en la BD
    public function validarLogin($conexion = false, $admin = 0)
    {
        if (is_object($conexion) && get_class($conexion) == "Conexion" && $conexion->getEnlace())
        {
            $atributos_class = $this->getAtributosClass();
            
            $SQL = "SELECT ".implode(", ", $atributos_class)." FROM usuario WHERE email = '".$this->getEmail()."' AND contrasena = '".$this->getContrasena(true)."'";
            
            if ($admin == 1)
            {
                $SQL .= " AND administrador = '1'";
            }
            /*
            else
            {
                $SQL .= " AND administrador = '0'";
            }
            */
            
            // print "SQL = <pre>$SQL</pre><hr>";
            
            if ($conexion->consultar($SQL) && $conexion->getRegistrosAfecctados() > 0)
            {
                $row = $conexion->sacarRegistro();
                
                $this->setAtributos($row);
                
                if ($admin != 1)
                {
                    $this->setAdministrador(0);
                }
                
                return true;
            }
        }
        
        return false;
    }
} 
?>
