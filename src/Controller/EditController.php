<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Model\UpSellQuery;
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->get('/{upSellId}', function ($upSellId) use ($app)
		{

			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
			$shop = $shoploApi->shop->retrieve();
			$shopDomain = $shop['permanent_domain'];
			$upSell = UpSellQuery::create()->findPk($upSellId);

			if (null === $upSell)
			{
				throw new NotFoundHttpException();
			}


			$shop = $shoploApi->shop->retrieve();

			if ($shop['permanent_domain'] != $upSell->getShopDomain())
			{
				throw new AccessDeniedHttpException();
			}



			return $app['twig']->render('add.page.html.twig', ['products'=>$shoploApi->product->retrieve(), 'upSell' => $upSell, 'shop'=> $shop]);
		});



		return $controllers;
	}
}