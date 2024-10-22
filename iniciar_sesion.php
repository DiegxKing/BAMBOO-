<?php
include_once "encabezado.php";

if(isset($_POST['ingresar'])){
    if(empty($_POST['usuario']) || empty($_POST['password'])){
        echo '
        <div class="alert alert-warning mt-3" role="alert">
            Debes completar todos los datos.
            <a href="login.php">Regresar</a>
        </div>';
        return;
    }

    include_once "funciones.php";

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    session_start();

    $datosSesion = iniciarSesion($usuario, $password);

    if(!$datosSesion){
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Nombre de usuario y/o contraseña incorrectas.
            <a href="login.php">Regresar</a>
        </div>';
        return;
    }

    $_SESSION['usuario'] = $datosSesion->usuario;
    $_SESSION['idUsuario'] = $datosSesion->id;
    header("location: index.php");
}
?>

<!-- HTML para la página de login -->
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="" style="max-width: 500px; width: 100%;">
        <div class="text-center">
            <img src="logo_principal.png" class="img-fluid mb-4" style="max-width: 200px;" alt="Logo Bamboo">
        </div>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Usuario">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
            </div>
            <button type="submit" name="ingresar" class="btn btn-primary w-100 font-weight-bold mt-2" style="background-color: #80ba3d; border-color: #80ba3d;">Ingresar</button>
        </form>
    </div>
</div>
