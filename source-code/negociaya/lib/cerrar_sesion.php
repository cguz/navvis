<?php
include_once "../lib/sesion.php";

if (sesion_valorVariable("administrador") == 1)
{
    $ruta = "admin";
}
else
{
    $ruta = "misventas";
}

sesion_destruir();

header ("Location: ../$ruta/login.php");
?>
