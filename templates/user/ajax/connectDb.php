<?php

try
{
	$db = new PDO('mysql:host=localhost; dbname=socialNetDb', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8',PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}
catch(Exception $e)
{
	die('une erreur est survenue lors de la connection a la base de données'.$e->getMessage());
}

?>
