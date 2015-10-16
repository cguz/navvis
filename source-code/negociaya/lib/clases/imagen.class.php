<?php
class Imagen
{
    private $_id;

    private $_url;

    private $_anuncio_id;

    private $_ruta;

    // Getters

    public function getId()
    {
        return $this->_id;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function getAnuncio_id()
    {
        return $this->_anuncio_id;
    }

    public function getRuta()
    {
        return $this->_ruta;
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

    public function setUrl($url)
    {
        $this->_url = $url;
    }

    public function setAnuncio_id($anuncio_id)
    {
        $this->_anuncio_id = $anuncio_id;
    }

    public function setRuta($ruta)
    {
        $this->_ruta = $ruta;
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

    // Agrega un Imagenes a la base de datos
    public function guardar($conexion = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $atributos_class = $this->getAtributosClass();
            unset($atributos_class['id']);
            
            $SQL = "INSERT INTO imagen (".implode(", ", $atributos_class).")\n VALUES ('".$this->getUrl()."', ".$this->getAnuncio_id().", '".$this->getRuta()."')";
            
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

    // Edita un Imagenes de la base de datos
    public function editar($conexion = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $valores_editar = $this->getAtributos();
            
            if ($this->cargarBD($conexion))
            {
                $valores_bd = $this->getAtributos();
                
                $valores_sql = array();
                foreach ($valores_editar as $clave => $valor)
                {
                    if ($valores_bd[$clave] != $valor)
                    {
                        $valores_sql[] = "$clave = '$valor'";
                    }
                }
                
                if (count($valores_sql) != 0)
                {
                    $SQL = "UPDATE imagen SET ".implode(", ", $valores_sql)." WHERE id = ".$this->getId()."\n";
                }
                else
                {
                    return -1;
                }
                
                return $conexion->ejecutar($SQL);
            }
        }
        
        return false;
    }

    // Elimina un Imagenes de la base de datos
    public function eliminar($conexion = false, $anuncio_id = "")
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $where_id = "WHERE id = ".$this->getId();
            if ($anuncio_id != "")
            {
                $where_id = "WHERE anuncio_id = $anuncio_id";
            }
            
            $SQL = "DELETE FROM imagen $where_id\n";
            
            // print "SQL = <pre>$SQL</pre><hr>";
            
            return $conexion->ejecutar($SQL);
        }
        
        return false;
    }

    // Busca un Imagenes en la BD a través del Id del objeto actual y coloca estos valores en los atributos del objeto
    public function cargarBD($conexion = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $atributos_class = $this->getAtributosClass();
            
            $SQL = "SELECT ".implode(", ", $atributos_class)." FROM imagen WHERE id = ".$this->getId()."\n";
            
            if ($conexion->consultar($SQL))
            {
                $row = $conexion->sacarRegistro();
                
                $this->setAtributos($row);
                
                return true;
            }
        }
        
        return false;
    }

    // Retorna un array de objetos Imagenes con los valores en BD, se puede usar paginación
    public function listar($conexion = false, $totalxpagina = 20, $pagina = 0, $ordenar_por = '', $ordenar_dir = '')
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $SQL = 'SELECT count(id) AS total FROM imagen';
            
            if ($conexion->consultar($SQL))
            {
                $row = $conexion->sacarRegistro();
                
                $total_bd = $row["total"];
                
                $atributos_class = $this->getAtributosClass();
                
                $SQL = "SELECT ".implode(", ", $atributos_class)." FROM imagen";
                
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
                        $objetos[$i] = new Imagen();
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
}
?>
