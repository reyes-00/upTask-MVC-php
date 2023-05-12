<?php include_once __DIR__. '/../templates/header_dashboard.php'?>
<div class="contenedor-sm">
  <?php include_once __DIR__. '/../templates/alertas.php'?>
  <form action="/crear-proyecto" class="formulario" method="POST">
    <?php include_once __DIR__ . './formulario_proyecto.php'?>
    <input type="submit" value="Crear Proyecto">
  </form>

</div>
<?php include_once __DIR__. '/../templates/footer.php'?>