<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Lib\Database;
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
								->priceInRange($futureCartValue);





			$config = array(
				'api_key'      =>  CONSUMER_KEY,
				'secret_key'   =>  SECRET_KEY,
				'callback_url' =>  CALLBACK_URL,
			);
			$shoploApi = new ShoploApi($config);


			$relatedProducts = Database::getRelatedProductByProductId($productId);

			if (count($relatedProducts) > 0)
			{
				$product = $relatedProducts[0];
				$data = [
					"status" => "ok",
					"html"	=> $app['twig']->render('widget.page.html.twig', ['id' => $product->getId(), "up_sell_id" => $product->getUpSellId()])
				];

				return new JsonResponse($data);
			}





			return new JsonResponse(['status' => 'no up-sell']);
		});

		return $controllers;
	}
}