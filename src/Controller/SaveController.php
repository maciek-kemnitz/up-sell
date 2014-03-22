<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use src\Model\Product;
use src\Model\ProductInCart;
use src\Model\RelatedProduct;
use src\Model\UpSell;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->post('/', function (Request $request) use ($app)
		{
			var_dump($request->request);

			$name = $request->request->get('name');
			$headline = $request->request->get('headline');
			$description = $request->request->get('description');
			$priceFrom = $request->request->get('price_from');
			$priceTo = $request->request->get('price_to');
			$productTrigger = $request->request->get('selected-product-trigger');
			$upSellProducts = $request->request->get('up-sell-products');

			$upSell = new UpSell();
			$upSell->setName($name);
			$upSell->setHeadline($headline);
			$upSell->setDescription($description);

			if ($priceFrom || $priceTo)
			{
				$upSell->setPriceFrom($priceFrom);
				$upSell->setPriceTo($priceTo);
			}

			$upSell->save();


			if (count($upSellProducts) > 0)
			{
				$config = array(
					'api_key'      =>  CONSUMER_KEY,
					'secret_key'   =>  SECRET_KEY,
					'callback_url' =>  CALLBACK_URL,
				);
				$shoploApi = new ShoploApi($config);



				foreach($upSellProducts as $productId)
				{

					$shoploProduct = $shoploApi->product->retrieve($productId)['products'];

					$product = new Product();
					$product->setName($shoploProduct['name']);
					$product->setId($shoploProduct['id']);
					$product->setImgUrl($shoploProduct['thumbnail']);

					$variants = $shoploProduct['variants'];

					$product->setOriginalPrice($variants[0]['price']);
					$product->setUrl($shoploProduct['url']);
					$product->setUpSell($upSell);
					$product->save();

					var_dump($product);


					$relatedProduct = new RelatedProduct();
					$relatedProduct->setUpSellId($upSell->getId());
					$relatedProduct->setProductId($product->getId());
					$relatedProduct->save();
				}
			}

			if (count($productTrigger) > 0)
			{
				foreach($productTrigger as $product)
				{
					$productInCart = new ProductInCart($upSell->getId(), $product);
					$productInCart->setUpSellId($upSell->getId());
					$productInCart->setProductId($product);
					$productInCart->save();
				}
			}


			exit;


			return $app['twig']->render('add.page.html.twig');
		});

		return $controllers;
	}
}