<?php 
 
function conectarDB() : mysqli {
    $db = mysqli_connect('localhost:3307', 'root', '1234', 'bienesraices_crud');
    $db->set_charset("utf8");
 
    if (!$db) {
        echo "Error: No se pudo conectar a MySQL.";
        echo "errno de depuración: " . mysqli_connect_errno();
        echo "error de depuración: " . mysqli_connect_error();
        exit;
    }
    return $db;
    
}
