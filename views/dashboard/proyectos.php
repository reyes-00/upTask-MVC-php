<?php include_once __DIR__. '/../templates/header_dashboard.php'?>
<div class="contenedor-sm">

  <div class="contenedor-nueva-tarea">
    <button 
      type="button" 
      class="agregar-tarea boton" id="agregar-tarea"
      >&#43; Nueva Tarea</button>
  </div>
  <div id="filtros" class="filtros">
    <div class="filtros-inputs">
      <h2>Filtros:</h2>
      <div class="campo">
        <label for="todas">Todas</label>
        <input type="radio" name="filtro" id="todas" value="" checked>
      </div>
      <div class="campo">
        <label for="completadas">Completado</label>
        <input type="radio" name="filtro" id="completadas" value="1">
      </div>
      <div class="campo">
        <label for="pendientes">Pendientes</label>
        <input type="radio" name="filtro" id="pendientes" value="0">
      </div>
    </div>
  </div>
  <ul id="listado-tareas" class="listado"></ul>
</div>
<?php include_once __DIR__. '/../templates/footer.php'?>
<?php
echo '
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="build/js/tareas.js"></script>
'
?>