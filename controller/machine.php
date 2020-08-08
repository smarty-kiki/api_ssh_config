<?php

if_get('/machines', function ()
{/*{{{*/
    list(
        $inputs['name'], $inputs['register_key'], $inputs['public_ip'], $inputs['wlan_ip']
    ) = input_list(
        'name', 'register_key', 'public_ip', 'wlan_ip'
    );
    $inputs = array_filter($inputs, 'not_null');

    $machines = dao('machine')->find_all_by_column($inputs);

    return [
        'code' => 0,
        'msg'  => '',
        'count' => count($machines),
        'data' => array_build($machines, function ($id, $machine) {
            return [
                null,
                [
                    'id' => $machine->id,
                    'name' => $machine->name,
                    'register_key' => $machine->register_key,
                    'public_ip' => $machine->public_ip,
                    'wlan_ip' => $machine->wlan_ip,
                    'create_time' => $machine->create_time,
                    'update_time' => $machine->update_time,
                ]
            ];
        }),
    ];
});/*}}}*/

if_post('/machines', function ()
{/*{{{*/
    $name = input('name');
    $register_key = input('register_key');
    $public_ip = input('public_ip');
    $wlan_ip = input('wlan_ip');

    $machine = dao('machine')->find_by_register_key($register_key);

    if ($machine->is_not_null()) {

        $machine->name = $name;
        $machine->public_ip = $public_ip;
        $machine->wlan_ip = $wlan_ip;
    } else {

        $machine = machine::create(
            $name,
            $register_key,
            $public_ip,
            $wlan_ip
        );
    }

    return [
        'code' => 0,
        'msg' => '',
    ];
});/*}}}*/
