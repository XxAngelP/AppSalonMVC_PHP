<h1 class="nombre-pagina">Olvide Contraseña</h1>
<p class="descripcion-pagina">Reestablece tu contraseña escribiendo tu email a continuacion</p>

<?php 
  include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if(isset($error)) return; ?>
<form action="/olvide" class="formulario" method="POST">
  <div class="campo">
    <label for="email">Email</label>
    <input
     type="email"
     id="email"
     name="email"
     placeholder="correo@correo.com"
    >
  </div>
  <input type="submit" class="boton" value="Enviar instrucciones">
</form>

<div class="acciones">
  <a href="/">¿Ya tienes una cuenta? Incia Sesion</a>
  <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
</div>