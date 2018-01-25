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

 if (null !== $app['session']->get('user')) {
	$app['global.loggin'] = $app['session']->get('user')['login'];
	if ($app['session']->get('user')['statut'] == 1) {
		$app['global.myStatut'] = 'Admin';
	}else{
		$app['global.myStatut'] = 'Membre';
	}
	
}
else{
	$app['global.loggin'] = '';
	$app['global.myStatut']= 'invite';
}
	$twig->addGlobal('loggin', $app['global.loggin']);
	$twig->addGlobal('myStatut', $app['global.myStatut']);
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
