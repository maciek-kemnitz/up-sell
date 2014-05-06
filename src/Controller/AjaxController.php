<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Lib\Database;
use src\Model\ProductQuery;
use src\Model\RelatedProduct;
use src\Model\UpSell;
use src\Model\UpSellPeer;
use src\Model\UpSellQuery;
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

			$futureCartValue = $cartValue + $productCurrentPrice;


			$uppSells = UpSellQuery::create()
								->filterByShopDomain($shopDomain)
								->filterByStatus(UpSellPeer::STATUS_ACTIVE)
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
									->filterByShopDomain($shopDomain)
									->orderBy(UpSellPeer::ORDER)
									->find();


				if (!$uppSells->count())
				{
					return new JsonResponse(['status' => 'no up-sell', "count" => ($uppSells->count()), 'fcv'=>$futureCartValue]);
				}
			}


			/** @var UpSell $upSellByRelation */
			$upSellByRelation = $uppSells->getFirst();

			/** @var Product[] $upSellProducts */
			$upSellProducts = $upSellByRelation->getProducts();
			$variants = [];
			foreach ($upSellProducts as $product)
			{

				$variants[$product->getId()] = json_decode($product->getVariants(), true);
			}

			$data = [
				"status" => "ok",
				"html"	=> $app['twig']->render('widget.page.html.twig', ['upSell' => $upSellByRelation, 'products' => $upSellByRelation->getProducts(), 'variants' => $variants]),

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
							->filterByName('%'.$query.'%', \Criteria::LIKE)
							->filterByShopDomain($shopDomain)
							->find();

			$view = $app['twig']->render('autocomplete-products.html.twig', ['products'=>$products]);

			$result = [
				'status'	=> 'ok',
				'html'		=> $view,
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

		return $controllers;
	}
}