<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/Config/config.php';


Propel::init(__DIR__."/../src/Model/conf/up-sell-conf.php");

$app = getAppConfigured();

session_start();

$app->mount('/', new \src\Controller\HomePageController());
$app->mount('/callback', new \src\Controller\CallbackController());
$app->mount('/add', new \src\Controller\AddController());
$app->mount('/save', new \src\Controller\SaveController());
$app->mount('/ajax', new \src\Controller\AjaxController());
//$app->mount('/my-tickets', new \Src\Main\Controller\MyTicketsController());
//$app->mount('/all-tickets', new \Src\Main\Controller\AllTicketsController());
//$app->mount('/update-users', new \Src\Main\Controller\UpdateUsersController());



$app->run();


/**
 * @return Silex\Application
 */
function getAppConfigured()
{
	$app = new Silex\Application();

	$app['debug'] = true;

	$app->register(new Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__.'/../src/Resources/View',
	));

	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

//	$app['swiftmailer.options'] = array(
//		'host' => 'ssl://smtp.gmail.com',
//		'port' => '465',
//		'username' => SWIFT_MAILER_USERNAME,
//		'password' => SWIFT_MAILER_PASSWORD,
//		'encryption' => null,
//		'auth_mode' => null
//	);

//	$app->register(new Silex\Provider\SwiftmailerServiceProvider());

	$app->register(new \FF\ServiceProvider\LessServiceProvider(), array(
		'less.sources'     => array(__DIR__.'/../src/Resources/less/styles.less'),
		'less.target'      => __DIR__.'/../web/css/styles.css',
		'less.target_mode' => 0775,));


//	$app->register(new Propel\Silex\PropelServiceProvider(), array(
//		'propel.config_file' => __DIR__.'/../src/Config/propel-conf.php',
//		'propel.model_path' => __DIR__.'/../src/Model',
//	));
	return $app;
}
