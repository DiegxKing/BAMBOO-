<?php
include_once "encabezado.php";
include_once "navbar.php";
session_start();

if(empty($_SESSION['usuario'])) header("location: login.php");

$id = $_GET['id'];
if (!$id) {
    echo 'No se ha seleccionado el cliente';
    exit;
}
include_once "funciones.php";
$cliente = obtenerClientePorId($id);
?>

<div class="container">
    <h3>Editar cliente</h3>
    <form method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $cliente->nombre;?>" id="nombre" placeholder="Escribe el nombre del cliente">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?php echo $cliente->telefono;?>" id="telefono" placeholder="Ej. 2111568974">
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" value="<?php echo $cliente->direccion;?>" id="direccion" placeholder="Ej. Av Collar 1005 Col Las Cruces">
        </div>

        <div class="text-center mt-3">
            <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
            <a href="clientes.php" class="btn btn-danger btn-lg">
                <i class="fa fa-times"></i> 
                Cancelar
            </a>
        </div>
    </form>
</div>

<?php
if(isset($_POST['registrar'])){
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Validación de campos vacíos
    if(empty($nombre) || empty($telefono) || empty($direccion)){
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Debes completar todos los datos.
        </div>';
        return;
    }

    // Validación de longitud del teléfono
    if(strlen($telefono) != 9){
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El número de teléfono debe tener 9 dígitos.
        </div>';
        return;
    }

    // Validación del primer dígito del teléfono
    if($telefono[0] != '9'){
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El número de teléfono debe comenzar con el dígito 9.
        </div>';
        return;
    }

    // Si pasa todas las validaciones, se procede a la actualización
    include_once "funciones.php";
    $resultado = editarCliente($nombre, $telefono, $direccion, $id);
    if($resultado){
        echo '
        <div class="alert alert-success mt-3" role="alert">
            Información del cliente actualizada con éxito.
        </div>';
    }
}
?>
