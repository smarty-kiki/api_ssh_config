<?php

if_get('/', function ()
{
    $request_public_ip = ip();

    $force_public = input('force_public', false);

    $config = config('ip');

    $machines = dao('machine')->find_all();
    
    foreach ($machines as $machine) {

        echo $machine->name.' ';

        if ($force_public || $request_public_ip != $machine->public_ip) {
            echo $config['center_ip'];
        } else {
            echo $machine->wlan_ip;
        }

        echo "\n";
    }

    exit;
});

if_get('/public_ip', function ()
{
    echo ip();
    exit;
});
