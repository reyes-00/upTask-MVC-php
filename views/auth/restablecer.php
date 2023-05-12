<div class="contenedor restablecer">
  <?php include_once __DIR__ . '/../templates/nombre-pagina.php' ?>
  <div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>
    
    <?php if($mostrar) : ?>
      <p class="descripcion-pagina">Restablecer</p>
      
      <form class="formulario" method="POST">
        
      <div class="campo">
        <label for="password">Nueva Password</label>
        <input type="password" name="password" id="password" placeholder="Guardar password">
      </div>


      <input type="submit" value="Enviar instrucciones" class="boton">
    </form>
    <?php endif; ?>
    <div class="acciones">
      <a href="/">Iniciar sesion</a>
      <a href="/crear">Crear cuenta</a>
    </div>
  </div>
</div>