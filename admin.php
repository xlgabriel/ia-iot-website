<?php
    session_start();
    $us = $_SESSION["usuario"];
    if ($us == ""){
        header("Location:index.html");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
   
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    
    <div class="container-fluid">
        <a class="navbar-brand" href="admin.php">Proyecto Iot</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="admin.php">Usuarios</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-nodos.php">Nodos</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-datos.html">Datos</a>
            </li>
        </ul>
        <span class="navbar-text">
            <?php echo "<a class='nav-link' href='logout.php'>Logout $us</a>" ;?>
        </span>
        </div>
    </div>
    </nav>
    <table class="table">
    <thead>
        <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Usuario</th>
        <th scope="col">Password</th>
        <th scope="col">tipo</th>
        <th scope="col">Editar</th>
        <th scope="col">Eliminar</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $servurl="http://localhost:1880/usuarios";
        $curl=curl_init($servurl);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response=curl_exec($curl);
       
        if ($response===false){
            curl_close($curl);
            die("Error en la conexion");
        }

        curl_close($curl);
        $resp=json_decode($response);
        $long=count($resp);
        for ($i=0; $i<$long; $i++){
            $dec=$resp[$i];
            $nombre=$dec ->nombre;
            $usuario=$dec->user;
            $password=$dec->password;
            $tipo=$dec->tipo;
     ?>
    
    <tr><form action="modificarUsuario.php" method=post>
        <td><input type="text" name="nombre" value="<?php echo $nombre; ?>"></td>
        <td><?php echo $usuario; ?><input type="hidden" name="usuario" value="<?php echo $usuario; ?>"></td>
        <td><input type="text" name="password" value="<?php echo $password; ?>"></td>
        <td><input type="text" name="tipo" value="<?php echo $tipo; ?>"></td>
        <td><input type="submit" value="MODIFICAR"></td></form>    
        <td><form action="eliminarUsuario.php" method=post>
        <input type="hidden" name="usuario" value="<?php echo $usuario; ?>"  >  
        <input type="submit" value="ELIMINAR"></form></td>
            
        </tr>
            
    
     <?php 
        }
     ?>   
    </tbody>
    </table>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            CREAR USUARIO
    </button>
    <div class="modal" id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">CREAR USUARIO</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 
        
        <div class="modal-body">
           <form action="crearUsuario.php" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Tipo</label>
                <input type="text" name="tipo" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Crear Usuario">
            </div> 
            </form>
        </div>
       
    </div>
    </div>

   
</body>