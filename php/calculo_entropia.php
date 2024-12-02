<?php
function calcularEntropia($password) {
    
    $longitud = strlen($password);
    $caracteres = 0;

    if (preg_match('/[a-z]/', $password)) $caracteres += 26;
    if (preg_match('/[A-Z]/', $password)) $caracteres += 26;
    if (preg_match('/[0-9]/', $password)) $caracteres += 10;
    if (preg_match('/[^\w]/', $password)) $caracteres += 32;


    return $longitud * log($caracteres, 2);

}


