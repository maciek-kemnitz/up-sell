<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerProviderInterface;
use src\Service\ServiceRegistry;

class InfoController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->get('/', function () use ($app)
		{
			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
			$shop = $shoploApi->shop->retrieve();

			return $app['twig']->render('info.page.html.twig', ['shop' => $shop]);
		});

		return $controllers;
	}
}