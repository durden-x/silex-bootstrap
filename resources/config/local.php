<?php

// include the prod configuration
require __DIR__ . '/dev.php';

// enable the debug mode
$app['debug'] = true;

// Gestion des erreurs
error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', 1);
ini_set('log_errors', 1);


// Doctrine (db)
$app['dbs.options'] = array(
    'db' => array(
        'driver' => 'pdo_sqlsrv',
        'host' => '',
        'dbname' => '',
        'user' => '',
        'password' => '',
        'charset' => 'utf8',
    ),
);
