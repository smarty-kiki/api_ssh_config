# up
create table if not exists `machine` (
    `id` bigint(20) unsigned not null,
    `version` int(11) not null,
    `create_time` datetime null,
    `update_time` datetime null,
    `delete_time` datetime null,
    `name` varchar(30) null,
    `register_key` varchar(30) null,
    `public_ip` varchar(15) null,
    `wlan_ip` varchar(15) null,
    primary key (`id`)
) engine = innodb default charset = utf8;

# down
drop table `machine`;
