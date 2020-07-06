<?php 
//comprabar si el usuario esta autenticado en ese caso redireccionara el ususario para que se registre
function usuario_autenticar(){
    if(!revisar_usuario()){
        header('Location:login.php');
        exit();
    }
}


//revisara si hay seccion iniciada
function revisar_usuario(){
    return isset($_SESSION['nombre']);
}

session_start();
usuario_autenticar();
?>