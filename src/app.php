<?php

use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;


$app->register(new HttpCacheServiceProvider());

$app->register(new SessionServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new TranslationServiceProvider());
/*
$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => $app['monolog.logfile'],
    'monolog.name'    => 'app',
    'monolog.level'   => $app['monolog.level'],
));
*/

/*
 * TWIG
 **********************************************************/
$app->register(new TwigServiceProvider(), array(
    'twig.options'        => array(
        'strict_variables' => true
    ),
    'twig.path'           => array(__DIR__ . '/../template')
));

$app['twig']->addGlobal('opticRoutePrefixe', $app['optic.route.prefixe']);

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {


    $filter = new Twig_SimpleFilter('monthString', function ($string, $type = 'B') {

        return toUTF8(strftime('%' . $type, strtotime(date('Y') . '-' . $string . '-01')));
    });

    $twig->addFilter('strftime', $filter);

    return $twig;
}));
/**********************************************************/


/*
 * DOCTRINE
 **********************************************************/
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app['db']->executeQuery('SET DATEFORMAT "ymd"');
/**********************************************************/


/*
 * SWIFTMAILER
 **********************************************************/
$app->register(new SwiftmailerServiceProvider(), $app['swiftmailer.configuration']);
/**********************************************************/

return $app;
