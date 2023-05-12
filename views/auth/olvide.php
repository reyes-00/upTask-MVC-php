<div class="contenedor olvide">
  <?php include_once __DIR__ . '/../templates/nombre-pagina.php' ?>
  <div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>
    <p class="descripcion-pagina">Olvidaste tu password</p>
    <form action="/olvide" class="formulario" method="POST">

      <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu email">
      </div>


      <input type="submit" value="Enviar instrucciones" class="boton">
    </form>
    <div class="acciones">
      <a href="/">Iniciar sesion</a>
      <a href="/crear">Crear cuenta</a>
    </div>
  </div>
</div>