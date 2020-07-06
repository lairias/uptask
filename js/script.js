
//variable de innerHTML para visualizar los proyectos
var listaProyectos = document.querySelector('ul#proyectos');


    //boton para crear evento en el sidebar
    document.querySelector('#crear-proyecto').addEventListener('click', nuevoProyecto);
    //boton para agregar una nueva tarea a cada proyecto 
    document.querySelector('.nueva-tarea').addEventListener('click' , agregarTarea);
    //botones de terminado y eliminar una tarea y mandarlo a la base de datos
    document.querySelector('.listado-pendientes').addEventListener('click', accionesTareas);


//fucnion para agregar nuevos proyectos al HTML sin necesidad de guardarlo a la base de datos
function nuevoProyecto(e) {
    e.preventDefault(); // el .preventDefault() evita que el evento de actualizar la pagina se carge 
    //creamos un input para el nuevo proyecto
    const nuevoProyecto = document.createElement('li');
    nuevoProyecto.innerHTML = `<input type="text" id="nuevo-proyecto"  autofocus=true>`

    listaProyectos.appendChild(nuevoProyecto);

    //selecionamos el input con el id
    const  inputNuevoProyecto = document.querySelector('#nuevo-proyecto');

    //al preciona enter un nuevo proyecto


    inputNuevoProyecto.addEventListener('keypress', (e) => {

        //el keyCode es el numero de obicacion de la tecla en nuestro teclado 
        //el 13 es el de enter lo cual creamos una condicion de que al momento de precionar enter se active la funcion
        if (e.keyCode === 13 || e.which === 13) {
            // console.log('presionastes la tecla enter')
            guardarProyecto(inputNuevoProyecto.value);
            listaProyectos.removeChild(nuevoProyecto);

        }


    });
}
//aGuardamos el proyecto a la base de dato usando XMLHttpRequest
function guardarProyecto(nombre) {
    // console.log(nombre)
    //inyectamos el html
    //datos por el formData

    const datos = new FormData();
    datos.append('proyecto', nombre);
    datos.append('accion', 'crear')


    const xhr = new XMLHttpRequest();
    xhr.open("POST", 'inc/modelos/modelo-proyecto.php', true);
    xhr.onload = function () {
        if (this.status === 200) {
            //obtenemos el respuesta de la base de dotos
            const respuesta = JSON.parse(xhr.responseText);
            var proyecto = respuesta.nombre_proyecto,
                id_insertado = respuesta.id_insertado,
                tipo = respuesta.tipo,
                resultado = respuesta.respuesta;
            // console.log(respuesta);inserccion

            if (resultado === 'correcto') {
                //funciona bien 

                if (tipo === 'crear') {
                    const li = document.createElement('li');
                    li.innerHTML = `<a href = "index.php?id_proyecto=${id_insertado}" id=proyecto:'${id_insertado}'> ${proyecto}</a>`;
                    //agregamos al html 
                    listaProyectos.appendChild(li);


                    Swal.fire(
                        'Nuevo Proyecto!',
                        `El proyecto: ${proyecto} se Creo Correctamente!`,
                        'success'
                    )
                        .then(resultado => {
                            if (resultado.value) {
                                //redireccionamos directamente cuendo se crea la nueva tarea
                                window.location.href = `index.php?id_proyecto=${id_insertado}`
                            }
                        })
                   
                } else {
                    //se actualiso o se elimino el proyecto
                }

            } else {
                //ocaciona un error 
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Hubo un error!',

                });
            }

            //comprovamos la 

        }

    }
    xhr.send(datos);



}


function agregarTarea(e){
    e.preventDefault();
    var nombreTarea = document.querySelector('.nombre-tarea').value;
//validamos que la tarea no este vacia

    if(nombreTarea === ''){

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Campo de tarea vacia!'

        });
    }else{

        
        //creamos la instancia FormData()

        const datos = new FormData();
        datos.append('tarea', nombreTarea);
        datos.append('accion', 'crear');
        datos.append('id_proyecto', document.querySelector('#id_proyecto').value)

        //la tara existe insertar en php
        const xhr = new XMLHttpRequest();
        xhr.open('POST','inc/modelos/modelo-tareas.php',true);
        xhr.onload = function(){
            if(this.status === 200){
                const respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);


                if(respuesta.respuesta === 'correcto'){
                    //si la respuesta del modelo-tareas.php es correcto nos return el resultado como un objec 
                    if(respuesta.tipo === 'crear'){
                        //lanzamos la alerta de correcto
                    Swal.fire({
                        icon: 'success',
                        title: `${respuesta.respuesta}`,
                        text: `Tarea ${respuesta.tarea} Agregada!`

                    });

                    //construimos un templates 
                    var nuevaTarea = document.createElement('li');
                    //agregamos el id 
                    nuevaTarea.id = `Tarea: ${respuesta.id_insertado}`;

                    //agrregamos la clase tarea
                    nuevaTarea.classList.add('tarea');
                    //insertamos el en HTML con innerHtml
                    nuevaTarea.innerHTML = `
                    <p>${respuesta.tarea}</p>
                    <div class="acciones"> 
                    <i class="far fa-check-circle"></i>
                    <i class="fas fa-trash"></i>
                    </div> 
                    `
                    //lo agregamos al DOM con appenchild
                    const listadoTareas = document.querySelector('.listado-pendientes ul');

                    listadoTareas.appendChild(nuevaTarea);

                    //limpiamos el formulario 
                    document.querySelector('.agregar-tarea').reset()

                }
            }else{
                //lanzamos la alerta de error
                Swal.file({
                    icon:'eror',
                    title:'Error',
                    text:`Hubo un error al insertar la tarea \n${respuesta.tarea}`
                })
            }
            
        }
        
    }

        xhr.send(datos)


    }

}



function accionesTareas(e){

    e.preventDefault()
    
}


