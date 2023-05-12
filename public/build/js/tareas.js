(function () {



  const agregarTarea = document.querySelector('#agregar-tarea');
  agregarTarea.addEventListener('click', function(){
    mostrarFormulario();
  });
  let tareas = [];
  let filtradas = [];


  obtenerTareas();


  async function obtenerTareas(){
    try{
    let url = obtenerProyectoId();
    let ruta = `api/tareas?url=${url}`;
    
      const respuesta = await fetch(ruta);
      const resultado = await respuesta.json();
      tareas = resultado.tareas;
      mostarTareas();
    }catch(err){
      console.log(err);
    }
  }
  let estado= {
    0: 'Pendiente',
    1: 'Completa'
  }

  // Filtro de busqueda
  const filtros = document.querySelectorAll('#filtros input[type=radio]');
  filtros.forEach(input =>{
    input.addEventListener('input', filtrarDatos)
  })
  function filtrarDatos(e){
    let filtro = e.target.value;

    if(filtro !== ''){
      filtradas = tareas.filter(tarea => tarea.estado === filtro);
     
    }else{
      filtradas =[];
     
    }
    mostarTareas();
  }
  function tareasPendientes(){
    const tareasPendientes = tareas.filter(tarea => tarea.estado === "0");
    const pendientesRadio = document.querySelector("#pendientes" );

    if(tareasPendientes.length === 0){
      pendientesRadio.disabled = true;
    }else{
      pendientesRadio.disabled = false;

    }
  }
  function tareasCompletas(){
    const tareasCompletas = tareas.filter(tarea => tarea.estado === "1");
    const completasRadio = document.querySelector("#completadas" );

    if(tareasCompletas.length === 0){
      completasRadio.disabled = true;
    }else{
      completasRadio.disabled = false;

    }
  }
  function mostarTareas(){
    limpiarHTML();
    tareasCompletas();
    tareasPendientes();
    const arrayTareas = filtradas.length ? filtradas : tareas;
    const listado = document.querySelector('#listado-tareas');
    if(arrayTareas.length <= 0){
      const mensaje = document.createElement('LI');
      mensaje.textContent = 'No hay tareas aun';
      mensaje.classList.add('no-tareas');

      listado.appendChild(mensaje);
      return;
    }
    
    arrayTareas.forEach(tarea => {
      const contenedorTarea = document.createElement('LI');
      contenedorTarea.dataset.tareaId = tarea.id;
      contenedorTarea.classList.add('tarea')

      const nombreTarea = document.createElement('P');
      nombreTarea.textContent = tarea.nombre;
      nombreTarea.classList.add('titulo-tarea')
      nombreTarea.ondblclick = function(){
        mostrarFormulario(true, {...tarea});
      }

      // contenedor botones
      const opcionesDiv = document.createElement('DIV');
      opcionesDiv.classList.add('opciones');
      
      // Botones
      const btnEstadoTarea = document.createElement('BUTTON');
      btnEstadoTarea.classList.add('estado-tarea');
      btnEstadoTarea.classList.add(`${estado[tarea.estado].toLowerCase()}`);
      btnEstadoTarea.textContent = estado[tarea.estado];
      btnEstadoTarea.dataset.estadoTarea = tarea.estado;
      btnEstadoTarea.ondblclick = function () {
        cambiarEstadoTarea({...tarea});
      }
      
      const btnEliminar = document.createElement('BUTTON');
      btnEliminar.classList.add('eliminar-tarea');
      btnEliminar.dataset.idTarea = tarea.id;
      btnEliminar.textContent = "Eliminar";
      btnEliminar.ondblclick = function() {
        confirmarEliminarTarea({...tarea});
      }

      opcionesDiv.appendChild(btnEstadoTarea);
      opcionesDiv.appendChild(btnEliminar);
      
      contenedorTarea.appendChild(nombreTarea);
      contenedorTarea.appendChild(opcionesDiv);
      
      
      listado.appendChild(contenedorTarea);
     
    });
  }
  function mostrarFormulario(estado = false, tarea = {}) {
  
    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = ` 
      <form class="formulario nueva-tarea">
        <legend>${estado ? "Editar tarea" : "Agregar nueva Tarea"}</legend>
        <div class="campo">
          <label>Tarea:  </label>
          <input type="text" id="tarea" name="tarea" placeholder= "${estado ? "Editar Tarea" : "Agrega la nueva Tarea"}" value="${tarea.nombre ? tarea.nombre : tarea.nombre = ""}"/>
        </div>
        <div class="opciones">
          <input type="submit" class="submit-nueva-tarea" value="${estado ? "Actualizar" : "Guardar"}"/>
          <button type="button" class="cerrar-modal" >Cerrar x  </button>
        </div>
     </form>
     
     `;

    setTimeout(() => {
      const formulario = document.querySelector('.formulario');
      formulario.classList.add('animar');
    }, 0);

    modal.addEventListener('click', (e) => {
      e.preventDefault();
      if (e.target.classList.contains('cerrar-modal')) {

        const formulario = document.querySelector('.formulario');
        formulario.classList.add('cerrar');

        setTimeout(() => {
          modal.remove();
        }, 100);
      }

      if (e.target.classList.contains('submit-nueva-tarea')) {
        const btnAgregar = document.querySelector('#tarea').value.trim();

        if (btnAgregar === "") {
          mostrarMensaje('El nombre de la tarea es obligatorio', 'error', document.querySelector('legend'));
          return;
        }
        if(estado){
          tarea.nombre = btnAgregar
          actualizarTarea(tarea);
        }else{
          mandarTarea(btnAgregar)

        }
      }
    })

    document.querySelector('.dashboard').appendChild(modal);
  }



  function mostrarMensaje(mensaje, tipo, referencia) {

    const alertaPrevia = document.querySelector('.alerta');

    if (alertaPrevia) {
      alertaPrevia.remove();
    }

    const alerta = document.createElement('DIV');
    alerta.classList.add('alerta', tipo);
    alerta.textContent = mensaje;

    referencia.parentElement.insertBefore(alerta, referencia);

    setTimeout(() => {
      alerta.remove();
    }, 3000)
  }

  // Consultar el servidor
async function mandarTarea(tarea) {
    const datos = new FormData();
    datos.append('nombre', tarea);
    datos.append('proyecto_id', obtenerProyectoId());

    try {
      // direccion para crear datos en el servidor
      const url = "http://localhost:3000/api/tareas";

      // manda datos por POST
      const respuesta = await fetch(url, {
        method: 'POST',
        body: datos
      });

      const resultado = await respuesta.json();
     
      mostrarMensaje(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));

      // Cerrar modal 
      if(resultado.tipo === 'exito'){
        const modal = document.querySelector('.modal');
        setTimeout(()=>{
          modal.remove();
        },2000);

        // agregar un nuevo objeto de tarea al arreglo tareas
        const tareaObj = {
          id:  String(resultado.id),
          nombre: tarea,
          estado : "0",
          proyecto_id: resultado.proyecto_id
        }

        tareas = [...tareas, tareaObj];

        mostarTareas();
      }
    } catch (error) {

    }
  }

  function cambiarEstadoTarea(tarea) {
    const nuevoEstado = tarea.estado === "1" ? "0" : "1";
    tarea.estado = nuevoEstado;
    actualizarTarea(tarea);
  }

  async function actualizarTarea(tarea){

    const {estado, id,nombre,proyecto_id} = tarea;

    const datos = new FormData();
    datos.append('id', id);
    datos.append('nombre', nombre);
    datos.append('estado', estado);
    datos.append('proyecto_id', (obtenerProyectoId()));

    // Ver el formData()
    // for(valor of datos.values()){
    //   console.log(valor);
    // }
    try{
      const url = 'http://localhost:3000/api/tareas/actualizar';
      
      const respuesta = await fetch(url,{
        method: 'POST',
        body: datos
      });
      const resultado = await respuesta.json();
      
      if(resultado.tipo === 'exito'){
       Swal.fire(
        resultado.mensaje,
        resultado.mensaje,        
        'success'
       );

       const modal = document.querySelector('.modal');
       if(modal){
         modal.remove();

       }
        
        tareas = tareas.map(memoriaTareas => {
          if(memoriaTareas.id === id){
            memoriaTareas.estado = estado
            memoriaTareas.nombre = nombre
          }
          return memoriaTareas;
        });
        mostarTareas();
      }
    }catch(err){
      console.log(err);
    }
  }

  function confirmarEliminarTarea(tarea){
    Swal.fire({
      title: 'Eliminar Tarea?',
      showCancelButton: true,
      confirmButtonText: 'SI',
      cancelButtonText: 'NO',
    }).then((result) => {
      if (result.isConfirmed) {
        eliminarTarea(tarea)
      }
    })
  }

  async function eliminarTarea(tarea) {
    const {id,nombre, estado, proyecto_id} = tarea

    const datos = new FormData();
    datos.append('id', id)
    datos.append('nombre', nombre)
    datos.append('estado', estado)
    datos.append('proyecto_id', obtenerProyectoId())


    try {
      const url = 'http://localhost:3000/api/tareas/eliminar';
      const respuesta = await fetch(url,{
        method: 'POST',
        body: datos
      });
      const resultado = await respuesta.json();
      if(resultado.resultado){
      
        // mostrarMensaje(resultado.mensaje,resultado.tipo, document.querySelector('#listado-tareas'));
      
        Swal.fire('Eliminado', resultado.mensaje,'success');

        tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== id);
        mostarTareas();
      }
    } catch (error) {
      
    }
  }

  function obtenerProyectoId() {
    // leemos la url del proyecto 
    const proyectoParams = new URLSearchParams(window.location.search);
    const proyecto = Object.fromEntries(proyectoParams.entries());
    return proyecto.url;
  }

  function limpiarHTML(){
    const listadoTareas =  document.querySelector('#listado-tareas');
    while(listadoTareas.firstChild){
      listadoTareas.removeChild(listadoTareas.firstChild);
    }
  }

 


})();


