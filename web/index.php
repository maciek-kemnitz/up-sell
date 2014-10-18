<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/Config/config.php';

mb_internal_encoding("UTF-8");
Propel::init(__DIR__."/../src/Model/conf/up-sell-conf.php");

$app = getAppConfigured();

session_start();

$app->mount('/', new \src\Controller\HomePageController());
$app->mount('/info', new \src\Controller\InfoController());
$app->mount('/callback', new \src\Controller\CallbackController());
$app->mount('/add', new \src\Controller\AddController());
$app->mount('/edit', new \src\Controller\EditController());
$app->mount('/save', new \src\Controller\SaveController());
$app->mount('/ajax', new \src\Controller\AjaxController());
$app->mount('/delete', new \src\Controller\DeleteController());
$app->mount('/status', new \src\Controller\UpSellStatusController());


$app->run();


/**
 * @return Silex\Application
 */
function getAppConfigured()
{
	$app = new Silex\Application();

	$app['debug'] = DEBUG;

	$app->register(new Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__.'/../src/Resources/View',
	));

	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

	$app->register(new Silex\Provider\SwiftmailerServiceProvider());

	$app['swiftmailer.options'] = array(
		'host' => 'smtp.gmail.com',
		'port' => '465',
		'username' => SWIFT_MAILER_USERNAME,
		'password' => SWIFT_MAILER_PASSWORD,
		'encryption' => 'ssl',
		'auth_mode' => 'login'
	);

	$app->register(new \FF\ServiceProvider\LessServiceProvider(), array(
		'less.sources'     => array( __DIR__.'/../src/Resources/less/styles.less'),
		'less.target'      => __DIR__.'/../web/css/styles.css',
		'less.target_mode' => 0775,));

	$serviceRegistry = new \src\Service\ServiceRegistry($app);
	$serviceRegistry->init();

	$app->error(function (\Exception $e, $code) use ($app)
	{
		if ($app['debug'])
		{
			return;
		}

		$iDontCare = [
			'GET /render/hoteldiv.jsp',
			'GET /clientaccesspolicy.xml',
			'GET /w00tw00t.at.blackhats.romanian.anti-sec:)',
			'GET /manager/htm',
			'GET /ajax/up-sell/product',
		];
		foreach ($iDontCare as $phrase)
		{
			if (stripos($e->getMessage(), $phrase) !== false)
			{
				return new \Symfony\Component\HttpFoundation\Response('Page not found!');
			}
		}

		$server = '';
		$body = '';
		foreach ($_SERVER as $key => $item)
		{
			$server .= "-- " .$key. "--\n";
			$server .= "\n";
			$server .= $item;
			$server .= "\n";

		}

		$body .= $e->getMessage() . "\n";
		$body .= $e->getTraceAsString() . "\n\n";
		$body .= "Request: \n" . $server. "\n\n";
		$message = \Swift_Message::newInstance()
			->setSubject('[up-sell.com] Error: '.$e->getMessage())
			->setFrom(array('noreply@yoursite.com'))
			->setTo(array('maciek.kemnitz@gmail.com'))
			->setBody($body);

		$app['mailer']->send($message);

		$app['swiftmailer.spooltransport']
			->getSpool()
			->flushQueue($app['swiftmailer.transport']);

		switch ($code)
		{
			case 403:
				return new \Symfony\Component\HttpFoundation\Response('Access Denied!');
			case 404:
				$shoploApi 	= $app[\src\Service\ServiceRegistry::SERVICE_SHOPLO_OBJECT];
				$shop 		= $shoploApi->getShop();
				return new \Symfony\Component\HttpFoundation\Response($app['twig']->render('404.page.html.twig',['shop'=> $shop]));

		}
		return new \Symfony\Component\HttpFoundation\Response('Ups, something went very wrong.');
	});

	return $app;
}