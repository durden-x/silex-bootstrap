<?php 

use Symfony\Component\HttpFoundation\Response;

use Controllers\IndexController;


/*
 * Mount routes
 **********************************************************/
$app->mount('/', new IndexController());
/**********************************************************/

/*
 * Error handler
 **********************************************************/
$app->error(function (\Exception $e, $code) use ($app) {

    // commented for testing purposes
    if ($app['debug']) {
        return;
    }

    if ($code == 404) {

        return new Response( $app['twig']->render('errors/404.html.twig', array( 'message' => $e->getMessage() )), 404);
    }

    return new Response( $app['twig']->render('errors/500.html.twig', array( 'message' => $e->getMessage() )), 500);
});
/**********************************************************/
