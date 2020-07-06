<?php 
$id_proyecto = (int)$_POST['id_proyecto'];
$accion = $_POST['accion'];
$tarea = $_POST['tarea'];

if($accion === 'crear'){
    
    //importamos la coneccion de la base de datos
    include '../function/conexion.php';
    try{
        $query= $conn->prepare("INSERT INTO tareas(nombre,id_proyecto) VALUES (?, ?)");
        $query->bind_param('si',$tarea,$id_proyecto);
        $query->Execute();
        if($query->affected_rows > 0){
     $respuesta = array(
            'respuesta'=> 'correcto',
            'id_insertado'=>$query->insert_id,
            'tipo'=>$accion,
            'tarea'=>$tarea
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