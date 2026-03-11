<?php
//String de conexion a base de datos
$host = 'localhost';
$dbname = 'prueba1db';
$dbuser = 'ricardo';
$dbpass = 'ricardo1';

//Crear conexion
$conn = new mysqli($host,$dbuser,$dbpass,$dbname);

//Verificar conexion
if ($conn->connect_error) {
	die("conexion fallida: ". $conn->connect_error);
}

