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
			$shopDomain = $shoploApi->shop->retrieve()['domain'];

			$products = $shoploApi->product->retrieve();
			$products = $products['products'];


			$productIds = array_keys($products);

			/** @var \PropelObjectCollection $ownedIds */
			$ownedProducts = ProductQuery::create()
							->filterByShopDomain($shopDomain)
							->filterByShoploProductId($productIds)
							->find();

			$ownedIds = $ownedProducts->toKeyValue('shoploProductId', 'shoploProductId');


			$missingProductIds = array_diff($productIds, $ownedIds);


			foreach($missingProductIds as $productId)
			{
				$product = new Product();
				$product->setShopDomain($shopDomain);
				$product->setShoploProductId($productId);
				$product->setName($products[$productId]['name']);

				$images = $products[$productId]['images'];

				if (count($images))
				{
					$firstImage = reset($images);
					$product->setImgUrl($firstImage['src']);
				}

				$product->setThumbnail($products[$productId]['thumbnail']);

				$variants = $products[$productId]['variants'];
				$firstVariant = reset($variants);

				$product->setOriginalPrice($firstVariant['price']);
				$product->setUrl($products[$productId]['url']);
				$product->setSku($firstVariant['sku']);
				$product->save();

			}

			$upSell = null;

			return $app['twig']->render('add.page.html.twig', ['products'=>$shoploApi->product->retrieve()]);
		});



		return $controllers;
	}
}