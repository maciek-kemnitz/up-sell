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