<div class="contenedor login">
  <?php include_once __DIR__ . '/../templates/nombre-pagina.php' ?>
  <div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>
    <p class="descripcion-pagina">Inicia Sesion</p>
    <form action="/" class="formulario" method="POST">
      <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu email">
      </div>
      <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu password">
      </div>
      <input type="submit" value="Iniciar Sesion" class="boton">
    </form>
    <div class="acciones">
      <a href="/crear">Crear cuenta</a>
      <a href="/olvide">Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>