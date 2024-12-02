<?php
include 'calculo_entropia.php';

$usuarios = json_decode(file_get_contents('../db/usuarios.json'), true);
$usuario = $_POST['username'];
$password = $_POST['password'];

if (isset($usuarios[$usuario]) && password_verify($password, $usuarios[$usuario]['password'])) {
    $entropia = calcularEntropia($password);


    if ($entropia > 40) {
        $mensaje = "Contraseña muy segura.";
    } elseif ($entropia >= 20) {
        $mensaje = "Contraseña moderadamente segura.";
    } else {
        $mensaje = "Contraseña insegura.";
    }
    echo $mensaje;
} else {
    echo "Usuario o contraseña incorrectos.";
}
