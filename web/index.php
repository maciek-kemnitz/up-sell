<?php

require_once __DIR__.'/../vendor/autoload.php';

//require_once '/vendor/propel/propel1/runtime/lib/Propel.php';

// Initialize Propel with the runtime configuration
Propel::init(__DIR__."/../src/Model/conf/up-sell-conf.php");




$app = getAppConfigured();
define('SECRET_KEY','9WWoEfq0QznTi39gw14LlvckQAJzOVi5');
define('CONSUMER_KEY', '2UHQfM0wKTFvsXK3w2c8REqc26XPy75J');
define('CALLBACK_URL', 'http://local.up-sell.pl/callback');

session_start();

//$app->mount('/ajax', new \Src\Main\Controller\AjaxController());
//$app->mount('/archive', new \Src\Main\Controller\ArchiveController());
//$app->mount('/conversation', new \Src\Main\Controller\ConversationController());
$app->mount('/', new \src\Controller\LoginController());
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
