# up
create table if not exists `machine` (
    `id` bigint(20) unsigned not null,
    `version` int(11) not null,
    `create_time` datetime default null,
    `update_time` datetime default null,
    `delete_time` datetime default null,
    `name` varchar(30) default null,
    `register_key` varchar(30) default null,
    `public_ip` varchar(15) default null,
    `wlan_ip` varchar(15) default null,
    primary key (`id`)
) engine=innodb default charset=utf8;

# down
drop table `machine`;
