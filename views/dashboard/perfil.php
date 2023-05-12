<?php include_once __DIR__. '/../templates/header_dashboard.php'?>
<div class="contenedor-sm">
  <?php include_once __DIR__.'/../templates/alertas.php';?>
  <a href="/cambiar_password" class="enlace_password">Cambiar Password</a>
  <form class="formulario" action="/perfil" method="POST">
  <div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" placeholder="Tu nombre" value="<?php echo $usuario->nombre?>">
  </div>
  <div class="campo">
    <label for="email">Email</label>
    <input type="email" name="email" placeholder="Tu email" value="<?php echo $usuario->email?>">
  </div>
  <input type="submit" value="Enviar">
  </form>
</div>
<?php include_once __DIR__. '/../templates/footer.php'?>