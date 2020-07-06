<?php 
//obtiene la pagina actual
function obtenerPaginaActual(){
    return str_replace('.php','', basename($_SERVER['PHP_SELF']));

}
obtenerPaginaActual();



//consultas

//obtener todos los proyectos de la base de datos 
function obtenerProyectos(){
    include 'conexion.php';
    try{
        return $conn->query('SELECT id,nombre FROM proyecto');
    }catch(Exception $e){
        echo 'Erro:'. $e->getMessage();
        return false;
    }

}


//obtener el nombre del proyecto

function obtenerNombreProyecto ($id = null){
    include 'conexion.php';
    try{
        return $conn->query("SELECT nombre FROM proyecto WHERE id =$id");
    }catch(Exception $e){
        echo 'Error:'.$e->getMessage();
        return false;
    }
}


//obtenemos las clses del proyecto
function obtenerTareasProyecto($id = null){

    include 'conexion.php';
    try{

    return $conn->query("SELECT id, nombre, estado FROM tareas WHERE id_proyecto= $id");

    }catch(Exception $e){
        echo 'Erro: '.$e->getMessage();
        return false;
    }
}
?>