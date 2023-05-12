<div class="contenedor crear">
<?php include_once __DIR__ . '/../templates/nombre-pagina.php' ?>
<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php';?>
    <p class="descripcion-pagina">Crea tu cuenta</p>
    <form action="/crear" class="formulario" method="POST">
      <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="nombre" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo $usuario->nombre;?>">
      </div>
      <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu email" value="<?php echo $usuario->email;?>">
      </div>
      <div class="campo">
        <label for="password">Tu password</label>
        <input type="password" name="password" id="password" placeholder="Tu password" >
      </div>
      <div class="campo">
        <label for="password_dos">Repetir Password</label>
        <input type="password" name="password_dos" id="password_dos" placeholder="Confirmar password">
      </div>
      <input type="submit" value="Crear cuenta" class="boton">
    </form>
    <div class="acciones">
      <a href="/">Iniciar sesion</a>
      <a href="/olvide">Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>