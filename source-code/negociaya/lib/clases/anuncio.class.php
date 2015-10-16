<?php
class Anuncio
{
    private $_id;

    private $_codigo_ciudad;

    private $_particular;

    private $_categoria_id;

    private $_vende;

    private $_titulo;

    private $_descripcion;

    private $_precio;

    private $_publicar;

    private $_comentario;
    
    private $_usuario_id;
    
    private $_fecha;
    
    private $_contactos;
    
    private $_revisado;
    
    private $_visitas;

    // Getters

    public function getId()
    {
        return $this->_id;
    }

    public function getCodigo_ciudad()
    {
        return $this->_codigo_ciudad;
    }

    public function getParticular()
    {
        return $this->_particular;
    }

    public function getCategoria_id()
    {
        return $this->_categoria_id;
    }

    public function getVende()
    {
        return $this->_vende;
    }

    public function getTitulo()
    {
        return $this->_titulo;
    }

    public function getDescripcion()
    {
        return $this->_descripcion;
    }

    public function getPrecio()
    {
        return $this->_precio;
    }

    public function getPublicar()
    {
        return $this->_publicar;
    }

    public function getComentario()
    {
        return $this->_comentario;
    }

    public function getUsuario_id()
    {
        return $this->_usuario_id;
    }

    public function getFecha()
    {
        return $this->_fecha;
    }

    public function getContactos()
    {
        return $this->_contactos;
    }

    public function getRevisado()
    {
        return $this->_revisado;
    }

    public function getVisitas()
    {
        return $this->_visitas;
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

    public function setCodigo_ciudad($codigo_ciudad)
    {
        $this->_codigo_ciudad = $codigo_ciudad;
    }

    public function setParticular($particular)
    {
        $this->_particular = $particular;
    }

    public function setCategoria_id($categoria_id)
    {
        $this->_categoria_id = $categoria_id;
    }

    public function setVende($vende)
    {
        $this->_vende = $vende;
    }

    public function setTitulo($titulo)
    {
        $this->_titulo = $titulo;
    }

    public function setDescripcion($descripcion)
    {
        $this->_descripcion = $descripcion;
    }

    public function setPrecio($precio)
    {
        $this->_precio = $precio;
    }

    public function setPublicar($publicar)
    {
        $this->_publicar = $publicar;
    }

    public function setComentario($comentario)
    {
        $this->_comentario = $comentario;
    }

    public function setUsuario_id($usuario_id)
    {
        $this->_usuario_id = $usuario_id;
    }

    public function setFecha($fecha)
    {
        $this->_fecha = $fecha;
    }

    public function setContactos($contactos)
    {
        $this->_contactos = $contactos;
    }

    public function setRevisado($revisado)
    {
        $this->_revisado = $revisado;
    }

    public function setVisitas($visitas)
    {
        $this->_visitas = $visitas;
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

    // Agrega un Anuncio a la base de datos
    public function guardar($conexion = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $atributos_class = $this->getAtributosClass();
            unset($atributos_class['id']);
            
            $SQL = "INSERT INTO anuncio (".implode(", ", $atributos_class).")\n VALUES ('".$this->getCodigo_ciudad()."', '".$this->getParticular()."', ".$this->getCategoria_id().", '".$this->getVende()."', '".$this->getTitulo()."', '".$this->getDescripcion()."', '".$this->getPrecio()."', '".$this->getPublicar()."', '".$this->getComentario()."', ".$this->getUsuario_id().", '".date("Y-m-d H:i:s")."', 0, 0, 0)";
            
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

    // Edita un Anuncio de la base de datos
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
                    // print "clave = $clave : valor = $valor : valor_bd = {$valores_bd[$clave]}<hr>";
                    
                    if (($valores_bd[$clave] != $valor) && !(strlen($valor) == 0 && $ignorar_vacios))
                    {
                        $valores_sql[] = "$clave = '$valor'";
                    }
                }
                
                if (count($valores_sql) != 0)
                {
                    $SQL = "UPDATE anuncio SET ".implode(", ", $valores_sql)." WHERE id = ".$this->getId()."\n";
                    
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

    // Elimina un Anuncio de la base de datos
    public function eliminar($conexion = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $SQL = "DELETE FROM anuncio WHERE id = ".$this->getId()."\n";
            
            return $conexion->ejecutar($SQL);
        }
        
        return false;
    }

    // Elimina un Anuncio de la base de datos
    public function eliminar_varios($conexion = false, $ids)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            if (is_array($ids) && count($ids) > 0)
            {
                $SQL = "DELETE FROM anuncio WHERE id IN(".implode(",", $ids).")\n";
                
                return $conexion->ejecutar($SQL);
            }
        }
        
        return false;
    }

