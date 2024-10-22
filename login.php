<?php
include_once "encabezado.php"; 
include_once "navbar.php"
?>
<div class="container" >
    <div class="row m-5 no-gutters ">
        <div class="col-md-6 d-none d-md-block">
        <img src="logo_principal.png" class="img-fluid" style="min-height:50%; margin-top: 70x; padding: 15%; display: block; margin-left: auto;">
        </div>
        <div class="col-md-6 bg-white p-5">
            <h3 class="pb-3">Iniciar sesión</h3>
            <div>
                <form action="iniciar_sesion.php" method="post">
                    <div class="form-group pb-3">
                        <input type="text" placeholder="Usuario" class="form-control" name="usuario" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group pb-3">
                        <input type="password" placeholder="Contraseña" class="form-control" name="password" id="exampleInputPassword1">
                    </div>

                    <div class="pb-2">
                    <button type="submit" name="ingresar" class="btn btn-primary w-100 font-weight-bold mt-2" style="background-color: #80ba3d; border-color: #80ba3d; transition: transform 0.3s ease;">Ingresar</button>

                        <style>
                            .btn:hover {
                                transform: scale(1.05); /* Agranda el botón en un 5% al pasar el cursor */
                            }
                        </style>
                    </div>
                </form>
             </div>
        </div>
    </div>
</div>
