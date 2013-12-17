<?php

use Monolog\Logger;




/**
 * Monologue
 ****************************************************/
$app['monolog.logfile'] = __DIR__ . '/../../var/app.log';
$app['monolog.level']   = Logger::INFO;
/****************************************************/




/**
 * Doctrine
 ****************************************************/
$app['database.params.charset'] = "utf8";
$app['dbs.options'] = array(
    'db' => array(
        'driver'    => 'pdo_mysql',
        'host'      => '',
        'dbname'    => '',
        'user'      => '',
        'password'  => '',
        'charset'   => 'utf8',
    ),
);
/****************************************************/




/**
 * Swiftmailer
 ****************************************************/
$app['swiftmailer.configuration'] = array(
    'swiftmailer.options' => array(
        'host'              => '',
        'port'              => 25,
        'username'          => '',
        'password'          => '',
        'encryption'        => null,
        'auth_mode'         => null,
    ),
);
/****************************************************/




/**
 * Configuration spécifique de l'application
 ****************************************************/
// Local
$app['locale'] = 'fr';
$app['session.default_locale'] = $app['locale'];

// Chemins
$app['app.route.prefixe'] = '';
$app['app.path.root'] = dirname(dirname(__DIR__)) . '/';

