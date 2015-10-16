<?php
session_start();

// Crea una variable de sesion
function sesion_crearVariable($nombre = '', $valor = '')
{
    if ($nombre != '')
    {
        $_SESSION["_sess_".$nombre] = $valor;
    }
}

// Recibe un array para crear varias variables de sesión
function sesion_crearVariables($variables)
{
    if (is_array($variables))
    {
        foreach ($variables as $nombre => $valor)
        {
            sesion_crearVariable($nombre, $valor);
        }
    }
}

// Elimina una variable de sesion
function sesion_borrarVariable($nombre = '')
{
    session_unregister("_sess_".$nombre);
}

// Destruye la sesión actual
function sesion_destruir()
{
    session_destroy();
}

// Retorna el valor de una variable de sesion
function sesion_valorVariable($nombre = '')
{
    return $_SESSION["_sess_".$nombre];
}
?>
