evenListener();

function evenListener() {
    document.querySelector('#formulario').addEventListener('submit', validarRegistro);
}

function validarRegistro(e) {
    e.preventDefault();

    const usuario = document.querySelector('#usuario').value,

        password = document.querySelector('#password').value,

        tipo = document.querySelector('#tipo').value


    if (usuario === "" || password === "") {
        //alertas swal
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Todos los campos son obligatorios!',

        });
    } else {
        //alerta swal


        //mandamos a ejecutar Ajax

        var datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('password', password);
        datos.append('accion', tipo);


        //creamos el llamado a Ajax
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'inc/modelos/modelos-admin.php', true);
        //onload es el retorno de datos
        xhr.onload = function () {
            if (this.status === 200) {
                const  respuestas = JSON.parse(xhr.responseText);
                console.log(respuestas)
                console.log(respuestas.tipo)
                if (respuestas.respuesta === 'correcto') {
                    //si la respuesta es correcta
                  
                    if (respuestas.tipo === 'crear') {
                        //usurario nuevo
                        Swal.fire(
                            'Usuario Creado!',
                            'El usuario se creo!',
                            'success'
                        )
                    } else if (respuestas.tipo === 'login') {
                        console.log(respuestas.tipo)
                        Swal.fire(
                            'Usuario y Contraseña Correctos!',
                            'Bienvenido a Uptask!',
                            'success'
                        )
                        .then(resultado =>{
                            if(resultado.value){
                                window.location.href='index.php';
                                console.log(resultado)
                            }
                        })
                    }
                } else {
                    //un error en la base de datos
                    Swal.fire(
                        'Oooop!',
                        'Hubo un error!',
                        'error'
                    )
                }

            }
        }

        xhr.send(datos);

    }
}