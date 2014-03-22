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
//			oauth_consumer_key=2UHQfM0wKTFvsXK3w2c8REqc26XPy75J&oauth_consumer_secret=9WWoEfq0QznTi39gw14LlvckQAJzOVi5
//			$oauth = new \OAuth('2UHQfM0wKTFvsXK3w2c8REqc26XPy75J','9WWoEfq0QznTi39gw14LlvckQAJzOVi5', OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
//			$requestTokenInfo = $oauth->getRequestToken("http://api.shoplo.com/services/oauth/request_token");
//
//
//			return new RedirectResponse('http://api.shoplo.com/services/oauth/authorize?oauth_token='.$requestTokenInfo['oauth_token'].'&oauth_callback='.'local.up-sell.pl/callback');
//			return $app['twig']->render('login.page.html.twig');

			$config = array(
				'api_key'      =>  CONSUMER_KEY,
				'secret_key'   =>  SECRET_KEY,
				'callback_url' =>  CALLBACK_URL,
			);
			$shoploApi = new ShoploApi($config);


			return $app['twig']->render('login.page.html.twig', ['product'=>$shoploApi->product->retrieve()]);
		});

		return $controllers;
	}
}