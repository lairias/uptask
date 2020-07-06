<?php 
/* $arrego = array(
    'respuesta'=>'modelo'
);

die(json_encode($arrego)); */
$accion = $_POST['accion'];
$password = $_POST['password'];
$usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);


if($accion === 'crear'){
    //hashear password

    $opciones = array(
        'cost'=> 12
    );

    $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);
    //importamos la coneccion de la base de datos
    include '../function/conexion.php';
    try{
        $query= $conn->prepare("INSERT INTO usuarios(usuario, password) VALUES (?,?)");
        $query->bind_param('ss',$usuario,$hash_password);
        $query->Execute();
        if($query->affected_rows > 0){
     $respuesta = array(
            'respuesta'=> 'correcto',
            'id_insertado'=>$query->insert_id,
            'tipo'=>$accion
        );
        }
   
       
    }catch(Exeption $e){
        $respuesta = array(
            'pass'=>$e->getMessage()
        );
    }
   echo json_encode($respuesta);
}

//crearemos un login 
if($accion === 'login'){
    //extraemos la coneccion de la base de datos
    include '../function/conexion.php';
//creamos un try catch
    try{
        //Selecionamos los admin de la base de datos
        $query= $conn->prepare("SELECT  id,usuario ,password FROM usuarios WHERE usuario = ?");
        $query->bind_param('s',$usuario);
        $query->Execute();
        //loguear el usuario
        $query->bind_result($nombre_usuario,$id_usuario,$pass_usuario);
        $query->fetch();//combiertemelo en una Array de funcion

        if($nombre_usuario){
            if(password_verify($password,$pass_usuario)){ 

                //inisiamos la seccion
                session_start();
                $_SESSION['nombre']=$usuario;
                $_SESSION['id']= $id_usuario;
                $_SESSION['login']= true;


                //verificamos el password de la base de datos con la password que el usuario ingresa
            $respuesta = array(
            'respuesta'=>'correcto',
            'nombre' => $nombre_usuario,
            'id' => $id_usuario,
            'pass' => $pass_usuario,
            'tipo'=>$accion
        );
    }else{
        $respuesta = array(
            'respuesta'=>'Password no Incorrecto');
    }

}else{
        $respuesta = array(
            'respuesta'=>'Usuario No existe');
        }

    }catch(Exeption $e){
        $respuesta = array(
            'error'=>$e-getMessage()
        );
    }
    echo json_encode($respuesta);
}

?>