<?php

namespace Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

use Forms\BirtForm;
use Models\Entities\Birt;




/**
 * Cette classe est le contrôleur de la page d'accueil
 * Les routes sont déclaré dans la méthode connect
 */
class IndexController implements ControllerProviderInterface
{

	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->match('/', 'Controllers\IndexController::indexAction')
			->bind('homepage');

		return $controllers;
	}

	public function indexAction(Request $request, Application $app)
	{	
		/*
		 * Sélection du template de la page
		 ********************************************************/
		return $app['twig']->render('index.html.twig');
	    /********************************************************/
	}
}