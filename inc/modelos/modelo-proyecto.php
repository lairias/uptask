<?php 
$proyecto = $_POST['proyecto'];
$accion = $_POST['accion'];

if($accion === 'crear'){
    
    //importamos la coneccion de la base de datos
    include '../function/conexion.php';
    try{
        $query= $conn->prepare("INSERT INTO proyecto(nombre) VALUES (?)");
        $query->bind_param('s',$proyecto);
        $query->Execute();
        if($query->affected_rows > 0){
     $respuesta = array(
            'respuesta'=> 'correcto',
            'id_insertado'=>$query->insert_id,
            'tipo'=>$accion,
            'nombre_proyecto'=>$proyecto
        );
        }
   
       
    }catch(Exeption $e){
        $respuesta = array(
            'error'=>$e->getMessage()
        );
    }
   echo json_encode($respuesta);
}


?>