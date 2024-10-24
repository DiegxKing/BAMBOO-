<?php
include_once "encabezado.php";
include_once "navbar.php";
session_start();

// Verificar si el usuario está autenticado
if (empty($_SESSION['usuario'])) {
    header("location: login.php");
    exit;
}

// Verificar si el parámetro 'id' está definido en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '
    <div class="alert alert-danger mt-3" role="alert">
        No se ha seleccionado el usuario para editar.
    </div>';
    exit;
}

// Obtener el ID del usuario de la URL
$id = $_GET['id'];

include_once "funciones.php";

// Obtener los datos del usuario por ID
$usuario = obtenerUsuarioPorId($id);
if (!$usuario) {
    echo '
    <div class="alert alert-danger mt-3" role="alert">
        Usuario no encontrado.
    </div>';
    exit;
}
?>
<div class="container">
    <h3>Editar usuario</h3>
    <form method="post">
        <div class="mb-3">
            <label for="usuario" class="form-label">Nombre de usuario</label>
            <input type="text" name="usuario" class="form-control" value="<?php echo htmlspecialchars($usuario->usuario, ENT_QUOTES, 'UTF-8'); ?>" id="usuario" placeholder="Escribe el nombre de usuario. Ej. Paco">
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario->nombre, ENT_QUOTES, 'UTF-8'); ?>" id="nombre" placeholder="Escribe el nombre completo del usuario">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($usuario->telefono, ENT_QUOTES, 'UTF-8'); ?>" id="telefono" placeholder="Ej. 2111568974">
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" value="<?php echo htmlspecialchars($usuario->direccion, ENT_QUOTES, 'UTF-8'); ?>" id="direccion" placeholder="Ej. Av Collar 1005 Col Las Cruces">
        </div>

        <div class="text-center mt-3">
            <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary btn-lg">
            <a href="usuarios.php" class="btn btn-danger btn-lg">
                <i class="fa fa-times"></i> 
                Cancelar
            </a>
        </div>
    </form>
</div>
<?php
if (isset($_POST['actualizar'])) {
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Validación de campos vacíos
    if (empty($usuario) || empty($nombre) || empty($telefono) || empty($direccion)) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Debes completar todos los datos.
        </div>';
        return;
    }

    // Validación para evitar números en nombre de usuario y nombre completo
    if (!preg_match('/^[a-zA-Z\s]+$/', $usuario)) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El nombre de usuario no debe contener números ni caracteres especiales.
        </div>';
        return;
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $nombre)) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El nombre completo no debe contener números ni caracteres especiales.
        </div>';
        return;
    }

    // Validación de longitud del teléfono
    if (strlen($telefono) != 9) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El número de teléfono debe tener 9 dígitos.
        </div>';
        return;
    }

    // Validación del primer dígito del teléfono
    if ($telefono[0] != '9') {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El número de teléfono debe comenzar con el dígito 9.
        </div>';
        return;
    }

    // Actualizar el usuario
    $resultado = editarUsuario($usuario, $nombre, $telefono, $direccion, $id);
    if ($resultado) {
        echo '
        <div class="alert alert-success mt-3" role="alert">
            Información de usuario actualizada con éxito.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Error al actualizar la información del usuario.
        </div>';
    }
}
?>
