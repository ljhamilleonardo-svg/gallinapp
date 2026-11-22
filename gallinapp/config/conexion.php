<?php
// Conexión a la base de datos con PDO
// (en XAMPP el usuario es "root" y no tiene contraseña)
$con = new PDO('mysql:host=localhost;dbname=gallinapp;charset=utf8mb4', 'root', '');
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
