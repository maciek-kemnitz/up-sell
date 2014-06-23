<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Model\Product;
use src\Model\ProductQuery;
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
			$shop = $shoploApi->shop->retrieve();

			$upSells = UpSellQuery::create()
								->filterByShopDomain($shop['permanent_domain'])
								->orderByOrder()
								->find();

			return $app['twig']->render('home.page.html.twig', ['product'=>$shoploApi->product->retrieve(), 'uppSells' => $upSells]);

		});

		$controllers->get('/logout', function (Request $request) use ($app)
		{
			session_unset();

			return new RedirectResponse('/');

		});

		$controllers->get('/modal', function (Request $request) use ($app)
		{
			$upSell = UpSellQuery::create()->findPk(53);

			/** @var Product[] $upSellProducts */
			$upSellProducts = $upSell->getProducts();
			$variants = [];


			foreach ($upSellProducts as $product)
			{
				$variantsTmp = json_decode($product->getVariants(), true);

				$varaintProducts = ProductQuery::create()->findPks($variantsTmp)->getArrayCopy();

				$variants[$product->getId()] = json_decode($product->getVariants(), true);
			}

			return $app['twig']->render('modal.html.twig', ['upSell' => $upSell, 'products' => $upSell->getProducts(), 'variants' => $variants]);

		});

		return $controllers;
	}
}