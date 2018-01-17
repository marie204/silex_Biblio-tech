<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app->get('/', function () use ($app) {
    return $app['twig']->render('accueil.html.twig', array());
})
->bind('homepage')
;

$app->get('/test', function () use ($app) {
    if (isset($_GET['rechercher'])) {
         $isbn = isset($_GET['isbn']) ? $_GET['isbn'] : '';

         $request = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn;
         $response = file_get_contents($request);
         $results = json_decode($response);

        if ($results->totalItems > 0) {
            $book = $results->items[0];
            $infos['isbn'] = $book->volumeInfo->industryIdentifiers[0]->identifier;
            $infos['titre'] = $book->volumeInfo->title;
            $infos['auteur'] = $book->volumeInfo->authors[0];
            $infos['langue'] = $book->volumeInfo->language;
            $infos['pages'] = $book->volumeInfo->pageCount;
            $infos['description'] = $book->volumeInfo->description;
            
            return $app['twig']->render('formulaire_isbn.html.twig', array(
                'ISBN' => "Numéro ISBN : ". $infos['isbn'],
                'titre' => "Titre : ". $infos['titre'],
                'auteur' => "Auteur : ". $infos['auteur'],
                'langue' => "Langue : ". $infos['langue'],
                'pages' => "Pages : ". $infos['pages'],
                'description' => "Description : ". $infos['description']
            ));
        }
        else {
        return $app['twig']->render('formulaire_isbn.html.twig', array(
          'echec' => "Livre introuvable"
        ));
        }
    }
    return $app['twig']->render('formulaire_isbn.html.twig', array());
});

$app->get('/about', function () use ($app){
    return 'ok2';
});

$app->get('/accueil', function () use ($app){
    return $app['twig']->render('accueil.html.twig', array());
});

$app->get('/catalogue_a_z', function () use ($app){
    return $app['twig']->render('catalogue_a_z.html.twig', array());
});

$app->get('/catalogue_genre', function () use ($app){
    return $app['twig']->render('catalogue_genre.html.twig', array());
});

$app->get('/recherche', function () use ($app){
    return $app['twig']->render('recherche.html.twig', array());
});

$app->get('/contact', function () use ($app){
    return $app['twig']->render('contact.html.twig', array());
});

$app->get('/login', function () use ($app){
    return $app['twig']->render('login.html.twig', array());
});
$app->get('/apropos', function () use ($app){
    return $app['twig']->render('login.html.twig', array());
});

$app->get('/nouveautes', function () use ($app){
    return $app['twig']->render('nouveautes.html.twig', array());
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
