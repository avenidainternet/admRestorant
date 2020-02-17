<?php 
	function Conectarse()
		{
			//$link = new mysqli('localhost', 'root', '', 'elcaulle_restaurant');
			$link = new mysqli('localhost', 'elcaulle_trotter', 'francisca.aguirre', 'elcaulle_restaurant');
			$link->query("SET NAMES 'utf8'");
			return $link;
		}
?>