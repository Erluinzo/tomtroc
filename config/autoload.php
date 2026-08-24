<?php

//find the class file in the folders and include it
spl_autoload_register(function (string $className) {
    $folders = ['models/', 'controllers/', 'views/', 'services/'];

    foreach ($folders as $folder) {
        $file = $folder . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
