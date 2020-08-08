#!/bin/bash

ROOT_DIR="$(cd "$(dirname $0)" && pwd)"/../../..

ln -fs $ROOT_DIR/project/config/production/nginx/api_ssh_config.conf /etc/nginx/sites-enabled/api_ssh_config
/usr/sbin/service nginx reload

/bin/bash $ROOT_DIR/project/tool/dep_build.sh file
/usr/bin/php $ROOT_DIR/public/cli.php migrate:install
/usr/bin/php $ROOT_DIR/public/cli.php migrate

#ln -fs $ROOT_DIR/project/config/production/supervisor/api_ssh_config_queue_worker.conf /etc/supervisor/conf.d/api_ssh_config_queue_worker.conf
#/usr/bin/supervisorctl update
#/usr/bin/supervisorctl restart api_ssh_config_queue_worker:*
