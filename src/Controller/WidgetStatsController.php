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
			$shopDomain = $request->query->get('shopDomain');
			$upSellId = $request->query->get('up_sell_id');
			$variant_id = $request->query->get('variant_id');
			$placement = $request->query->get('placement');

			$widgetStats = new WidgetStats();
			$widgetStats->setShopDomain($shopDomain);
			$widgetStats->setUpSellId($upSellId);
			$widgetStats->setVariantId($variant_id);
			$widgetStats->setPlacement($placement);
			$widgetStats->setCreatedAt(new \DateTime());
			$widgetStats->save();

			return new JsonResponse();
		});

		return $controllers;

	}

} 