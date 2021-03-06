<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Lib\GateKeeper;
use src\Lib\ShoploObject;
use src\Model\Product;
use src\Model\ProductPeer;
use src\Model\ProductQuery;
use src\Model\UpSellQuery;
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->get('/', function () use ($app)
		{

			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
			$shop = $shoploApi->shop->retrieve();
			$shopDomain = $shop['permanent_domain'];
			$productCount = $shoploApi->product->count();

			$pageCount = $productCount['count']/100;

			$pageCount = ceil($pageCount);
			for($i=0; $i <= $pageCount; $i++)
			{
				$products = $shoploApi->product->retrieve(0,0,0,["page"=>$i, "limit"=>100 ]);
				$tmpProducts = $products['products'];
				$products = [];

				foreach ($tmpProducts as $product)
				{
					$products[$product['id']] = $product;
				}

				$productIds = [];
				foreach ($products as $product)
				{
					if (isset($product['variants'][0]))
					{
						$productIds[$product['variants'][0]['id']] = $product['id'];
					}
					else
					{
						continue;
					}
				}

				/** @var \PropelObjectCollection $ownedIds */
				$ownedProducts = ProductQuery::create()
					->filterByShopDomain($shopDomain)
					->filterByShoploProductId(array_keys($productIds))
					->find();

				$ownedIds = $ownedProducts->toKeyValue('shoploProductId', 'shoploProductId');


				$missingProductIds = array_diff(array_keys($productIds), $ownedIds);


				foreach($missingProductIds as $productId)
				{
					$product = Product::getProductFromArray($products[$productIds[$productId]], $shopDomain);
				}
			}


			$upSell = null;

			return $app['twig']->render('add.page.html.twig', ['products'=>$shoploApi->product->retrieve(), 'shop'=> $shop]);
		});


		$controllers->get('/cross-sell', function () use ($app)
		{
			/** @var GateKeeper $gateKeeper */
			$gateKeeper = $app[ServiceRegistry::SERVICE_GATEKEEPER];

			if (false === $gateKeeper->hasAccess(GateKeeper::GATE_CROSS_SELL))
			{
				throw new AccessDeniedHttpException();
			}

			/** @var ShoploObject $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO_OBJECT];
			$shop = $shoploApi->getShop();
			$shopDomain = $shoploApi->getPermanentDomain();

			return $app['twig']->render('crossSell/add.page.html.twig', ['products' => $shoploApi->getProducts(), 'shop'=> $shop]);
		});


		return $controllers;
	}
}