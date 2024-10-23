<?php   
    include_once "funciones.php";
    session_start();
    if(isset($_POST['agregar'])){
    
        if(isset($_POST['codigo'])) {
            $codigo = $_POST['codigo'];
            $producto = obtenerProductoPorCodigo($codigo);
            
            if (!ctype_digit($codigo) || strlen($codigo) != 6) {
                echo "<script type='text/javascript'>
                        alert('El código debe tener exactamente 6 dígitos.');
                        window.location.href='vender.php';
                      </script>";
                return;
            }

            if(!$producto) {
                echo "
                <script type='text/javascript'>
                    window.location.href='vender.php'
                    alert('No se ha encontrado el producto')
                </script>";
                return;
            }
            
            print_r($producto);
            $_SESSION['lista'] = agregarProductoALista($producto,  $_SESSION['lista']);
            unset($_POST['codigo']);
            header("location: vender.php");
        }
    }

?>