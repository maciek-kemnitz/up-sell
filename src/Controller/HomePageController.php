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

		$controllers->get('/modal', function (Request $request) use ($app)
		{
			/** @var ShoploApi $shoploApi */
//			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
//			$product = $shoploApi->product->retrieve(68);
//			var_dump($product['products']);
			$upSell = UpSellQuery::create()->findPk(37);

			/** @var Product[] $upSellProducts */
			$upSellProducts = $upSell->getProducts();
			$variants = [];
			foreach ($upSellProducts as $product)
			{

				$variants[$product->getId()] = json_decode($product->getVariants(), true);
			}

			return $app['twig']->render('widget.page.html.twig', ['upSell' => $upSell, 'products' => $upSell->getProducts(), 'variants' => $variants]);

		});

		return $controllers;
	}
}