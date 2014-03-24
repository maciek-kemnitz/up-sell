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


			$data = [
				"status" => "ok",
				"html"	=> $app['twig']->render('widget.page.html.twig', ['upSell' => $upSellByRelation, 'products' => $upSellByRelation->getProducts()]),

			];

			return new JsonResponse($data);

		});

		return $controllers;
	}
}