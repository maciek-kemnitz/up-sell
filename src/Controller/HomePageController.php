<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerProviderInterface;

use src\Lib\ShoploObject;
use src\Lib\Stats;
use src\Model\Product;
use src\Model\ProductInCart;
use src\Model\ProductQuery;
use src\Model\RelatedProduct;
use src\Model\UpSell;
use src\Model\UpSellQuery;
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
				<script src="http://up-sell.pl/js/remodal.js"></script>
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

			/** @var Stats $stats */
			$stats = $app[ServiceRegistry::SERVICE_STATS];
			$stats->calculateStats();
			$range = ['min' => new \DateTime("-7 days"), "max" => new \DateTime('+1 day')];
			$interval = new \DateInterval('P1D');

			$chartData = $stats->prepareChartData($range, $interval, 'Y-m-d');


			$upSells = UpSellQuery::create()
			                      ->filterByShopDomain($shop['permanent_domain'])
			                      ->orderByOrder()
			                      ->find();

			return $app['twig']->render('home.page.html.twig', [
				'product'=>$shoploApi->getProducts(), 'uppSells' => $upSells, 'shop'=>$shop,
				'statsNumbers' => $chartData['statsNumbers'],
				'statsData' => $chartData['statsData']
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
			$upSell = UpSellQuery::create()->findPk(799);

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

			return $app['twig']->render('modal.html.twig', [
				'upSell' => $upSell,
				'products' => $upSell->getProducts(),
				'variants' => $variants,
				'rProducts' => $rProducts,
				'placement' => "product"
			]);

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

}