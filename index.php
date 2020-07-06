<?php
include 'inc/function/sesiones.php';
include 'inc/function/function.php';
include 'inc/templates/header.php';
include 'inc/templates/barra.php';
//obtenemos el id de la URL
if(isset($_GET['id_proyecto'])){
    $id_proyecto = $_GET['id_proyecto'];

}

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';


?>
<body>

<div class="contenedor">
    <?php 
    include 'inc/templates/sidebar.php';
    ?>

    <main class="contenido-principal">
        <?php 
        if(isset($id_proyecto)){   
            $proyecto = obtenerNombreProyecto($id_proyecto);
            
    

        if($proyecto){
            ?>
                    <h1>Proyecto Actual
                    <?php foreach($proyecto as $nombre): ?>
                        <span id="nombre_proyecto_actual"> <?php echo $nombre['nombre']; 
                    
                    endforeach;
                        ?>   
                    </span> 
                    </h1>

        <form action="#" class="agregar-tarea">
            <div class="campo">
                <label for="tarea">Tarea:</label>
                <input type="text" placeholder="Nombre Tarea" class="nombre-tarea"> 
            </div>
            <div class="campo enviar">
                <input type="hidden" value="<?php if(isset($id_proyecto)){
                    echo $id_proyecto;
                } ?>" id="id_proyecto">
                <input type="submit" class="boton nueva-tarea" value="Agregar">
            </div>
        </form>

        <h2>Listado de tareas:</h2>

            <?php 
            }
        }else{
            echo '<h1> Seleciona un Proyecto </h1>';

            }
        ?> 
        <div class="listado-pendientes">
            <ul>

                

<?php 
if(isset($id_proyecto)){
    $tareas = obtenerTareasProyecto($id_proyecto);

// echo '<pre>';
// var_dump($tareas);
// echo '</pre>';


if($tareas->num_rows>0){
foreach($tareas as $tarea):

echo $id_proyecto;
?>
                <li id="tarea: <?php echo $tarea['id']; ?> " class="tarea">
                  <p> <?php echo $tarea['nombre']; ?> </p>
                    <div class="acciones">
                    <!-- operador termariio de php -->
                        <i class="far fa-check-circle <?php echo ($tarea['estado'] === '1' ? 'completo' : '' )?>"></i>
                        <i class="fas fa-trash"></i>
                    </div>
                  
                </li> 
<?php endforeach;

}else{
    echo "<h1>No hay tarreas Creadas en este proyecto</h1>";
}
}
?>
                 
            </ul>
        </div>
    </main>
</div><!--.contenedor-->
<?php

include 'inc/templates/footer.php';
?>
