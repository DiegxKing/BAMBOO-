<?php
include_once "encabezado.php";
include_once "navbar.php";
session_start();

if (empty($_SESSION['usuario'])) header("location: login.php");

?>
<div class="container">
    <br>
    <h3>Agregar Usuario</h3>
    <form method="post">
        <div class="mb-3">
            <label for="usuario" class="form-label">Nombre de usuario</label>
            <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Escribe el nombre de usuario. Ej. Paco">
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Escribe el nombre completo del usuario">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Ej. 9111568974">
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ej. Av Collar 1005 Col Las Cruces">
        </div>

        <div class="text-center mt-3">
            <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
            <a href="usuarios.php" class="btn btn-danger btn-lg">
                <i class="fa fa-times"></i> 
                Cancelar
            </a>
        </div>
    </form>
</div>

<?php
if (isset($_POST['registrar'])) {
    // Sanitizar entrada del usuario
    $usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8');
    $direccion = htmlspecialchars($_POST['direccion'], ENT_QUOTES, 'UTF-8');

    // Validación de campos vacíos
    if (empty($usuario) || empty($nombre) || empty($telefono) || empty($direccion)) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Debes completar todos los datos.
        </div>';
        return;
    }

    // Validación para evitar números en nombre de usuario y nombre completo
    if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $usuario)) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El nombre de usuario no debe contener números ni caracteres especiales.
        </div>';
        return;
    }

    if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El nombre completo no debe contener números ni caracteres especiales.
        </div>';
        return;
    }

    // Validación del teléfono
    if (!preg_match('/^9[0-9]{8}$/', $telefono)) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El teléfono debe comenzar con 9 y tener 9 dígitos numéricos.
        </div>';
        return;
    }

    // Incluir archivo con funciones
    include_once "funciones.php";

    // Verificar si el usuario ya existe
    if (usuarioExiste($usuario, $nombre)) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El nombre de usuario o el nombre completo ya existe. Por favor, elige otro.
        </div>';
        return;
    }

    // Registrar usuario
    $resultado = registrarUsuario($usuario, $nombre, $telefono, $direccion);
    
    // Manejar resultado del registro
    if ($resultado) {
        echo '
        <div class="alert alert-success mt-3" role="alert">
            Usuario registrado con éxito.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Error al registrar el usuario.
        </div>';
    }
}
?>

