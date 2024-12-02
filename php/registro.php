<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        form {
            width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        label, input, button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Registro de Usuario</h2>
    <form action="registro.php" method="POST">        <!--combiar nombre ruta-->
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="confirm_password">Confirmar contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validar contraseñas coinciden
    if ($password !== $confirm_password) {
        die("Las contraseñas no coinciden.");
    }

    // Validar requisitos de contraseña
    if (strlen($password) < 8 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[\W_]/', $password)) {
        die("La contraseña debe tener al menos 8 caracteres, una letra mayúscula, un número y un símbolo especial.");
    }

    //hace una busqueda en el archivo json si usuario existe
    // Leer usuarios existente
    $usuarios_path = '../db/usuarios.json';
    if (!file_exists($usuarios_path)) {
        file_put_contents($usuarios_path, json_encode([]));
    }
    $usuarios = json_decode(file_get_contents($usuarios_path), true);
    // echo($usuarios);

    // Validar si el usuario ya existe
    if (isset($usuarios[$username])) {
        die("El usuario ya existe.");
    }

    // Registrar usuario (cifrar contraseña)
    $usuarios[$username] = [
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ];
    file_put_contents($usuarios_path, json_encode($usuarios));

    echo "Usuario registrado exitosamente.";
}
?>
