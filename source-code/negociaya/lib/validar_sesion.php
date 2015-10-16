<?php
include_once "../lib/sesion.php";
include_once "../lib/clases/conexion.class.php";
include_once "../lib/clases/usuario.class.php";

$usuario = new Usuario();

$usuario->setAtributos(array("email" => sesion_valorVariable("email"), "contrasena" => sesion_valorVariable("contrasena")));

$conexion = new Conexion();

$OK = true;

if ($conexion->conectar())
{
    if (!$usuario->validarLogin($conexion, sesion_valorVariable("administrador")))
    {
        print '(Sesion php) Error en su Sesion.  Debe iniciar sesion nuevamente';
        $OK = false;
    }
}
else
{
    print '(Sesion php) Error en su Sesion.  No se pudo conectar a la Base de Datos';
    $OK = false;
}

if (!$OK)
{
    $dir = substr(dirname($_SERVER['SCRIPT_FILENAME']), strrpos(dirname($_SERVER['SCRIPT_FILENAME']), "/") + 1);
    
    if (sesion_valorVariable("administrador") == 1 || $dir == "admin")
    {
        $ruta = "admin";
    }
    else
    {
        $ruta = "misventas";
    }
    
    print "<br /><br /><a href='../$ruta/login.php'>Iniciar Sesión</a>";
    exit;
}
?>
