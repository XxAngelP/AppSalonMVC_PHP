<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php 
  include_once __DIR__ . "/../templates/alertas.php";
?>

<form action="/crear-cuenta" class="formulario" method="POST">
  <div class="campo">
    <label for="nombre">Nombre</label>
    <input
     type="text"
     id="nombre"
     name="nombre"
     placeholder="Angel"
     value="<?php echo s($usuario->nombre); ?>"
    >
  </div>
  <div class="campo">
    <label for="apellido">Apellido</label>
    <input
     type="text"
     id="apellido"
     name="apellido"
     placeholder="Baez"
     value="<?php echo s($usuario->apellido); ?>"
    >
  </div>
  <div class="campo">
    <label for="telefono">Telefono</label>
    <input
     type="tel"
     id="telefono"
     name="telefono"
     placeholder="5583504205"
     value="<?php echo s($usuario->telefono); ?>"
    >
  </div>
  <div class="campo">
    <label for="email">Email</label>
    <input
     type="email"
     id="email"
     name="email"
     placeholder="correo@correo.com"
     value="<?php echo s($usuario->email); ?>"
    >
  </div>
  <div class="campo">
    <label for="password">Contraseña</label>
    <input
     type="password"
     id="password"
     name="password"
     placeholder="******"
    >
  </div>

  <input type="submit" value="Crear cuenta" class="boton">
</form>

<div class="acciones">
  <a href="/">¿Ya tienes una cuenta? Incia Sesion</a>
  <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>