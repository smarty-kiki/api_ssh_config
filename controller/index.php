<?php

if_get('/', function ()
{
    $request_public_ip = ip();

    $config = config('ip');

    $machines = dao('machine')->find_all();
    
    foreach ($machines as $machine) {

        echo $machine->name.' ';

        if ($request_public_ip == $machine->public_ip) {
            echo $machine->wlan_ip;
        } else {
            echo $config['center_ip'];
        }

        echo "\n";
    }

    exit;
});
