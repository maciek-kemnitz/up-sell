<?php

namespace src\Controller;

use Shoplo\ShoploApi;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CallbackController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->get('/', function (Request $request) use ($app)
		{
			$config = array(
				'api_key'      =>  CONSUMER_KEY,
				'secret_key'   =>  SECRET_KEY,
				'callback_url' =>  CALLBACK_URL,
			);
			$shoploApi = new ShoploApi($config);

			if ($shoploApi->authorized)
			{
				return new RedirectResponse('/');
			}
//			return $app['twig']->render('login.page.html.twig', ['product'=>$shoploApi->product->retrieve()]);
		});

		return $controllers;
	}
}