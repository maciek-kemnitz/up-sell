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

			$requestParams = $request->request->all();

			$tmpRequest = new TmpRequest();
			$tmpRequest->setData(json_encode($requestParams));
			$tmpRequest->save();
			exit;

			if (false === $request->request->has('order'))
			{
				throw new \Exception("Order not found");
			}


			$orderData = $request->request->get('order');
			$orderId = $orderData['id'];

			/** @var ShoploObject $shoploApi */
			$shoploApi 	= $app[ServiceRegistry::SERVICE_SHOPLO_OBJECT];
			$shop 		= $shoploApi->getShop();

			$checkout = $shoploApi->getCheckout($orderId);

			$tmpRequest = new TmpRequest();
			$tmpRequest->setData(json_encode($checkout));
			$tmpRequest->save();

			if (null === $checkout || empty($checkout))
			{
				throw new \Exception("Checkout not found for order_id: ". $orderId);
			}



			//find stats for this user_key
			//find products metching checkout and stats
			//save order full value, upsell value, created_at


			exit;
//			/** @var ShoploObject $shoploApi */
//			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO_OBJECT];
//
//			$orders = $shoploApi->getOrders();
//
//////			var_dump($orders);
////			foreach ($orders as $order)
////			{
////				var_dump($order);
////				echo "<hr>";
////			}
//
//			$checkouts = $shoploApi->getCheckout();
//
//			var_dump($checkouts);

		});

		return $controllers;

	}

} 