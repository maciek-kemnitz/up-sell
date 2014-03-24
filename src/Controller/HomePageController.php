<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Model\UpSellQuery;
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class HomePageController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->get('/', function (Request $request) use ($app)
		{
			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];

			$upSells = UpSellQuery::create()
								->filterByShopDomain($shoploApi->shop->retrieve()['domain'])
								->find();

			return $app['twig']->render('home.page.html.twig', ['product'=>$shoploApi->product->retrieve(), 'uppSells' => $upSells]);

		});

		return $controllers;
	}
}