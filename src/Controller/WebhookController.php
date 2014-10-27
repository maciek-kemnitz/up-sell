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
use Symfony\Component\HttpFoundation\Request;

class WebhookController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->post('/order/created', function (Request $request) use ($app)
		{
			$requestParams = $request->request->all();
			$queryParams = $request->query->all();

			$tab = [
				'request' =>$requestParams,
				'query' => $queryParams
			];

			$tmpRequest = new TmpRequest();
			$tmpRequest->setData(json_encode($tab));
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