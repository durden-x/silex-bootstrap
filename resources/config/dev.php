<?php

use Monolog\Logger;




/**
 * Heritage de la configuration
 ****************************************************/
require __DIR__ . '/prod.php';
/****************************************************/




/**
 * Monologue
 ****************************************************/
$app['monolog.level'] = 300;
/****************************************************/




/**
 * Doctrine
 ****************************************************/
$app['dbs.options'] = array(
    'db' => array(
        'driver'    => 'pdo_dblib',
        'port'      => '1433',
        'host'      => '',
        'dbname'    => '',
        'user'      => '',
        'password'  => '',
        'charset'   => 'utf8',
    ),
);
/****************************************************/




/**
 * Configuration spécifique de l'application
 ****************************************************/
// Activation du mode débogage
$app['debug'] = true;

// Affichage des erreurs
error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', 1);
ini_set('log_errors', 1);
/****************************************************/