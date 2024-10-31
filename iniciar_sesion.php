<?php
include_once "encabezado.php";

session_start(); // Inicia la sesión para gestionar los intentos fallidos

// Configuración del bloqueo
$maxIntentos = 3; // Número máximo de intentos
$tiempoBloqueo = 300; // 5 minutos (300 segundos) de bloqueo

// Inicializa los intentos si no existen en la sesión
if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
    $_SESSION['ultimo_intento'] = time();
}

// Función para verificar si el usuario está bloqueado
function estaBloqueado() {
    global $tiempoBloqueo;
    if ($_SESSION['intentos'] >= 3) {
        $tiempoTranscurrido = time() - $_SESSION['ultimo_intento'];
        if ($tiempoTranscurrido < $tiempoBloqueo) {
            return true;
        } else {
            $_SESSION['intentos'] = 0; // Reinicia los intentos después del bloqueo
            return false;
        }
    }
    return false;
}

// Verifica si se ha enviado el formulario
if (isset($_POST['ingresar'])) {
    if (empty($_POST['usuario']) || empty($_POST['password'])) {
        echo '
        <div class="alert alert-warning mt-3" role="alert">
            Debes completar todos los datos.
            <a href="login.php">Regresar</a>
        </div>';
        return;
    }

    if (estaBloqueado()) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Tu cuenta está bloqueada temporalmente. Inténtalo de nuevo en unos minutos.
            <a href="login.php">Regresar</a>
        </div>';
        return;
    }

    include_once "funciones.php";

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $datosSesion = iniciarSesion($usuario, $password);

    if (!$datosSesion) {
        $_SESSION['intentos']++; // Incrementa los intentos fallidos
        $_SESSION['ultimo_intento'] = time(); // Registra la hora del último intento
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Nombre de usuario y/o contraseña incorrectas. Intentos restantes: ' . (3 - $_SESSION['intentos']) . '.
            <a href="login.php">Regresar</a>
        </div>';
        return;
    }

    // Si el inicio de sesión es exitoso, reinicia los intentos
    $_SESSION['usuario'] = $datosSesion->usuario;
    $_SESSION['idUsuario'] = $datosSesion->id;
    $_SESSION['intentos'] = 0; // Reinicia el contador de intentos

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
