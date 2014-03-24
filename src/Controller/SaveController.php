<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Model\Product;
use src\Model\ProductInCart;
use src\Model\ProductQuery;
use src\Model\RelatedProduct;
use src\Model\UpSell;
use src\Model\UpSellQuery;
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->post('/', function (Request $request) use ($app)
		{
			$name = $request->request->get('name');
			$headline = $request->request->get('headline');
			$description = $request->request->get('description');
			$priceFrom = $request->request->get('price_from');
			$priceTo = $request->request->get('price_to');
			$productTrigger = $request->request->get('selected-product-trigger');
			$upSellProducts = $request->request->get('up-sell-products');

			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
			$shopDomain = $shoploApi->shop->retrieve()['domain'];


			$upSell = new UpSell();
			$upSell->setShopDomain($shopDomain);
			$upSell->setName($name);
			$upSell->setHeadline($headline);
			$upSell->setDescription($description);

			if ($priceFrom || $priceTo)
			{
				$upSell->setPriceFrom($priceFrom);
				$upSell->setPriceTo($priceTo);
			}

			$currentUpSellCount = UpSellQuery::create()
										->filterByShopDomain($shopDomain)
										->count();
			$currentUpSellCount++;

			$upSell->setOrder($currentUpSellCount);
			$upSell->setCreatedAt(date('Y-m-d H:i:s'));
			$upSell->save();


			if (count($upSellProducts) > 0)
			{
				foreach($upSellProducts as $productId)
				{
					$shoploProduct = $shoploApi->product->retrieve($productId)['products'];

					$product = ProductQuery::create()
										->filterByShopDomain($shopDomain)
										->filterByShoploProductId($shoploProduct['id'])
										->findOne();

					if (null == $product)
					{
						$product = new Product();
						$product->setName($shoploProduct['name']);
						$product->setId($shoploProduct['id']);
						$product->setImgUrl($shoploProduct['thumbnail']);

						$variants = $shoploProduct['variants'];

						$product->setOriginalPrice($variants[0]['price']);
						$product->setUrl($shoploProduct['url']);
						$product->setShopDomain($shopDomain);
						$product->save();
					}

					$relatedProduct = new RelatedProduct();
					$relatedProduct->setUpSellId($upSell->getId());
					$relatedProduct->setProductId($product->getShoploProductId());
					$relatedProduct->save();
				}
			}

			$product = null;

			if (count($productTrigger) > 0)
			{
				foreach($productTrigger as $productId)
				{
					$productInCart = new ProductInCart();
					$productInCart->setUpSellId($upSell->getId());
					$productInCart->setProductId($productId);
					$productInCart->save();
				}
			}


			return new RedirectResponse('/');
		});

		return $controllers;
	}
}