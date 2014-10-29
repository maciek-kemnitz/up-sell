<?php

namespace src\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use src\Model\WidgetStats;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WidgetStatsController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->post('/', function (Request $request) use ($app)
		{
			$shopDomain = $request->request->get('shopDomain');
			$upSellId = $request->request->get('up_sell_id');
			$variantId = $request->request->has('variant_id') ? $request->request->get('variant_id') : null;
			$placement = $request->request->get('placement');
			$userKey = $request->request->get('user_key');

			$widgetStats = new WidgetStats();
			$widgetStats->setShopDomain($shopDomain);
			$widgetStats->setUpSellId($upSellId);
			$widgetStats->setVariantId($variantId);
			$widgetStats->setPlacement($placement);
			$widgetStats->setCreatedAt(new \DateTime());
			$widgetStats->setUserKey($userKey);
			$widgetStats->save();

			return new JsonResponse();
		});

		return $controllers;

	}

} 