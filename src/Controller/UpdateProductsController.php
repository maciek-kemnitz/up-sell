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
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateProductsController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->get('/updateProducts', function () use ($app)
		{
			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
			$shop = $shoploApi->shop->retrieve();
			$shopDomain = $shop['permanent_domain'];
			$productCount = $shoploApi->product->count();

			var_dump($productCount);
			$pageCount = $productCount['count']/100;

			$pageCount = ceil($pageCount);
			var_dump($pageCount);
			$updated = 0;
			for($i=0; $i <= $pageCount; $i++)
			{
				var_dump($i);
				$products = $shoploApi->product->retrieve(0,0,0,["page"=>$i, "limit"=>100 ]);
				$products = $products['products'];

				$productIds = [];
				foreach ($products as $product)
				{
					if (isset($product['variants'][0]))
					{
						$productIds[$product['variants'][0]['id']]['sku'] = $product['variants'][0]['sku'];
						$productIds[$product['variants'][0]['id']]['price'] = $product['variants'][0]['price'];
						$productIds[$product['variants'][0]['id']]['price_regular'] = $product['variants'][0]['price_regular'];
						$productIds[$product['variants'][0]['id']]['availability'] = (int) $product['variants'][0]['availability'];
						$productIds[$product['variants'][0]['id']]['thumbnail'] = $product['variants'][0]['thumbnail'];
					}
					else
					{
						continue;
					}

				}


				/** @var \PropelObjectCollection|Product[] $ownedProducts */
				$ownedProducts = ProductQuery::create()
					->filterByShopDomain($shopDomain)
					->filterByShoploProductId(array_keys($productIds))
					->find();

				foreach ($ownedProducts as $ownedProduct)
				{
					$ownedProduct->setSku($productIds[$ownedProduct->getShoploProductId()]['sku']);
					$ownedProduct->setOriginalPrice($productIds[$ownedProduct->getShoploProductId()]['price_regular']/100);
					$ownedProduct->setCurrentPrice($productIds[$ownedProduct->getShoploProductId()]['price']/100);
					$ownedProduct->setAvailability($productIds[$ownedProduct->getShoploProductId()]['availability']);
					$ownedProduct->setThumbnail($productIds[$ownedProduct->getShoploProductId()]['thumbnail']);
					$ownedProduct->setImgUrl($productIds[$ownedProduct->getShoploProductId()]['thumbnail']);
					$ownedProduct->save();
					$updated++;
				}
			}

			echo "<strong>{$updated}</strong>";

			var_dump("done");
			exit;
		});



		return $controllers;
	}
}