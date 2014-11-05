<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Lib\ShoploObject;
use src\Model\Product;
use src\Model\ProductInCart;
use src\Model\ProductQuery;
use src\Model\RelatedProduct;
use src\Model\TmpRequest;
use src\Model\TmpRequestPeer;
use src\Model\TmpRequestQuery;
use src\Model\UpSell;
use src\Model\UpSellPeer;
use src\Model\UpSellQuery;
use src\Model\UpSellStats;
use src\Model\UpSellStatsQuery;
use src\Model\WidgetStats;
use src\Model\WidgetStatsPeer;
use src\Model\WidgetStatsQuery;
use src\Service\ServiceRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomePageController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->get('/', function (Request $request) use ($app)
		{
			$snippetName = ['snippets/up-sell.tpl', 'snippets/up-sell-cart.tpl'];
			$productTemplate = ['templates/product.tpl', 'templates/cart.tpl'];
			$snippetContent = [
				'<script type="text/javascript">
					userData = {
					"productId": {$product->variants[0]->id},
					"shopDomain": "{$shop->permanent_domain}",
					"cartValue": {$cart->total_price},
					"productPrice": {$product->price},
					"userKey": "{$cart->user_key}"
					};
				</script>
				<script src="http://up-sell.pl/js/widget.js"></script>',
				'<script type="text/javascript">
					var userData = {
						"shopDomain": "{$shop->permanent_domain}",
						"cartValue": {$cart->total_price},
						"userKey": "{$cart->user_key}",
						"variants": [
							{foreach from=$cart->items name=loop item="item"}
								"{$item->variant->id}"{if not $smarty.foreach.loop.last},{/if}
							{/foreach}
						]
					};
				</script>
				<script src="http://up-sell.pl/js/widget-cart.js"></script>'
			];

			$snippetInclude = [PHP_EOL. '{snippet file="up-sell"}', PHP_EOL. '{snippet file="up-sell-cart"}'];

			/** @var ShoploObject $shoploApi */
			$shoploApi 	= $app[ServiceRegistry::SERVICE_SHOPLO_OBJECT];
			$shop 		= $shoploApi->getShop();

			/** @var UpSell[] $upSells */
			$upSells = UpSellQuery::create()->findByShopDomain($shoploApi->getPermanentDomain());
			foreach ($upSells as $upSell)
			{
				$upSell->setShopId($shop['id']);
				$upSell->save();
			}

			$themes = $shoploApi->getThemes();

			foreach ($themes as $theme)
			{
				$themeId 		= $theme['id'];

				for ($i = 0; $i < 2; $i++)
				{
					$snippet 		= $shoploApi->getAssetByThemeIdAndName($themeId, $snippetName[$i]);
					$template 		= $shoploApi->getAssetByThemeIdAndName($themeId, $productTemplate[$i]);
					$currentContent = $template['content'];

					if (null === $snippet || strpos($snippet['content'], trim($snippetContent[$i])) === false)
					{
						$shoploApi->createAsset($themeId, $snippetName[$i], $snippetContent[$i]);
					}

					if (strpos($currentContent, trim($snippetInclude[$i])) === false)
					{
						$currentContent .= $snippetInclude[$i];
						$shoploApi->createAsset(
								  $themeId,
									  $template['key'],
									  $currentContent,
									  $template['content_type'],
									  $template['public_url']
						);
					}
				}
			}

			$upSellShowRate = 0;
			$upSellRevenue = 0;
			$avgCartValue = 0;
			$cartValue = 0;

			/** @var WidgetStats[] $widgetStats */
			$widgetStats = WidgetStatsQuery::create()
				->filterByShopDomain($shoploApi->getPermanentDomain())
				->filterByCreatedAt(['min' => new \DateTime("-7 days"), "max" => new \DateTime()])
				->orderByCreatedAt()
				->find();

			foreach ($widgetStats as $widget)
			{
				if (null === $widget->getVariantId())
				{
					$upSellShowRate++;
				}
			}

			/** @var UpSellStats[]|\PropelObjectCollection $stats */
			$stats = UpSellStatsQuery::create()
				->filterByShopDomain($shoploApi->getPermanentDomain())
				->filterByCreatedAt(['min' => new \DateTime("-7 days"), "max" => new \DateTime()])
				->orderByCreatedAt()
				->find();


			$interval = new \DateInterval('P1D');
			/** @var \DateTime[] $statsRange */
			$statsRange = new \DatePeriod(new \DateTime('-7 days'), $interval, new \DateTime());

			$statsData = [];

			foreach ($statsRange as $date)
			{
				$dateString = $date->format('Y-m-d');
				if (false == isset($statsData[$dateString]))
				{
					$statsData[$dateString]['upSellValue'] = 0;
					$statsData[$dateString]['fullValue'] = 0;
				}
			}

			foreach ($stats as $stat)
			{
				$dateString = $stat->getCreatedAt('Y-m-d');
				$statsData[$dateString]['upSellValue'] += round($stat->getUpSellValue() / 100,2);
				$statsData[$dateString]['fullValue'] += round($stat->getFullValue() / 100, 2);

				$upSellRevenue += round($stat->getUpSellValue() / 100,2);
				$cartValue += round($stat->getFullValue() / 100,2);
			}

			$avgCartValue = round($cartValue / $stats->count(), 2);

			$this->calculateStats($shoploApi);

			$upSells = UpSellQuery::create()
				->filterByShopDomain($shop['permanent_domain'])
				->orderByOrder()
				->find();

			return $app['twig']->render('home.page.html.twig', [
				'product'=>$shoploApi->getProducts(), 'uppSells' => $upSells, 'shop'=>$shop,
				'upSellShowRate' => $upSellShowRate,
				'upSellRevenue' => $upSellRevenue,
				'avgCartValue' => $avgCartValue,
				'statsData' => $statsData
			]);

		});

		$controllers->get('/logout', function (Request $request) use ($app)
		{
			session_unset();

			return new RedirectResponse('/');

		});

		$controllers->get('/copy', function (Request $request) use ($app)
		{
			/** @var ShoploApi $shoploApi */
			$shoploApi = $app[ServiceRegistry::SERVICE_SHOPLO];
			$shop = $shoploApi->shop->retrieve();

			$newShopDomain = $shop['permanent_domain'];
			$oldShopDomain = $request->query->get('from');

			echo "<h2>Copy form: ".$oldShopDomain." To: ".$newShopDomain."</h2><hr>";


			/** @var UpSell[] $upSells */
			$upSells = UpSellQuery::create()
				->findByShopDomain($oldShopDomain);

			foreach ($upSells as $upSell)
			{
				$newUpSell = new UpSell();
				$upSell->copyInto($newUpSell);
				$newUpSell->setShopDomain($newShopDomain);
				$newUpSell->save();

				$relatedProducts = $upSell->getRelatedProducts();

				foreach ($relatedProducts as $relatedProduct)
				{
					$newRelated = new RelatedProduct();
					$relatedProduct->copyInto($newRelated);
					$newRelated->setUpSellId($newUpSell->getId());
					$newRelated->save();
				}

				$productInCarts = $upSell->getProductInCarts();

				foreach ($productInCarts as $productInCart)
				{
					$newProductInCart = new ProductInCart();
					$productInCart->copyInto($newProductInCart);
					$newProductInCart->setUpSellId($newUpSell->getId());
					$newProductInCart->save();
				}

				echo $upSell->getName() ."<br>";
			}



			return new Response("<h1>done</h1>");

		});

		$controllers->get('/modal', function (Request $request) use ($app)
		{
			$upSell = UpSellQuery::create()->findPk(497);

			/** @var Product[] $upSellProducts */
			$upSellProducts = $upSell->getProducts();
			$variants = [];

			$rProducts = $upSell->getRelatedProducts();

			foreach ($upSellProducts as $product)
			{
				$variantsTmp = json_decode($product->getVariants(), true);

				$varaintProducts = ProductQuery::create()->findPks($variantsTmp)->getArrayCopy();

				$variants[$product->getId()] = json_decode($product->getVariants(), true);
			}

			return $app['twig']->render('modal.html.twig', ['upSell' => $upSell, 'products' => $upSell->getProducts(), 'variants' => $variants, 'rProducts' => $rProducts]);

		});

		$controllers->get('/robots.txt', function (Request $request) use ($app)
		{
			$response = new Response(
				"User-agent: *
				Allow: /");
			$response->headers->set('Content-Type', 'text/plain');
			$response->setCharset('UTF-8');
			return $response;
		});

		return $controllers;
	}

	public function calculateStats(ShoploObject $shoploApi)
	{
		$shop = $shoploApi->getShop();

		/** @var TmpRequest[] $tmpRequests */
		$tmpRequests = TmpRequestQuery::create()
			->filterByStatus(TmpRequestPeer::STATUS_NEW)
			->filterByShopId($shop['id'])
			->find();


		foreach($tmpRequests as $tmpRequest)
		{
			$data = json_decode($tmpRequest->getData(), true);
			$orderId = $data['id'];
			$orderCreatedAt = new \DateTime($data['created_at']);
			$checkout = $shoploApi->getCheckout($orderId);
			$userKey = $checkout['user_key'];
			$orderItems = $data["order_items"];
			$variants = [];

			foreach ($orderItems as $item)
			{
				$variantId = $item["variant_id"];
				$variants[$variantId] = $item;

			}

			/** @var WidgetStats[]|\PropelObjectCollection $widgetStats */
			$widgetStats = WidgetStatsQuery::create()
				->filterByUserKey($userKey)
				->filterByVariantId(array_keys($variants), \Criteria::IN)
				->filterByShopDomain($shoploApi->getPermanentDomain())
				->filterByStatus(WidgetStatsPeer::STATUS_NEW)
				->find();

			$upSellVariants = [];

			if ($widgetStats->count() > 0)
			{
				$upSellVariants = $widgetStats->toKeyValue('variantId', 'variantId');
			}

			$upSellSum = 0;
			$sum = 0;

			foreach ($variants as $key => $variant)
			{
				if (in_array($key, $upSellVariants))
				{
					$upSellSum += $variant['price'];
				}

				$sum += $variant['price'];
			}

			$newUpsellStats = new UpSellStats();
			$newUpsellStats->setFullValue($sum);
			$newUpsellStats->setUpSellValue($upSellSum);
			$newUpsellStats->setOrderId($orderId);
			$newUpsellStats->setCreatedAt($orderCreatedAt);
			$newUpsellStats->setShopDomain($shoploApi->getPermanentDomain());
			$newUpsellStats->save();

			$tmpRequest->setStatus(TmpRequestPeer::STATUS_CALCULATED);
			$tmpRequest->save();

			if ($widgetStats->count() > 0)
			{
				foreach ($widgetStats as $widgetStat)
				{
					$widgetStat->setStatus(WidgetStatsPeer::STATUS_CALCULATED);
					$widgetStat->save();
				}
			}
		}
	}
}