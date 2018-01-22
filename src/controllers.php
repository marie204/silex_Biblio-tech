<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use EntityManager\Livre; //On utilise la classe Livre qui se trouve dans le dossier EntityManager
use EntityManager\Exemplaire;

$app->get('/', function () use ($app) {
    return $app['twig']->render('accueil.html.twig', array());
})
->bind('homepage')
;

$app->match('/test', function () use ($app) {
    if (isset($_POST['rechercher'])) {
         $rechercheisbn = isset($_POST['rechercheisbn']) ? $_POST['rechercheisbn'] : '';

         $request = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $rechercheisbn;
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
                'ISBN' => $infos['isbn'],
                'titre' => $infos['titre'],
                'auteur' => $infos['auteur'],
                'langue' => $infos['langue'],
                'pages' => $infos['pages'],
                'description' => $infos['description']
            ));
        }
        else {
            return $app['twig']->render('formulaire_isbn.html.twig', array(
              'echec' => "Livre introuvable"
            ));
        }
    }
    
    if (isset($_POST['envoyer'])) {
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $auteur = isset($_POST['auteur']) ? $_POST['auteur'] : '';
        $dateAjout = isset($_POST['dateAjout']) ? $_POST['dateAjout'] : '';
        $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
        $pages = isset($_POST['pages']) ? $_POST['pages'] : '';
        $langue = isset($_POST['langue']) ? $_POST['langue'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $nbexemplaire = isset($_POST['exemplaire']) ? $_POST['exemplaire'] : '';

        $livre = new Livre();
        $livre->setTitle($title);
        $livre->setAuteur($auteur);
        $livre->setDateAjout(new \DateTime($dateAjout));
        $livre->setIsbn($isbn);
        $livre->setPages($pages);
        $livre->setLangue($langue);
        $livre->setDescription($description);
        $livre->setImage('');

        $exemplaire = new Exemplaire();
        $exemplaire->setEtat($nbexemplaire);

        $app['em']->persist($livre);
        $app['em']->persist($exemplaire);
        $app['em']->flush();

        return $app['twig']->render('formulaire_isbn.html.twig', array(
            'envoyer' => "Le livre ".$livre->getTitle()." à été ajouté"
        ));
    }
    else {
        return $app['twig']->render('formulaire_isbn.html.twig', array(
            'echec2' => "Le livre n'a pas été ajouté"
        ));
    }
    return $app['twig']->render('formulaire_isbn.html.twig', array());
});

$app->get('/about', function () use ($app){
    return 'ok';
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
    //return $app['twig']->render('contact.html.twig', array());
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

$app->get('/livre', function () use ($app){
    return $app['twig']->render('livre.html.twig', array());
}); 

/*Début pour ajouter un livre*/
$app->get('/ajoutLivre', function (Request $request) use ($app){
    $li_title = $request->get('li_title');
    $li_auteur = $request->get('li_auteur');
    $li_date_ajout = $request->get('li_date_ajout');
    $li_isbn = $request->get('li_isbn');
    $li_pages = $request->get('li_pages');
    $langue = $request->get('langue');
    $li_desc = $request->get('li_desc');

    $livre = new Livre();
    $livre->setLiTitle($li_title);//Entity / Classe Livre
    $livre->setLiAuteur($li_auteur);
    $livre->setLiDesc($li_date_ajout);
    $livre->setLiIsbn($li_isbn);
    $livre->setLiPages($li_pages);
    $livre->setLangue($langue);
    $livre->setLiDesc($li_desc);
    /*$em = $app['orm.em'];*/
    $em->persist($Livre);
    $em->flush();
    echo "Created livre with ID " . $livre->getId() . "\n";

    return $app['twig']->render('ajoutLivre.html.twig', array());
});
/*Fin pour ajouter un livre*/

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

installStatut();
//#loggin
    function verifLog($log){
        $log = htmlspecialchars($log);
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $req = $bdd->prepare(
    "SELECT pseudo  FROM utilisateur WHERE utilisateur.pseudo = :log;");
    $req->execute(array('log'=>$log,));
    $result = $req->fetchAll();
    if ($result == null){
        $req->closeCursor();
        return false;
    }
    $req->closeCursor();
    return true;
    };

    function inscriptionBDD($log, $mdp){ 
        $log = htmlspecialchars($log);
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "INSERT INTO `utilisateur` (`pseudo`, `password`, `statut_id`) VALUES
(:user_pseudo, :user_mdp, 2);");
    $req->execute(array('user_pseudo'=>$log,
                        'user_mdp'=>$mdp,));
    $req->closeCursor();
    return 'done';
}

    function compareMdp($log, $mdp){
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "SELECT password FROM utilisateur WHERE pseudo = :pseudo ");
        $req->execute(array('pseudo'=>$log,));
        $mdp2 = $req->fetchAll();

        $hash = $mdp2[0]["password"];
        
        $mdpCompare = password_verify($mdp, $hash);
        $req->closeCursor();
        return $mdpCompare;
    };

    function encryptMdp($mdp){
        $passHachay = password_hash($mdp, PASSWORD_DEFAULT);
        return $passHachay;
    };

    function verifBDD($log){

        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "SELECT pseudo FROM utilisateur WHERE pseudo = :pseudo ");
        $req->execute(array('pseudo'=>$log,));
        $log2 = $req->fetchAll();
        if (count($log2) == 0) {
            $req->closeCursor();
            return true;
        }else{
            $req->closeCursor();
            return false;
        }
    }
    function installStatut(){
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "SELECT count(id) i FROM statut");
        $req->execute();
        $log2 = $req->fetchAll();
        if ($log2[0]['i'] == 0) {
            dump($log2[0]['i']);
            $req->closeCursor();
            for ($i=0; $i < 2 ; $i++) {
                $stature = 'membre';
                if ($i == 0) {
                    $stature = 'admin';
                }
                $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $req = $bdd->prepare(
                    "INSERT INTO `statut` (`intitule`) VALUES
                (:stature);");
                $req->execute(array(
                        'stature'=>$stature,));
                $req->closeCursor();
            };
        }
    }