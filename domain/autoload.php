<?php

spl_autoload_register(function ($class_name) {

    $class_maps = [
        'machine_dao' => 'dao/machine.php',
        'machine' => 'entity/machine.php',
    ];

    if (isset($class_maps[$class_name])) {
        include __DIR__.'/'.$class_maps[$class_name];
    }
});
