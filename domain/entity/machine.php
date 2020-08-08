<?php

class machine extends entity
{
    /* generated code start */
    public $structs = [
        'name' => '',
        'register_key' => '',
        'public_ip' => '',
        'wlan_ip' => '',
    ];

    public static $entity_display_name = '机器';
    public static $entity_description = '机器';

    public static $struct_data_types = [
        'name' => 'string',
        'register_key' => 'string',
        'public_ip' => 'string',
        'wlan_ip' => 'string',
    ];

    public static $struct_display_names = [
        'name' => '名称',
        'register_key' => '注册码',
        'public_ip' => '公网IP',
        'wlan_ip' => '内网IP',
    ];

    public static $struct_descriptions = [
        'name' => '名称',
        'register_key' => '名称',
        'public_ip' => 'IP 地址',
        'wlan_ip' => 'IP 地址',
    ];

    public static $struct_is_required = [
        'name' => true,
        'register_key' => true,
        'public_ip' => true,
        'wlan_ip' => true,
    ];

    public function __construct()
    {/*{{{*/
    }/*}}}*/

    public static function create($name, $register_key, $public_ip, $wlan_ip)
    {/*{{{*/
        $machine = parent::init();

        $machine->name = $name;
        $machine->register_key = $register_key;
        $machine->public_ip = $public_ip;
        $machine->wlan_ip = $wlan_ip;

        return $machine;
    }/*}}}*/

    public static function struct_formaters($property)
    {/*{{{*/
        $formaters = [
            'name' => [
                [
                    'function' => function ($value) {
                        return mb_strlen($value) <= 30;
                    },
                    'failed_message' => '不能超过 30 个字',
                ],
            ],
            'register_key' => [
                [
                    'function' => function ($value) {
                        return mb_strlen($value) <= 30;
                    },
                    'failed_message' => '不能超过 30 个字',
                ],
            ],
            'public_ip' => [
                [
                    'reg' => '/^(25[0-5]|2[0-4]\d|[0-1]?\d?\d)(\.(25[0-5]|2[0-4]\d|[0-1]?\d?\d)){3}$/',
                    'failed_message' => '不是有效的 IP 格式',
                ],
            ],
            'wlan_ip' => [
                [
                    'reg' => '/^(25[0-5]|2[0-4]\d|[0-1]?\d?\d)(\.(25[0-5]|2[0-4]\d|[0-1]?\d?\d)){3}$/',
                    'failed_message' => '不是有效的 IP 格式',
                ],
            ],
        ];

        return $formaters[$property] ?? false;
    }/*}}}*/
    /* generated code end */
}
