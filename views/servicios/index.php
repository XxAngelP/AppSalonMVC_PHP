<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administracion de Servicios</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
    $id = 1;
?>

<ul class="servicios">
    <?php foreach($servicios as $servicio){?>
        <li>
            <div class="caja-servicio">
                <div class="numero-servicio">
                    <span><?php echo $id; ?></span>
                </div>
                <div class="info-servicio">
                    <p><span class="nombre-servicio"><?php echo $servicio->nombre; ?></span></p>
                    <p>Precio: <span><?php echo $servicio->precio; ?></span></p>
                </div>
                <div class="acciones">
                    <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>
    
                    <form action="/servicios/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                        <input type="submit" value="Borrar" class="boton-eliminar">
                    </form>
                </div>
            </div>
        </li>
    <?php $id = $id+1;} ?>
</ul>