<?php include_once __DIR__. '/../templates/header_dashboard.php'?>
<div class="contenedor-sm">
  <?php include_once __DIR__.'/../templates/alertas.php';?>
  <a href="/perfil" class="enlace_password">Volver</a>
  <form class="formulario" action="/cambiar_password" method="POST">
  <div class="campo">
    <label for="nombre">Actual Password</label>
    <input type="password" name="password_actual" placeholder="Tu password actual" >
  </div>
  <div class="campo">
    <label for="password_nuevo">Nueva password</label>
    <input type="password" name="password_nuevo" placeholder="Nueva Password" >
  </div>
  <input type="submit" value="Enviar">
  </form>
</div>
<?php include_once __DIR__. '/../templates/footer.php'?>