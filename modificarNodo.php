<?php
    $idnodo=$_POST["idnodo"];
    $nombre=$_POST["nombre"];

    $ubic=$_POST["ubicacion"];
    $estado=$_POST["estado"];
    $usuario=$_POST["usuario"];

    // URL de la solicitud POST
    $url = 'http://localhost:1880/modificarNodo';

    // Datos que se enviarán en la solicitud POST
    $data = array(
        'idnodo' => $idnodo,
        'nombre' => $nombre,
        'ubicacion' => $ubic,
        'estado' => $estado,
        'user' => $usuario,
    );

    $json_data = json_encode($data);
    //echo $json_data;
    
    // Inicializar cURL
    $ch = curl_init();

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
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
    header("Location:admin.php"); 

?>