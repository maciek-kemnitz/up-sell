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
			$productId = $request->request->get('productId');
			$productCurrentPrice = $request->request->get('productPrice');
			$cartValue = $request->request->get('cartValue');

			$futureCartValue = $cartValue + $productCurrentPrice;


			$upSells = UpSellQuery::create()
								->priceInRange($futureCartValue)
								->find();

			$upSellByRelations = UpSellQuery::create()
											->useRelatedProductQuery()
												->filterByProductId($productId)
											->endUse()
											->find();





			if ($upSellByRelations->count() > 0)
			{
				/** @var UpSell $upSellByRelation */
				$upSellByRelation = $upSellByRelations->getFirst();


				$data = [
					"status" => "ok",
					"html"	=> $app['twig']->render('widget.page.html.twig', ['upSell' => $upSellByRelation, 'products' => $upSellByRelation->getProducts()])
				];

				return new JsonResponse($data);
			}





			return new JsonResponse(['status' => 'no up-sell']);
		});

		return $controllers;
	}
}