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
use src\Model\UpSellPeer;
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
			$priceRange = $request->request->get('price-range');
			$productTrigger = $request->request->get('selected-product-trigger');
			$upSellProducts = $request->request->get('up-sell-products');
			$upSellId = $request->request->get('upSellId');
			$discountType = $request->request->get('discount-type');
			$discountAmount = $request->request->get('discount-amount');

			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
			$shopDomain = $shoploApi->shop->retrieve()['permanent_domain'];


			if ($upSellId)
			{
				$upSell = UpSellQuery::create()->findPk($upSellId);

				if (null === $upSell)
				{
					throw new NotFoundHttpException();
				}


				$shop = $shoploApi->shop->retrieve();

				if ($shop['permanent_domain'] != $shopDomain)
				{
					throw new AccessDeniedHttpException();
				}
			}
			else
			{
				$upSell = new UpSell();
			}


			$upSell->setShopDomain($shopDomain);
			$upSell->setName($name);
			$upSell->setHeadline($headline);
			$upSell->setDescription($description);
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
			$relatedProducts = $upSell->getRelatedProducts()->getArrayCopy('productId');
			$productsInCart = $upSell->getProductInCarts()->getArrayCopy('productId');
			$newRelatedProducts = [];
			$newProductsInCart = [];

			if (count($upSellProducts) > 0)
			{
				foreach($upSellProducts as $productId)
				{
					$variantSet = null;

					if ($request->request->has('variant_selected-'.$productId))
					{
						$variantSet = $request->request->get('variant_selected-'.$productId);
					}

					$shoploProduct = $shoploApi->product->retrieve($productId)['products'];


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

					if (!array_key_exists($productId, $relatedProducts))
					{
						$relatedProduct = new RelatedProduct();
						$relatedProduct->setUpSellId($upSell->getId());
						$relatedProduct->setProductId($productId);
						$relatedProduct->setVariantSelected($variantSet);
						$relatedProduct->save();

						$newRelatedProducts[] = $relatedProduct;
					}
					else
					{
						$relatedProduct = $relatedProducts[$productId];
						$relatedProduct->setVariantSelected($variantSet);
						$relatedProduct->save();
						$newRelatedProducts[] = $relatedProduct;

					}

				}
			}

			$product = null;

			if (count($productTrigger) > 0)
			{
				foreach($productTrigger as $productId)
				{
					$variantSet = null;

					if ($request->request->has('variant_selectedPCR-'.$productId))
					{
						$variantSet = $request->request->get('variant_selectedPCR-'.$productId);
					}

					if (!array_key_exists($productId, $productsInCart))
					{
						$productInCart = new ProductInCart();
						$productInCart->setUpSellId($upSell->getId());
						$productInCart->setProductId($productId);
						$productsInCart->setVariantSelected($variantSet);
						$productInCart->save();

						$newProductsInCart[] = $productInCart;
					}
					else
					{
						$productsInCart = $productsInCart[$productId];
						$productsInCart->setVariantSelected($variantSet);
						$productsInCart->save();
						$newProductsInCart[] = $productsInCart;
					}
				}
			}

			$upSell->setRelatedProducts(new \PropelObjectCollection($newRelatedProducts));
			$upSell->setProductInCarts(new \PropelObjectCollection($newProductsInCart));
			$upSell->save();


			return new RedirectResponse('/');
		});

		return $controllers;
	}
}