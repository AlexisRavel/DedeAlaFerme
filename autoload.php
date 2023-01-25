<?php
    namespace src\app\models;

    spl_autoload_register(function ($classname) {
        $path = $classname.".class.php";
        if(file_exists($path)) {
            include $path;
        }
    })
?>