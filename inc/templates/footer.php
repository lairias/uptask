<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<?php
$actual = obtenerPaginaActual();
if($actual ==='crear-cuenta' || $actual === 'login'){
    echo '<script src="js/formulario.js"></script>';
}else{
    echo '<script src="js/script.js"></script>';
}

?>
</body>
</html>