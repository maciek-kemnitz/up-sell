<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerProviderInterface;
use src\Model\Product;
use src\Model\ProductInCart;
use src\Model\ProductInCartQuery;
use src\Model\ProductQuery;
use src\Model\UpSell;
use src\Model\UpSellPeer;
use src\Model\UpSellQuery;
use src\Model\WidgetStats;
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->post('/up-sell/test', function (Request $request) use ($app)
		{
			return new JsonResponse(['status' => 'no up-sell']);
		});

		$controllers->post('/up-sell/product', function (Request $request) use ($app)
		{
			$productId 				= $request->request->get('productId');
			$shopDomain				= $request->request->get('shopDomain');
			$cartValue 				= $request->request->get('cartValue');
			$productCurrentPrice 	= $request->request->get('productPrice');

			$futureCartValue = $cartValue + $productCurrentPrice;


			$uppSells = UpSellQuery::create()
				->filterByShopDomain($shopDomain)
				->filterByStatus(UpSellPeer::STATUS_ACTIVE)
				->filterByPlacement(UpSellPeer::PLACEMENT_PRODUCT)
				->useProductInCartQuery()
					->filterByProductId($productId)
				->endUse()
				->orderBy(UpSellPeer::ORDER)
				->distinct()
				->find();

			if (!$uppSells->count())
			{
				$uppSells = UpSellQuery::create()
					->priceInRange($futureCartValue)
					->filterByUsePriceRange(UpSellPeer::USE_PRICE_RANGE_1)
					->filterByStatus(UpSellPeer::STATUS_ACTIVE)
					->filterByPlacement(UpSellPeer::PLACEMENT_PRODUCT)
					->filterByShopDomain($shopDomain)
					->orderBy(UpSellPeer::ORDER, \Criteria::ASC)
					->find();


				if (!$uppSells->count())
				{
					return new JsonResponse(['status' => 'no up-sell']);
				}
			}


			/** @var UpSell $upSellByRelation */
			$upSellByRelation = $uppSells->getFirst();
			$rProducts = $upSellByRelation->getRelatedProducts();

			/** @var Product[] $upSellProducts */
			$upSellProducts = $upSellByRelation->getProducts();
			$variants = [];
			foreach ($upSellProducts as $product)
			{
				$variants[$product->getId()] = json_decode($product->getVariants(), true);
			}

			$params = [
				'upSell' => $upSellByRelation,
				'products' => $upSellByRelation->getProducts(),
				'variants' => $variants,
				'rProducts' => $rProducts,
				'placement' => "product"
			];

			/** @var ProductInCart $productInCart */
			$productInCart = ProductInCartQuery::create()
				->filterByProductId($productId)
				->filterByUpSell($upSellByRelation)
				->findOne();

			if (null !== $productInCart && $productInCart->getVariantSelected())
			{
				$params['variantSelected'] = $productInCart->getVariantSelected();
			}

			$data = [
				"status" => "ok",
				"up_sell_id" => $upSellByRelation->getId(),
				"shopDomain" => $shopDomain,
				"html"	=> $app['twig']->render('widget.page.html.twig', $params),

			];

			return new JsonResponse($data);

		});

		$controllers->post('/up-sell/cart', function (Request $request) use ($app)
		{
			$variantsInCart	= $request->request->get('variants');
			$shopDomain		= $request->request->get('shopDomain');
			$cartValue 		= $request->request->get('cartValue');

			$uppSells = UpSellQuery::create()
				->filterByShopDomain($shopDomain)
				->filterByStatus(UpSellPeer::STATUS_ACTIVE)
				->filterByPlacement(UpSellPeer::PLACEMENT_CART)
					->useProductInCartQuery()
						->filterByProductId($variantsInCart)
					->endUse()
				->orderBy(UpSellPeer::ORDER)
				->distinct()
				->find();

			if (!$uppSells->count())
			{
				$uppSells = UpSellQuery::create()
					->priceInRange($cartValue)
					->filterByUsePriceRange(UpSellPeer::USE_PRICE_RANGE_1)
					->filterByStatus(UpSellPeer::STATUS_ACTIVE)
					->filterByPlacement(UpSellPeer::PLACEMENT_CART)
					->filterByShopDomain($shopDomain)
					->orderBy(UpSellPeer::ORDER, \Criteria::ASC)
					->find();


				if (!$uppSells->count())
				{
					return new JsonResponse(['status' => 'no up-sell']);
				}
			}


			/** @var UpSell $uppSell */
			$uppSell = $uppSells->getFirst();
			$rProducts = $uppSell->getRelatedProducts();

			/** @var Product[] $upSellProducts */
			$upSellProducts = $uppSell->getProducts();
			$variants = [];
			foreach ($upSellProducts as $product)
			{
				if (false == in_array($product->getShoploProductId(), $variantsInCart))
				{
					$variants[$product->getId()] = json_decode($product->getVariants(), true);
				}
			}

			if (0 == count($variants))
			{
				return new JsonResponse(['status' => 'no up-sell']);
			}

			$params = [
				'upSell' => $uppSell,
				'products' => $uppSell->getProducts(),
				'variants' => $variants,
				'rProducts' => $rProducts,
				'placement' => "cart"
			];

			/** @var ProductInCart $productInCart */
			$productInCart = ProductInCartQuery::create()
				->filterByProductId($variants)
				->filterByUpSell($uppSell)
				->findOne();

			if (null !== $productInCart && $productInCart->getVariantSelected())
			{
				$params['variantSelected'] = $productInCart->getVariantSelected();
			}


			$data = [
				"status" => "ok",
				"variants" => json_encode($variants),
				"up_sell_id" => $uppSell->getId(),
				"shopDomain" => $shopDomain,
				"html"	=> $app['twig']->render('widget.page.html.twig', $params),

			];

			return new JsonResponse($data);

		});

		$controllers->post('/autocomplete', function (Request $request) use ($app)
		{
			$method = $request->query->get('method');
			$resource = $request->query->get('resource');
			$size = $request->query->get('size');
			$query = $request->request->get('query');
			$offset = $request->query->get('offset');
			$limit = $request->query->get('limit');

			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
			$shopDomain = $shoploApi->shop->retrieve()['permanent_domain'];

			$products = ProductQuery::create()
				->filterByName($query.'%', \Criteria::LIKE)
				->filterByShopDomain($shopDomain)
				->limit(20)
				->find();

			$view = $app['twig']->render('autocomplete-products.html.twig', ['products'=>$products]);

			$result = [
				'status'	=> 'ok',
				'html'		=> $view,
				'cnt'		=> $products->count()
			];



			return new JsonResponse($result);
		});

		$controllers->post('/sort', function (Request $request) use ($app)
		{
			$upSellIds = $request->request->get('data');

			/** @var \PropelObjectCollection $upSells */
			$upSells = UpSellQuery::create()->findById($upSellIds);
			$upSells = $upSells->getArrayCopy('id');
			$orderIndex = 1;

			foreach($upSellIds as $id)
			{
				/** @var UpSell $upSell */
				$upSell = $upSells[$id];
				$upSell->setOrder($orderIndex);
				$upSell->save();

				$orderIndex++;
			}

			$result = [
				'status'	=> 'ok',
			];



			return new JsonResponse($result);
		});

		$controllers->post('/up-sell/stats', function (Request $request) use ($app)
		{
//			$shopDomain = $request->request->get('shopDomain');
//			$upSellId = $request->request->get('up_sell_id');
//			$variantId = $request->request->has('variant_id') ? $request->request->get('variant_id') : null;
//			$placement = $request->request->get('placement');
//
//			$widgetStats = new WidgetStats();
//			$widgetStats->setShopDomain($shopDomain);
//			$widgetStats->setUpSellId($upSellId);
//			$widgetStats->setVariantId($variantId);
//			$widgetStats->setPlacement($placement);
//			$widgetStats->setCreatedAt(new \DateTime());
//			$widgetStats->save();

			return new JsonResponse();
		});

		return $controllers;
	}
}