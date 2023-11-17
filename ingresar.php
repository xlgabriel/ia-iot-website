<?php
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    // URL de la solicitud POST
    $url = 'http://localhost:1880/validarUsuario';

    // Datos que se enviarán en la solicitud POST
    $data = array(
        'user' => $user,
        'password' => $pass,
    );
    $json_data = json_encode($data);

    // Inicializar cURL
    $ch = curl_init();

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud POST
    $response = curl_exec($ch);

    // Manejar la respuesta
    if ($response===false){
        header("Location:index.html");
    }
    // Cerrar la conexión cURL
    curl_close($ch);

    $resp = json_decode($response);
    
    if (count($resp) != 0){
        $nombre = $resp[0]->nombre;
        $tipo = $resp[0]->tipo;
        session_start();
        $_SESSION["usuario"]=$nombre;
        if ($tipo == 1){ 
            header("Location:admin.php");
        } 
        else { 
            header("Location:usuario.php");
        } 
    }
    else {
    header("Location:admin.php"); 
    }
?>