<?php

namespace src\Service;

use Shoplo\ShoploApi;
use Silex\Application;

class ServiceRegistry
{
	const SERVICE_SHOPLO = 'shoplo';

	/** @var Application  */
	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function init()
	{
		$this->app[self::SERVICE_SHOPLO] = $this->app->share(function ($app) {

			$config = array(
				'api_key'      =>  CONSUMER_KEY,
				'secret_key'   =>  SECRET_KEY,
				'callback_url' =>  CALLBACK_URL,
			);

			return new ShoploApi($config);
		});
	}


}