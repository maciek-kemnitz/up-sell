<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Lib\GateKeeper;
use src\Lib\ShoploObject;
use src\Model\CrossSell;
use src\Model\CrossSellQuery;
use src\Model\Product;
use src\Model\ProductInCart;
use src\Model\ProductQuery;
use src\Model\RelatedProduct;
use src\Model\UpSell;
use src\Model\UpSellPeer;
use src\Model\UpSellQuery;
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SaveController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->post('/', function (Request $request) use ($app)
		{
			$name = $request->request->get('name');
			$placement = $request->request->get('placement');
			$headline = $request->request->get('headline');
			$description = $request->request->get('description');
			$priceFrom = $request->request->get('price_from');
			$priceTo = $request->request->get('price_to');
			$priceRange = $request->request->get('price-range');
			$productTrigger = $request->request->get('selected-product-trigger');
			$upSellProducts = $request->request->get('up-sell-products');
			$upSellId = $request->request->get('upSellId');
			$discountType = $request->request->get('discount-type');
			$discountAmount = $request->request->get('discount-amount');

			/** @var ShoploObject $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO_OBJECT];
			$shopDomain = $shoploApi->getPermanentDomain();
			$shop = $shoploApi->getShop();


			if ($upSellId)
			{
				$upSell = UpSellQuery::create()->findPk($upSellId);

				if (null === $upSell)
				{
					throw new NotFoundHttpException();
				}

				if ($upSell->getShopDomain() != $shopDomain)
				{
					throw new AccessDeniedHttpException();
				}
			}
			else
			{
				$upSell = new UpSell();
			}


			$upSell->setShopDomain($shopDomain);
			$upSell->setShopId($shop['id']);
			$upSell->setName($name);
			$upSell->setHeadline($headline);
			$upSell->setDescription($description);
			$upSell->setPlacement($placement);

			if ($discountType)
			{
				$upSell->setDiscountType($discountType);

				if ($discountType == UpSellPeer::DISCOUNT_TYPE_NONE)
				{
					$upSell->setDiscountAmount(null);
				}
				else
				{
					$upSell->setDiscountAmount($discountAmount);
				}

			}

			if (null != $priceFrom)
			{
				$upSell->setPriceFrom($priceFrom);
			}

			if (null != $priceTo)
			{
				$upSell->setPriceTo($priceTo);
			}

			if ($priceRange == 'on')
			{
				$upSell->setUsePriceRange(UpSellPeer::USE_PRICE_RANGE_1);
			}
			else
			{
				$upSell->setUsePriceRange(UpSellPeer::USE_PRICE_RANGE_0);
			}

			$currentUpSellCount = UpSellQuery::create()
										->filterByShopDomain($shopDomain)
										->count();
			$currentUpSellCount++;

			$upSell->setOrder($currentUpSellCount);
			$upSell->setCreatedAt(date('Y-m-d H:i:s'));
			$upSell->save();

			$newRelatedProducts = [];

			if (count($upSellProducts) > 0)
			{
				foreach($upSellProducts as $productId => $data)
				{
					$shoploProduct = $shoploApi->getProduct($productId);

					$product = ProductQuery::create()
						->filterByShopDomain($shopDomain)
						->filterByShoploProductId($productId)
						->findOne();

					if (null == $product)
					{
						$product = new Product();
						$product->setName($shoploProduct['name']);
						$product->setShoploProductId($shoploProduct['id']);
						$product->setImgUrl($shoploProduct['thumbnail']);

						$variants = $shoploProduct['variants'];

						$product->setOriginalPrice($variants[0]['price']);
						$product->setUrl($shoploProduct['url']);
						$product->setShopDomain($shopDomain);
						$product->save();
					}

					if (false === isset($data['variant']))
					{
						$data['variant'][] = null;
					}

					foreach ($data['variant'] as $variantId)
					{
						if ('null' == $variantId)
						{
							$variantId = null;
						}
						$relatedProduct = new RelatedProduct();
						$relatedProduct->setUpSellId($upSell->getId());
						$relatedProduct->setProductId($productId);
						$relatedProduct->setVariantSelected($variantId);

						$newRelatedProducts[] = $relatedProduct;
					}
				}
			}


			$productInCartArray = [];

			if (count($productTrigger) > 0)
			{

				foreach ($productTrigger as $productId => $data)
				{
					if (false === isset($data['variant']))
					{
						$data['variant'][] = null;
					}

					foreach ($data['variant'] as $variantId)
					{
						if ('null' == $variantId)
						{
							$variantId = null;
						}
						$productInCart = new ProductInCart();
						$productInCart->setUpSellId($upSell->getId());
						$productInCart->setProductId($productId);
						$productInCart->setVariantSelected($variantId);

						$productInCartArray[] = $productInCart;
					}
				}
			}

			$upSell->setProductInCarts(new \PropelCollection($productInCartArray));
			$upSell->setRelatedProducts(new \PropelObjectCollection($newRelatedProducts));
			$upSell->save();

			return new RedirectResponse('/');
		});



		return $controllers;
	}
}