    // Elimina un Anuncio de la base de datos
    public function publicar($conexion = false, $ids = false, &$array_retornar)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            if (is_array($ids) && count($ids) > 0)
            {
                $SQL = "UPDATE anuncio SET publicar = '".$this->getPublicar()."', comentario = '".$this->getComentario()."', revisado = '1' WHERE id IN(".implode(",", $ids).")\n";
                
                if ($conexion->ejecutar($SQL))
                {
                    $SQL = "SELECT anuncio.id, nombre, email FROM usuario,anuncio WHERE usuario_id = usuario.id AND anuncio.id IN(".implode(",", $ids).")\n";
                    
                    if ($conexion->consultar($SQL) && $conexion->getRegistrosAfecctados() > 0)
                    {
                        $array_retornar = $conexion->consulta2matriz();
                    }
                    
                    return true;
                }
            }
        }
        
        return false;
    }
    
    public function cargarBD($conexion = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $atributos_class = $this->getAtributosClass();
            
            $SQL = "SELECT ".implode(", ", $atributos_class)." FROM anuncio WHERE id = ".$this->getId()."\n";
            
            if ($conexion->consultar($SQL))
            {
                $row = $conexion->sacarRegistro();
                
                $this->setAtributos($row);
                
                return true;
            }
        }
        
        return false;
    }

    // Busca un Anuncio en la BD a través del Id del objeto actual y coloca estos valores en los atributos del objeto
    public function cargarBD_array($conexion = false, $publicar = "")
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $where = "";
            if ($publicar != "")
            {
                $where = " AND publicar = $publicar ";
            }
            
            $SQL = "SELECT anuncio.id, ciudad.nombre AS ciudad_nombre, particular, categoria.nombre AS categoria_nombre,
                        categoria.id AS categoria_id, grupo, vende, titulo, descripcion, precio, usuario_id, fecha, email,
                        revisado, codigo_ciudad, usuario.nombre AS usuario_nombre, telefono, mostrar_tel, visitas
                    FROM anuncio, ciudad, categoria, usuario
                    WHERE anuncio.codigo_ciudad = ciudad.codigo
                    $where
                    AND anuncio.categoria_id = categoria.id
                    AND anuncio.usuario_id = usuario.id
                    AND anuncio.id = ".$this->getId()."\n";
            
            // print "SQL = <pre>$SQL</pre><hr>";
            
            if ($conexion->consultar($SQL) && $conexion->getRegistrosAfecctados() > 0)
            {
                $row = $conexion->sacarRegistro();
                
                $this->setAtributos($row);
                
                $SQL = "SELECT * FROM imagen WHERE anuncio_id = ".$this->getId();
                
                $conexion->consultar($SQL);
                
                $imagenes = $conexion->consulta2matriz();
                
                return array('anuncio' => $row, 'imagenes' => $imagenes);
            }
        }
        
        return false;
    }

    // Retorna un array de objetos Anuncio con los valores en BD, se puede usar paginación
    public function listar($conexion = false, $totalxpagina = 20, $pagina = 0, $ordenar_por = '', $ordenar_dir = '')
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $SQL = 'SELECT count(id) AS total FROM anuncio';
            
            if ($conexion->consultar($SQL))
            {
                $row = $conexion->sacarRegistro();
                
                $total_bd = $row["total"];
                
                $atributos_class = $this->getAtributosClass();
                
                $SQL = "SELECT ".implode(", ", $atributos_class)." FROM anuncio";
                
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
                        $objetos[$i] = new Anuncio();
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

    // Retorna un array de objetos Anuncio con los valores en BD, se puede usar paginación
    public function listar_array($conexion = false, $totalxpagina = 20, $pagina = 0, $ordenar_por = '', $ordenar_dir = '', $where = '')
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $SQL = "SELECT count(anuncio.id) AS total\n".
                   "FROM categoria, anuncio\n".
                   "WHERE anuncio.categoria_id = categoria.id";
            
            $where_sql = "";
            if (is_array($where))
            {
                foreach ($where as $w)
                {
                    if ($w != '') $where_sql .= "\nAND $w";
                }
            }
            
            $SQL .= $where_sql; //."\nGROUP BY anuncio.id";
            
            // print "SQL = <pre>$SQL</pre><hr>";
            
            if ($conexion->consultar($SQL))
            {
                $row = $conexion->sacarRegistro();
                
                $total_bd = $row["total"];
                
                $atributos_class = $this->getAtributosClass();
                
                $SQL = "SELECT anuncio.id, fecha, titulo, precio, publicar, comentario, categoria.nombre AS categoria_nombre, url, ruta,\n".
                       "count(imagen.id) AS total_imagenes, revisado, visitas\n".
                       "FROM categoria, anuncio LEFT JOIN imagen ON imagen.anuncio_id = anuncio.id\n".
                       "WHERE anuncio.categoria_id = categoria.id".$where_sql."\nGROUP BY anuncio.id";
                
                if ($ordenar_por != '' && $ordenar_dir != '')
                {
                    $SQL .= "\nORDER BY $ordenar_por $ordenar_dir";
                }
                
                if ($totalxpagina > 0 && $pagina >= 0)
                {
                    $SQL .= "\nLIMIT $pagina, $totalxpagina";
                }
                
                // print "SQL = <pre>$SQL</pre><hr>";
                
                if ($conexion->consultar($SQL))
                {
                    $array_anuncios = array();
                    
                    while ($row = $conexion->sacarRegistro())
                    {
                        $array_anuncios[] = $row;
                    }
                    
                    // print "array_anuncios = <pre>";print_r($array_anuncios);print "</pre><hr>";
                    
                    if (count($array_anuncios) > 0)
                    {
                        return array("total_bd" => $total_bd, "anuncios" => $array_anuncios);
                    }
                }
            }
        }
        
        return false;
    }

    // Aumenta en uno el número de visitas de un Anuncio
    public function aumentarVisitas($conexion = false)
    {
        if (is_object($conexion) && get_class($conexion) == 'Conexion' && $conexion->getEnlace())
        {
            $SQL = "UPDATE anuncio SET visitas = (visitas + 1) WHERE id = ".$this->getId()."\n";
            
            return $conexion->ejecutar($SQL);
        }
        
        return false;
    }
}
?>
