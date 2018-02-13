<?php



use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;
use EntityManager\Livre; //On utilise la classe Livre qui se trouve dans le dossier EntityManager
use EntityManager\Exemplaire;
use EntityManager\Commentaire;
use EntityManager\Emprunt;
use EntityManager\Utilisateur;

$app->get('/', function () use ($app) {
    if (strpos($_SERVER['PHP_SELF'], 'index_dev.php/')||strpos($_SERVER['PHP_SELF'], 'index.php/')) {
        return $app->redirect('./accueil');
    }else{
        return $app->redirect('index.php/accueil');
    }
})
->bind('homepage');

$app->match('/ajoutLivre', function () use ($app) {
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
            if( isset($book->volumeInfo->imageLinks) ){
                $infos['image'] = str_replace('&zoom=1', '&zoom=2', $book->volumeInfo->imageLinks->thumbnail);
            }
            
            return $app['twig']->render('formulaire_isbn.html.twig', array(
                'ISBN' => $infos['isbn'],
                'titre' => $infos['titre'],
                'auteur' => $infos['auteur'],
                'langue' => $infos['langue'],
                'pages' => $infos['pages'],
                'description' => $infos['description'],
                'image' => $infos['image']
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
        $image = isset($_POST['image']) ? $_POST['image'] : '';

        $livre = new Livre();
        $livre->setTitle($title);
        $livre->setAuteur($auteur);
        $livre->setDateAjout(new \DateTime($dateAjout));
        $livre->setIsbn($isbn);
        $livre->setPages($pages);
        $livre->setLangue($langue);
        $livre->setDescription($description);
        $livre->setImage($image);

        $exemplaire = new Exemplaire();
        $exemplaire->setEtat($nbexemplaire);

        $exemplaire->setLivre($livre);

        $app['em']->persist($livre);
        $app['em']->persist($exemplaire);
        $app['em']->flush();

        return $app['twig']->render('formulaire_isbn.html.twig', array(
            'envoyer' => "Le livre ".$livre->getTitle()." à été ajouté"
        ));
    }
    return $app['twig']->render('formulaire_isbn.html.twig', array());
});

$app->get('/deconnextion', function () use ($app){
    fermetureSession($app);
    return $app->redirect('./accueil');
});
//TODO envoyerCommentaire
$app->match('/envoyerCommentaire', function () use ($app){
    if (!isset($_GET['areaCom'])||!isset($_GET['id'])||!isset($_GET['pseudoUser'])) {
        //return $app->
    }
    $com = new Commentaire();
    $com->setDate($_GET);
    $com->setUtilisateur($_GET['pseudoUser']);
    return $app->redirect('./accueil');
});

$app->get('/touslescommentaires', function() use ($app){
    if (!isset($_GET['id'])) {
        return $app['twig']->render('404.html.twig');
    }
    $repoBook = $app['em']->getRepository(Commentaire::class);
    $repoCom = $app['em']->getRepository(Commentaire::class);
    $lastComs = $repoCom->findBy(
        array('livre' => $_GET['id']),
        array('date' => 'desc')
    );
    return $app['twig']->render('touslescommentaires.html.twig', array(
        'lastComs' => $lastComs,
        'idLivre' => $_GET['id'],
    ));

});

$app->get('/about', function () use ($app){
    return $app['twig']->render('about.html.twig', array());
});

///TODO demande d'emprunt créer fonction!!!
$app->get('/demandemp', function () use ($app){
    if (!isset($_GET['dFin']) or empty($_GET['dFin']) or !isset($_GET['idLivre']) or empty($_GET['idLivre'])or !isset($_GET['dateDebut']) or empty($_GET['dateDebut'])){
        return $app->redirect('./livre?id='.$_GET['idLivre'].'&statut=erreur');
    }
    $dFin = htmlspecialchars($_GET['dFin']);
    $idLivre = htmlspecialchars($_GET['idLivre']);
    $dateDebut = htmlspecialchars($_GET['dateDebut']);
    demandemp($dFin, $idLivre, $dateDebut, $app);
    return $app->redirect('./livre?id='.$_GET['idLivre'].'&statut=envoye');
});

$app->get('/mentionlegale', function () use ($app){
    return $app['twig']->render('about.html.twig', array());
});

$app->match('/accueil', function () use ($app){
    $repository = $app['em']->getRepository(Livre::class);
    $repoCom = $app['em']->getRepository(Commentaire::class);
    $lastComs = $repoCom->findBy(
        array(),
        array('date' => 'desc'), 
        4, //limite
        0 
    );
    $popuLivre = $repository->findBy(
        array(),
        array(), 
        8, 
        0
    );
    return $app['twig']->render('accueil.html.twig', array(
        'lastComs' => $lastComs,
        'popuLivre'=> $popuLivre,
    
));
});

$app->get('/catalogue_a_z', function () use ($app){
    $repository = $app['em']->getRepository(Livre::class);
    $livres = $repository->findAll();
    return $app['twig']->render('catalogue_a_z.html.twig', array(
      'livres' => $livres
    ));
});

$app->get('/catalogue_genre', function () use ($app){
    return $app['twig']->render('catalogue_genre.html.twig', array());
});

$app->get('/recherche', function () use ($app){
    //TODO recherche par titre/auteur/...
    return $app->redirect('./ajoutLivre');
    //return $app['twig']->render('recherche.html.twig', array());
});

$app->match('/contact', function () use ($app){
    return $app['twig']->render('contact.html.twig', array());
});

$app->match('/mesemprunts', function () use ($app){
    if ($app['session']->get('user') == null) {
        return $app['twig']->render('404.html.twig', array());
    }
    $arrayEmprunt = recupAllEmprunt($app);
    return $app['twig']->render('mesemprunts.html.twig', array(
        'arrayEmprunt'=> $arrayEmprunt,
    ));
});

$app->match('/mesCommentaires', function () use ($app){
    if ($app['session']->get('user') == null) {
        return $app['twig']->render('404.html.twig', array());
    }
    $arrayAllComments = recupAllCom($app);
    return $app['twig']->render('mescommentaires.html.twig', array(
            'arrayAllComments' => $arrayAllComments ));
});

$app->get('/profil', function () use ($app){
    //TODO changer mot de passe
    if ($app['session']->get('user') == null) {
        return $app['twig']->render('404.html.twig', array());
    }
    $lastCom = recupLastCom($app);
    $lastEmprunt = recupLastEmprunt($app);
    return $app['twig']->render('profil.html.twig', array(
        'lastComId'=>$lastCom[0] ?? null,
        'lastComDate'=>$lastCom[1] ?? null,
        'lastComDescription'=>$lastCom[2] ?? null,
        'lastEmpruntId'=>$lastEmprunt[0] ?? null,
        'lastEmpruntDateDebut'=>$lastEmprunt[1] ?? null,
        'lastEmpruntDateFin'=>$lastEmprunt[2] ?? null,
        'lastEmpruntStatut'=>$lastEmprunt[3] ?? null,
        'lastEmpruntValidation'=>$lastEmprunt[4] ?? null,
        'lastEmpruntTitre' =>$lastEmprunt[5] ?? null,
        ));
});

//#loggin
$app->match('/login', function (Request $request) use ($app){
    //dump($app['session']->get('user') );
    if ( $app['session']->get('user') ) {
        return $app['twig']->render('404.html.twig', array());
    }
    return $app['twig']->render('login.html.twig', array(
        'erreur' => $_GET['erreur'] ?? null, ));
});
///log-admin
$app->match('/log-admin', function(Request $request) use ($app){
    if (!isset($_POST['login0']) || $_POST['login0'] == 'inscription' ){
        return $app['twig']->render('log.admin.html.twig', array(
        'login' => $_POST['log'] ??null,
        'mdp' => $_POST['mdp'] ??null,
        'login' => $_POST['login'] ?? null,
        'erreur' => $_GET['erreur'] ?? null,
        ));
    }else{
        if (!isset($_POST['log'])||empty($_POST['log'])) {
            return $app->redirect('./admin?erreur=noLogin');
        }
        if (!isset($_POST['mdp'])||empty($_POST['mdp']||strlen($_POST['mdp'])<8)){
            return $app->redirect('./admin?erreur=noPassa');
        }
        $verifLogA = verifLog($_POST['log']);
        if ($verifLogA == false){
            return $app->redirect('./admin?erreur=wrongLogin');
        }

        $verifLogB = compareMdp(htmlspecialchars($_POST['log']), htmlspecialchars($_POST['mdp']));
        if ($verifLogB == false){
            return $app->redirect('./admin?erreur=wrongLogin');
        }
        ouvertureSession($_POST['log'], $app);
        if ($app['session']->get('user')['statut']==1) {
            return $app->redirect('./admin'); 
        }
        return $app->redirect('./accueil'); 
    }
});

$app->match('/log-server', function(Request $request) use ($app){
    if (!isset($_POST['login0']) || $_POST['login0'] == 'inscription' ){
        return $app['twig']->render('log.server.html.twig', array(
        'login' => $_POST['log'] ??null,
        'mdp' => $_POST['mdp'] ??null,
        'login' => $_POST['login'] ?? null,
        'erreur' => $_GET['erreur'] ?? null,
        ));
    }else{
        if (!isset($_POST['log'])||empty($_POST['log'])) {
            return $app->redirect('./login?erreur=noLogin');
        }
        if (!isset($_POST['mdp'])||empty($_POST['mdp']||strlen($_POST['mdp'])<8)){
            return $app->redirect('./login?erreur=noPassa');
        }
        $verifLogA = verifLog($_POST['log']);
        if ($verifLogA == false){
            return $app->redirect('./login?erreur=wrongLogin');
        }

        $verifLogB = compareMdp(htmlspecialchars($_POST['log']), htmlspecialchars($_POST['mdp']));
        if ($verifLogB == false){
            return $app->redirect('./login?erreur=wrongLogin');
        }
        ouvertureSession($_POST['log'], $app);
        return $app->redirect('./accueil'); 
    }
});

$app->match('/inscription', function (Request $request) use ($app){
    //TODO Mot de passe oublié A l'aide d'une question
    if (!isset($_POST['mdp2']) || !isset($_POST['log2']) || empty($_POST['mdp2'])|| empty($_POST['log2']) || !isset($_POST['mailMar']) || empty($_POST['mailMar']) ){
        return $app->redirect('./log-server?erreur=mdplog');
    }
    $mdp2 = encryptMdp($_POST['mdp2']);
    $log2 = htmlspecialchars($_POST['log2']);
    $mail = htmlspecialchars($_POST['mailMar']);
    $verifMail = verifMail($mail);
    if (!$verifMail) {
        return $app->redirect('./log-server?erreur=mail');
    }
    $verifPesudoInscrit = verifBDD($log2);
    if (!$verifPesudoInscrit) {
        return $app->redirect('./log-server?erreur=name');
    }
    inscriptionBDD($log2, $mdp2, $mail);
    return $app->redirect('./accueil');
});
$app->get('/apropos', function () use ($app){
    //return '.'.$_SESSION['log'];
    return $app['twig']->render('login.html.twig', array());
});

$app->get('/nouveautes', function () use ($app){
    $repository = $app['em']->getRepository(Livre::class);
    $livres = $repository->findAll();
    return $app['twig']->render('nouveautes.html.twig', array(
      'livres' => $livres
    ));
});

$app->get('/livre', function () use ($app){
    //TODO ajouter demande d'emprunts
    //TODO ajouter le statut des livres (emprunté ou non)
    $repository = $app['em']->getRepository(Livre::class);
    $repoCom = $app['em']->getRepository(Commentaire::class);
    $repoEmp = $app['em']->getRepository(Emprunt::class);
    $repoEx = $app['em']->getRepository(Exemplaire::class);
    $lastComs = $repoCom->findBy(
        array('livre' => $_GET['id']),
        array('date' => 'desc'), 
        4, 
        0
    );
    $livre = $repository->find($_GET['id']);
    
    return $app['twig']->render('livre.html.twig', array(
      'livre' => $livre,
      'lastComs'=>$lastComs,
    ));
}); 

/*Début pour ajouter un livre*/
$app->match('/ajoutLivre', function (Request $request) use ($app){
    $li_title = $request->get('li_title');
    $li_auteur = $request->get('li_auteur');
    $li_date_ajout = $request->get('li_date_ajout');
    $li_isbn = $request->get('li_isbn');
    $li_pages = $request->get('li_pages');
    $langue = $request->get('langue');
    $li_desc = $request->get('li_desc');
    $livre = new Livre();
    $livre->setLiTitle($li_title);  //Entity / Classe Livre
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

/*DEBUT ADMINISTRATION*/
$app->get('/admin', function () use ($app){
    return $app['twig']->render('admin/accueil.html.twig', array());
});
$app->get('/listeLivres', function () use ($app){
    return $app['twig']->render('admin/listeLivres.html.twig', array());
});
$app->get('/ajoutLivre', function () use ($app){
    return $app['twig']->render('admin/ajoutLivre.html.twig', array());
});
$app->get('/ajoutGenre', function () use ($app){
    return $app['twig']->render('admin/ajoutGenre.html.twig', array());
});
$app->get('/listeEmprunts', function () use ($app){
    return $app['twig']->render('admin/listeEmprunts.html.twig', array());
});
$app->get('/ajoutEmprunts', function () use ($app){
    return $app['twig']->render('admin/ajoutEmprunt.html.twig', array());
});
/*FIN ADMINISTRATION*/
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

    function inscriptionBDD($log, $mdp, $mail){ 
        $log = htmlspecialchars($log);
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "INSERT INTO `utilisateur` (`pseudo`, `password`, `statut_id`, `email`) VALUES
(:user_pseudo, :user_mdp, 2, :mail);");
    $req->execute(array('user_pseudo'=>$log,
                        'user_mdp'=>$mdp,
                        'mail'=>$mail));
    $req->closeCursor();
    return 'done';
}

//fonction
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
            //dump($log2[0]['i']);
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
    function verifMail($mail){
        if (!strpos($mail, '@')){
            return false;
        }
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "SELECT email  FROM utilisateur WHERE utilisateur.email = :email;");
        $req->execute(array('email'=>$mail,));
        $result = $req->fetchAll();
        if ($result == null){
            $req->closeCursor();
            return true;
        }
        $req->closeCursor();
        return false;
    }
    function fermetureSession($app){
        $app['session']->clear();
    }

    function recupLastCom($app){
        $a = $app['session']->get('user')['login'];
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "SELECT commentaire.id, commentaire.date, description FROM commentaire, utilisateur WHERE commentaire.utilisateur_id = utilisateur.id AND pseudo = :pseudo ORDER BY commentaire.id DESC LIMIT 0,1");
        $req->execute(array('pseudo'=>$a,));
        $lastCom = $req->fetchAll();
        if (!isset($lastCom[0]['id'])) {
            return false;
        }
        $lastCom = [$lastCom[0]['id'], $lastCom[0]['date'], $lastCom[0]['description']];
        return $lastCom;
    }
    function recupAllCom($app){
        $a = $app['session']->get('user')['login'];
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "SELECT commentaire.id, commentaire.date, commentaire.description, livre.titre FROM commentaire, utilisateur, livre WHERE commentaire.utilisateur_id = utilisateur.id AND livre.id = commentaire.livre_id AND pseudo = :pseudo ORDER BY commentaire.id DESC");
        $req->execute(array('pseudo'=>$a,));
        $allC = $req->fetchAll();
        $allCom = [];
        for ($i=0; $i < count($allC) ; $i++) { 
            $allCom[$i][0] = $allC[$i]["id"];
            $allCom[$i][1] = $allC[$i]["date"];
            $allCom[$i][2] = $allC[$i]["description"];
            $allCom[$i][3] = $allC[$i]["titre"];
        };
        return $allCom;
    }

    function recupAllEmprunt($app){
        $a = $app['session']->get('user')['login'];
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "SELECT emprunt.id, emprunt.dateDebut, emprunt.dateFin, emprunt.statut, emprunt.valider, livre.titre FROM emprunt, utilisateur, livre, exemplaire WHERE emprunt.utilisateur_id = utilisateur.id AND pseudo = :pseudo AND exemplaire.id = emprunt.exemplaire_id AND exemplaire.livre_id = livre.id ORDER BY emprunt.id");
        $req->execute(array('pseudo'=>$a,));
        $allE = $req->fetchAll();
        for ($i=0; $i < count($allE) ; $i++) { 
            $allEmp[$i][0] = $allE[$i]["id"];
            $allEmp[$i][1] = $allE[$i]["dateDebut"];
            $allEmp[$i][2] = $allE[$i]["dateFin"];
            $allEmp[$i][3] = $allE[$i]["statut"];
            $allEmp[$i][4] = $allE[$i]["valider"];
            $allEmp[$i][5] = $allE[$i]["titre"];
        };
        //$allEmp = [$lastEmprunt[0]['id'], $lastEmprunt[0]['dateDebut'], $lastEmprunt[0]['dateFin'], $lastEmprunt[0]['statut'], $lastEmprunt[0]['valider'], $lastEmprunt[0]['titre']];
        //dump($lastEmprunt);
        return $allEmp;
    }


    function recupLastEmprunt($app){
        $a = $app['session']->get('user')['login'];
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "SELECT emprunt.id, emprunt.dateDebut, emprunt.dateFin, emprunt.statut, emprunt.valider, livre.titre FROM emprunt, utilisateur, livre, exemplaire WHERE emprunt.utilisateur_id = utilisateur.id AND pseudo = :pseudo AND exemplaire.id = emprunt.exemplaire_id AND exemplaire.livre_id = livre.id ORDER BY emprunt.id DESC LIMIT 0,1");
        $req->execute(array('pseudo'=>$a,));
        $lastEmprunt = $req->fetchAll();
        if (!isset($lastEmprunt[0])||empty($lastEmprunt[0])) {
            return false;
        }
        $lastEmprunt = [$lastEmprunt[0]['id'], $lastEmprunt[0]['dateDebut'], $lastEmprunt[0]['dateFin'], $lastEmprunt[0]['statut'], $lastEmprunt[0]['valider'], $lastEmprunt[0]['titre']];
        //dump($lastEmprunt);
        return $lastEmprunt;
    }

    function ouvertureSession($log, $app){
        $log = htmlspecialchars($log);
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare(
        "SELECT statut_id FROM utilisateur WHERE pseudo = :pseudo ");
        $req->execute(array('pseudo'=>$log,));
        $log2 = $req->fetchAll();
        $statut = $log2[0]['statut_id'];
        $app['session']->set('user', array('login' => $log, 
                                           'statut' => $statut, 
                                            ));
    }

    function demandemp($dFin, $idLivre, $dateDebut, $app){
        //var_dump($idLivre);
        $log = $app['session']->get('user')['login'];
        $bdd = new PDO('mysql:host=localhost;dbname=bibliotech;charset=utf8',"root",'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $req = $bdd->prepare('SELECT id FROM utilisateur WHERE pseudo = :pseudo');
        $req->execute(array('pseudo'=>$log,));
        $log2 = $req->fetchAll();
        $userId = $log2[0]['id'];
        $req->closeCursor();
        $req= $bdd->prepare('SELECT * FROM exemplaire WHERE exemplaire.livre_id = :idLivre ');
        $req->execute(array('idLivre'=>$idLivre,));
        $log3 = $req->fetchAll();
        $req->closeCursor();
        $idExemplaire = $log3[0]['id'];
        var_dump($idExemplaire);
        $req = $bdd->prepare("INSERT INTO `emprunt` (`id`, `utilisateur_id`, `exemplaire_id`, `dateDebut`, `dateFin`, `statut`, `valider`) VALUES (NULL, :userId, :idExemplaire, :dDebut, :dFin, 'Demande', 'En cours');");
        $req->execute(array(
            'userId'=>$userId,
            'idExemplaire'=>$idExemplaire,
            'dDebut'=> $dateDebut,
            'dFin'=>$dFin,

        ));


    }
