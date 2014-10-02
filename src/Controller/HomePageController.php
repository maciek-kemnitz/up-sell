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
use src\Model\UpSell;
use src\Model\UpSellPeer;
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
			$snippetName = 'snippets/up-sell.tpl';
			$productTemplate = 'templates/product.tpl';
			$snippetContent = '
				<script type="text/javascript">
					userData = {
					"productId": {$product->id},
					"shopDomain": "{$shop->permanent_domain}",
					"cartValue": {$cart->total_price},
					"productPrice": {$product->price}
					};
				</script>
				<script src="http://up-sell.pl/js/widget.js"></script>';
			$snippetInclude = PHP_EOL. '{snippet file="up-sell"}';

			/** @var ShoploObject $shoploApi */
			$shoploApi 	= $app[ServiceRegistry::SERVICE_SHOPLO_OBJECT];
			$shop 		= $shoploApi->getShop();

			$upSells = UpSellQuery::create()
				->filterByShopDomain($shop['permanent_domain'])
				->orderByOrder()
				->find();

			$themes = $shoploApi->getThemes();

			foreach ($themes as $theme)
			{
				$themeId 		= $theme['id'];
				$snippet 		= $shoploApi->getAssetByThemeIdAndName($themeId, $snippetName);
				$template 		= $shoploApi->getAssetByThemeIdAndName($themeId, $productTemplate);
				$currentContent = $template['content'];

				if (null === $snippet)
				{
					$shoploApi->createAsset($themeId, $snippetName, $snippetContent);
				}

				if (strpos($currentContent, trim($snippetInclude)) === false)
				{
					$currentContent .= $snippetInclude;
					$shoploApi->createAsset(
						$themeId,
						$template['key'],
						$currentContent,
						$template['content_type'],
						$template['public_url']
					);
				}
			}

			return $app['twig']->render('home.page.html.twig', ['product'=>$shoploApi->getProducts(), 'uppSells' => $upSells, 'shop'=>$shop]);

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
}