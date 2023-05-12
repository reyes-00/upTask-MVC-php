<?php
 include_once __DIR__. '/../templates/header_dashboard.php'?>
<?php if( count($proyectos) === 0) : ?>
  <p class="no-proyectos"> Aun no hay proyectos, <a href="/crear-proyecto">Comienza creando uno</a></p>
<?php endif?>
<ul class="listado-proyectos">
  <?php foreach ($proyectos as $proyecto) : ?>
    <li class="proyecto"> 
      <a href="proyectos?url=<?php echo $proyecto->url ?>"><?php echo $proyecto->proyecto ?></a>
    </li>  
  <?php endforeach;?>
</ul>
<?php include_once __DIR__. '/../templates/footer.php'?>