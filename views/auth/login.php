<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesion con tus Datos</p>

<?php 
  include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/">
  <div class="campo">
    <label for="email">Email</label>
    <input
     type="email"
     id="email"
     placeholder="correo@correo.com"
     name="email"
    >
  </div>
  <div class="campo">
    <label for="password">Contraseña</label>
    <input
     type="password"
     id="password"
     placeholder="******"
     name="password"
    >
  </div>

  <input type="submit" class="boton" value="Iniciar Sesion">
</form>

<div class="acciones">
  <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
  <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>