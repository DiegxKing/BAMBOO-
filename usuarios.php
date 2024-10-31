<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
session_start();
if(empty($_SESSION['idUsuario'])) header("location: login.php");

$usuarios = obtenerUsuarios();
?>
<div class="container">
    <br>
    <h1>
        <a class="btn btn-lg" style="color:#fff; background:#466320;" href="agregar_usuario.php">
            <i class="fa fa-plus"></i>
            Agregar
        </a>
        Usuarios
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($usuarios as $usuario){
            ?>
                <tr>
                    <td><?php echo $usuario->usuario; ?></td>
                    <td><?php echo $usuario->nombre; ?></td>
                    <td><?php echo $usuario->telefono; ?></td>
                    <td><?php echo $usuario->direccion; ?></td>
                    <td>
                        <a class="btn" style="color:#fff; background:#466320;" href="editar_usuario.php?id=<?php echo $usuario->id; ?>">
                            <i class="fa fa-edit"></i>
                            Editar
                        </a>
                    </td>
                    <td>
                        <a href="eliminar.php?id=<?php echo $elemento['id']; ?>" 
                            onclick="return confirmarEliminacion();" 
                            class="btn btn-danger">
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
function confirmarEliminacion() {
    return confirm('¿Estás seguro de que deseas eliminar este usuario?');
}
</script>