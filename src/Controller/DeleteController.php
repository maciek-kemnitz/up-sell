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
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->get('/', function (Request $request) use ($app)
		{
			$upSellId = $request->query->get('up-sell-id');

			$upSell = UpSellQuery::create()->findPk($upSellId);

			if (null === $upSell)
			{
				throw new NotFoundHttpException();
			}

			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
			$shop = $shoploApi->shop->retrieve();

			if ($shop['domain'] != $upSell->getShopDomain())
			{
				throw new AccessDeniedHttpException();
			}

			$db = \Propel::getConnection('up-sell');
			$db->beginTransaction();

			try
			{
				$upSell->getRelatedProducts()->delete();
				$upSell->getProductInCarts()->delete();
				$upSell->delete();

				$db->commit();
			}
			catch (\Exception $exc)
			{
				$db->rollBack();
			}


			return new RedirectResponse('/');
		});

		return $controllers;
	}
}