<?php

return [
    'host' => 'mysql-db',           //container name of mysql in docker-compose.yaml
    'dbname' => 'subscribers',      //database name defined in docker-compose.yaml
    'username' => 'test_user',      //database user name defined in docker-compose.yaml
    'password' => 'test_password',  //database user password defined in docker-compose.yaml
    'charset' => 'utf8mb4',
];
