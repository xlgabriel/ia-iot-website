<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION["usuario"])) {
    header("Location: index.html");
    exit();
}

$name = $_SESSION["usuario"];

// Hacer la solicitud HTTP para obtener la información del usuario
$urlUserInfo = "http://localhost:1880/userName?name=" . urlencode($name);
$responseUserInfo = file_get_contents($urlUserInfo);

// Verificar si la solicitud fue exitosa
if ($responseUserInfo === false) {
    echo "Error al obtener la información del usuario";
    exit();
}

$userInfo = json_decode($responseUserInfo, true);

// Verificar si la información del usuario está presente
if (empty($userInfo)) {
    echo "Error: No se pudo obtener la información del usuario";
    exit();
}

// Obtener el nombre de usuario a partir de la información obtenida
$user = $userInfo[0]["user"];

// Hacer la solicitud HTTP para obtener la información del nodo del usuario
$urlNodoUser = "http://localhost:1880/nodoUser?user=" . urlencode($user);
$responseNodoUser = file_get_contents($urlNodoUser);

// Verificar si la solicitud fue exitosa
if ($responseNodoUser === false) {
    echo "Error al obtener la información del nodo del usuario";
    exit();
}

$nodoInfo = json_decode($responseNodoUser, true);

if (empty($nodoInfo)) {
    echo "El usuario no tiene asignado un nodo";
    exit();
}

$idNodo = $nodoInfo[0]["idnodo"];

// Hacer la solicitud HTTP para obtener los datos del nodo
$urlDatosNodo = "http://localhost:1880/datos-idnodo?idnodo=" . urlencode($idNodo);
$responseDatosNodo = file_get_contents($urlDatosNodo);

// Verificar si la solicitud fue exitosa
if ($responseDatosNodo === false) {
    echo "Error al obtener los datos del nodo";
    exit();
}

$datosNodo = json_decode($responseDatosNodo, true);

// Mostrar los datos en una tabla
echo "<table border='1'>";
echo "<tr><th>ID Nodo</th><th>Temperatura</th><th>Humedad</th><th>Fecha</th></tr>";

foreach ($datosNodo as $dato) {
    echo "<tr>";
  /*   echo "<td>" . $dato["id"] . "</td>";*/
    echo "<td>" . $dato["idnodo"] . "</td>"; 
    echo "<td>" . $dato["temperatura"] . "</td>";
    echo "<td>" . $dato["humedad"] . "</td>";
    echo "<td>" . $dato["fecha"] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>