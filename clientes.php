<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
session_start();

if(empty($_SESSION['usuario'])) header("location: login.php");

$clientes = obtenerClientes();
?>
<div class="container">
    <br>
    <h1>
        <a class="btn btn-lg" style="color:#fff; background:#466320;" href="agregar_cliente.php">
            <i class="fa fa-plus"></i>
            Agregar
        </a>
        Clientes
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($clientes as $cliente){
            ?>
                <tr>
                    <td><?php echo $cliente->nombre; ?></td>
                    <td><?php echo $cliente->telefono; ?></td>
                    <td><?php echo $cliente->direccion; ?></td>
                    <td>
                        <a class="btn" style="color:#fff; background:#466320;" href="editar_cliente.php?id=<?php echo $cliente->id;?>">
                            <i class="fa fa-edit"></i>
                            Editar
                        </a>
                    </td>
                    <td>
                        <!-- Modificamos el enlace de eliminación -->
                        <a class="btn btn-danger" 
                           href="eliminar_cliente.php?id=<?php echo $cliente->id;?>" 
                           onclick="return confirmarEliminacion();">
                            <i class="fa fa-trash"></i>
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>        
    </table>
</div>

<!-- JavaScript para mostrar mensaje de confirmación -->
<script>
function confirmarEliminacion() {
    return confirm('¿Estás seguro de que deseas eliminar este cliente?');
}
</script>
