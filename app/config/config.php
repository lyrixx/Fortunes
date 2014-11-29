<?php

$info = getenv('DATABASE_URL');
if (!$info) {
    return;
}

$info = parse_url($info);

$container->setParameter('database_host', $info['host']);
$container->setParameter('database_port', $info['port']);
$container->setParameter('database_name', trim($info['path'], '/'));
$container->setParameter('database_user', $info['user']);
$container->setParameter('database_password', $info['pass']);
