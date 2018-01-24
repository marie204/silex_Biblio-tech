<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

 if ($app['session']->get('loggin') !== null) {
	$app['global.loggin'] = $app['session']->get('loggin');
}
else{
	$app['global.loggin'] = '';
}

    return $twig;
});

$isDevMode = true;
$conn = array(
    'driver' => 'pdo_mysql',
    'user' => 'root', 
    'password' => '',
    'dbname' => 'bibliotech',
);
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/EntityManager"), $isDevMode);
$app['em'] =  EntityManager::create($conn, $config);

return $app;
