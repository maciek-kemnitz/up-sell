<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerProviderInterface;
use src\Lib\ShoploObject;
use src\Lib\Stats;
use src\Model\Product;
use src\Model\ProductInCart;
use src\Model\ProductInCartQuery;
use src\Model\ProductPeer;
use src\Model\ProductQuery;
use src\Model\TmpRequest;
use src\Model\TmpRequestPeer;
use src\Model\TmpRequestQuery;
use src\Model\UpSell;
use src\Model\UpSellPeer;
use src\Model\UpSellQuery;
use src\Model\UpSellStats;
use src\Model\WidgetStats;
use src\Model\WidgetStatsPeer;
use src\Model\WidgetStatsQuery;
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->post('/up-sell/product', function (Request $request) use ($app)
		{
			$productId 				= $request->request->get('productId');
			$shopDomain				= $request->request->get('shopDomain');
			$cartValue 				= $request->request->get('cartValue');
			$productCurrentPrice 	= $request->request->get('productPrice');
			$userKey 	            = $request->request->get('userKey');

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
				"user_key" => $userKey,
				"html"	=> $app['twig']->render('widget.page.html.twig', $params),

			];

			return new JsonResponse($data);

		});

		$controllers->post('/up-sell/cart', function (Request $request) use ($app)
		{
			$variantsInCart	= $request->request->get('variants');
			$shopDomain		= $request->request->get('shopDomain');
			$cartValue 		= $request->request->get('cartValue');
			if (null !== $cartValue)
			{
				$cartValue = round($cartValue / 100);
			}

			$userKey        = $request->request->get('userKey');

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
					return new JsonResponse(['status' => 'no up-sell', "cart_value" => $cartValue, "shop_domain" => $shopDomain]);
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
				return new JsonResponse(['status' => 'no up-sell', "cart_value" => $cartValue]);
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
				"user_key" => $userKey,
				"html"	=> $app['twig']->render('widget.page.html.twig', $params),

			];

			return new JsonResponse($data);

		});

		$controllers->post('/autocomplete', function (Request $request) use ($app)
		{
			$query = $request->request->get('query');

			/** @var ShoploObject $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO_OBJECT];
			$shopDomain = $shoploApi->getPermanentDomain();

			$products = ProductQuery::create()
				->filterByShopDomain($shopDomain)
				->filterByAvailability(1)
				->filterByName($query.'%', \Criteria::LIKE)
				->_or()
				->filterBySku($query.'%', \Criteria::LIKE)
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
			$shopDomain = $request->request->get('shopDomain');
			$upSellId = $request->request->get('up_sell_id');
			$variantId = $request->request->has('variant_id') ? $request->request->get('variant_id') : null;
			$placement = $request->request->get('placement');
			$userKey = $request->request->get('user_key');
//
			$data = [
				$shopDomain, $upSellId, $variantId, $placement
			];

			$widgetStats = new WidgetStats();
			$widgetStats->setShopDomain($shopDomain);
			$widgetStats->setUpSellId(intval($upSellId));
			$widgetStats->setVariantId($variantId);
			$widgetStats->setPlacement($placement);
			$widgetStats->setCreatedAt(new \DateTime());
			$widgetStats->setUserKey($userKey);
			$widgetStats->save();

			return new JsonResponse($data);
		});

		$controllers->post('/up-sell/home-page-stats', function (Request $request) use ($app)
		{
			$type = $request->request->get('type');
			$statsData = null;
			/** @var Stats $stats */
			$stats = $app[ServiceRegistry::SERVICE_STATS];

			$chartData = null;

			switch ($type)
			{
				case 'month':
					//co trzy dni
					$range = ['min' => new \DateTime("-30 days"), "max" => new \DateTime('+1 day')];
					$interval = new \DateInterval('P3D');
					$chartData = $stats->prepareChartData($range, $interval, 'Y-m-d');
					break;

				case 'day':
					//co dwie godziny
					$range = ['min' => new \DateTime("Today"), "max" => new \DateTime('Tomorrow')];
					$interval = new \DateInterval('PT1H');
					$chartData = $stats->prepareChartData($range, $interval, "H", true);
					break;

				case 'week':
					//co dzienie
					$range = ['min' => new \DateTime("-7 days"), "max" => new \DateTime('+1 day')];
					$interval = new \DateInterval('P1D');
					$chartData = $stats->prepareChartData($range, $interval, 'Y-m-d');
					break;
			}



			$view = $app['twig']->render(
				'homepage-stats.block.html.twig',
				['statsData' => $chartData['statsData']]);

			$data = [
				'html' => $view,
				'statsNumbers' => $chartData['statsNumbers'],
			];

			return new JsonResponse($data);
		});

		return $controllers;
	}


}