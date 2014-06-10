<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

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
			$shopDomain = $shoploApi->shop->retrieve()['permanent_domain'];
			$productCount = $shoploApi->product->count();

			$pageCount = $productCount['count']/100;

			$pageCount = ceil($pageCount);
			for($i=0; $i <= $pageCount; $i++)
			{
				$products = $shoploApi->product->retrieve(0,0,0,["page"=>$i, "limit"=>100 ]);
				$products = $products['products'];


				$productIds = [];
				foreach ($products as $product)
				{
					if (isset($product['variants'][0]))
					{
						$productIds[$product['variants'][0]['product_id']] = $product['id'];
					}
					else
					{
						continue;
					}
				}

				/** @var \PropelObjectCollection $ownedIds */
				$ownedProducts = ProductQuery::create()
					->filterByShopDomain($shopDomain)
					->filterByShoploProductId($productIds)
					->find();

				$ownedIds = $ownedProducts->toKeyValue('shoploProductId', 'shoploProductId');

				$missingProductIds = array_diff(array_keys($productIds), $ownedIds);


				foreach($missingProductIds as $productId)
				{

					$product = Product::getProductFromArray($products[$productIds[$productId]], $shopDomain);
				}
			}


			$upSell = null;

			return $app['twig']->render('add.page.html.twig', ['products'=>$shoploApi->product->retrieve()]);
		});



		return $controllers;
	}
}