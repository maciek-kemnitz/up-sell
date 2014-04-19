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
								->orderByOrder()
								->find();

			return $app['twig']->render('home.page.html.twig', ['product'=>$shoploApi->product->retrieve(), 'uppSells' => $upSells]);

		});

		$controllers->get('/modal', function (Request $request) use ($app)
		{

			$upSell = UpSellQuery::create()->findPk(35);
			return $app['twig']->render('widget.page.html.twig', ['upSell' => $upSell, 'products' => $upSell->getProducts()]);

		});

		return $controllers;
	}
}