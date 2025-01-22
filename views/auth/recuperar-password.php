<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva Contraseña a continuacion</p>
<?php 
  include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST">
  <div class="campo">
    <label for="password">Contraseña</label>
    <input 
      type="password"
      id="password"
      name="password"
      placeholder="*******"
    >
  </div>
  <input type="submit" class="boton" value="Guardar Nueva Contraseña">
</form>

<div class="acciones">
  <a href="/">¿Ya tienes cuenta? Inciar Sesión</a>
  <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
</div>