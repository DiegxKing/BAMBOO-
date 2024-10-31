<?php
include_once "encabezado.php";
include_once "navbar.php";
session_start();

if(empty($_SESSION['usuario'])) header("location: login.php");

?>
<div class="container">
    <h3>Agregar producto</h3>
    <form method="post">
        <div class="mb-3">
            <label for="codigo" class="form-label">Código de barras (Max. 6 Valores númericos)</label>
            <input type="text" name="codigo" class="form-control" id="codigo" placeholder="Escribe el código de barras del producto" maxlength="6" pattern="\d{6}" title="Debe ser un código de 6 dígitos numéricos" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre o descripción</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ej. Papas">
        </div>
        <div class="row">
            <div class="col">
                <label for="compra" class="form-label">Precio compra</label>
                <input type="number" name="compra" step="any" id="compra" class="form-control" placeholder="Precio de compra" aria-label="" min="0" oninput="this.value = Math.abs(this.value)">
            </div>
            <div class="col">
                <label for="venta" class="form-label">Precio venta</label>
                <input type="number" name="venta" step="any" id="venta" class="form-control" placeholder="Precio de venta" aria-label="" min="0" oninput="this.value = Math.abs(this.value)">
            </div>
            <div class="col">
                <label for="existencia" class="form-label">Existencia</label>
                <input type="number" name="existencia" step="any" id="existencia" class="form-control" placeholder="Existencia" aria-label="" min="0" oninput="this.value = Math.abs(this.value)">
            </div>
        </div>
        <div class="text-center mt-3">
            <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
            <a class="btn btn-danger btn-lg" href="productos.php">
                <i class="fa fa-times"></i> 
                Cancelar
            </a>
        </div>
    </form>
</div>

<?php
if(isset($_POST['registrar'])){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $compra = $_POST['compra'];
    $venta = $_POST['venta'];
    $existencia = $_POST['existencia'];

    // Validación de campos vacíos
    if(empty($codigo) || empty($nombre) || empty($compra) || empty($venta) || empty($existencia)){
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Debes completar todos los datos.
        </div>';
        return;
    }

    // Validar que el código de barras sea de 6 dígitos numéricos
    if(!preg_match('/^\d{6}$/', $codigo)){
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El código de barras debe ser de 6 dígitos numéricos.
        </div>';
        return;
    }

    include_once "funciones.php";

    // Verificar si el código de barras ya existe
    $productoExistente = obtenerProductoPorCodigo($codigo);
    if($productoExistente){
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            El código de barras ya existe en el sistema. Por favor, ingresa uno diferente.
        </div>';
        return;
    }

    // Registrar el producto si no existe
    $resultado = registrarProducto($codigo, $nombre, $compra, $venta, $existencia);
    if($resultado){
        echo '
        <div class="alert alert-success mt-3" role="alert">
            Producto registrado con éxito.
        </div>';
    }
}
?>
