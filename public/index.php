<?php
    include '../core/Application.php';    

    // echo 'file: '; echo file_exists(dirname(__DIR__) . DIRECTORY_SEPARATOR 
    //     . 'controllers' . DIRECTORY_SEPARATOR . 'defaultController.php') ? '1<br>' : '0<br>';
    // echo 'method (needs inclusion of the defaultController.php file): ';
    // echo method_exists('defaultController', 'index') ? '1<br>' : '0<br>';
    
    // echo 'from index.php @ public BEFORE "new Application"<br>';

    new Application;

    // echo 'from index.php @ public AFTER<br>';
?>