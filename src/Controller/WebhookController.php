<?php
/**
 * Created by PhpStorm.
 * User: maciekkemnitz
 * Date: 23/10/14
 * Time: 21:48
 */

namespace src\Controller;


use Silex\Application;
use Silex\ControllerProviderInterface;
use src\Lib\ShoploObject;
use src\Model\Product;
use src\Model\TmpRequest;

use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class WebhookController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->post('/order/created', function (Request $request) use ($app)
		{
			$hmac_key = $_SERVER['HTTP_SHOPLO_HMAC_SHA256'];
			$calculated_key = base64_encode(hash_hmac('sha256', http_build_query($_POST), SECRET_KEY));
			if ($hmac_key != $calculated_key)
			{
				return new AccessDeniedHttpException();
			}

			if (false === $request->request->has('order'))
			{
				exit;
			}

			$orderData = $request->request->get('order');

			$tmpRequest = new TmpRequest();
			$tmpRequest->setData(json_encode($orderData));
			$tmpRequest->setShopId($request->headers->get('shoplo-shop-id'));
			$tmpRequest->save();

			exit;

		});

		$controllers->post('/product/update', function (Request $request) use ($app)
		{
			$hmac_key = $_SERVER['HTTP_SHOPLO_HMAC_SHA256'];
			$calculated_key = base64_encode(hash_hmac('sha256', http_build_query($_POST), SECRET_KEY));
			if ($hmac_key != $calculated_key)
			{
				return new AccessDeniedHttpException();
			}

			if (false === $request->request->has('product'))
			{
				exit;
			}

			$productData = $request->request->get('product');

			$product = Product::updateProductFromArray($productData, $request->headers->get('shoplo-shop-id'));

			exit;

		});

		return $controllers;

	}

}
