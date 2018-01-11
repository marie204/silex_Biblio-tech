<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

$app->get('/about', function () use ($app){
    return 'ok';
});

$app->get('/accueil', function () use ($app){
    return 'ok2';
});

$app->get('/catalogue_de_a_a_z', function () use ($app){
    return 'ok3';
});

$app->get('/catalogue_par_genre', function () use ($app){
    return 'ok4';
});

$app->get('/contact', function () use ($app){
    return 'ok5';
});

$app->get('/login', function () use ($app){
    return 'ok6';
});

$app->get('/nouveautes', function () use ($app){
    return 'ok7';
});

$app->get('/admin', function () use ($app){
    return 'ok8';
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
