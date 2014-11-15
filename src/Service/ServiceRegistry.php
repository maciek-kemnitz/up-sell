<?php

namespace src\Service;

use Shoplo\ShoploApi;
use Silex\Application;
use src\Lib\GateKeeper;
use src\Lib\ShoploObject;
use src\Lib\Stats;

class ServiceRegistry
{
	const SERVICE_SHOPLO 		= 'shoplo';
	const SERVICE_SHOPLO_OBJECT = 'shoplo_object';
	const SERVICE_GATEKEEPER 	= 'gatekeeper';
	const SERVICE_STATS	        = 'stats';

	/** @var Application  */
	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function init()
	{
		$this->app[self::SERVICE_SHOPLO] = $this->app->share(function ($app)
		{

			$config = array(
				'api_key'      =>  CONSUMER_KEY,
				'secret_key'   =>  SECRET_KEY,
				'callback_url' =>  CALLBACK_URL,
			);

			return new ShoploApi($config);
		});

		$this->app[self::SERVICE_SHOPLO_OBJECT] = $this->app->share(function ($app)
		{

			$config = array(
				'api_key'      =>  CONSUMER_KEY,
				'secret_key'   =>  SECRET_KEY,
				'callback_url' =>  CALLBACK_URL,
			);

			$api = new ShoploApi($config);

			return new ShoploObject($api);
		});

		$this->app[self::SERVICE_GATEKEEPER] = $this->app->share(function ($app)
		{
			$gateKeeper = new GateKeeper($app[self::SERVICE_SHOPLO_OBJECT]);

			return $gateKeeper;
		});

		$this->app[self::SERVICE_STATS] = $this->app->share(function ($app)
		{
			$stats = new Stats($app[self::SERVICE_SHOPLO_OBJECT]);

			return $stats;
		});
	}


}