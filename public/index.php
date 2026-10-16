<?php
include '../vendor/autoload.php';

//récupération de l'URL (composante)
$url = parse_url($_SERVER["REQUEST_URI"]);

//extraction du path
$path = isset($url["path"]) ? $url["path"] : "/";

//importer
use App\Controller\HomeController;
use App\Controller\UserController;

//instancier les controllers
$homeController = new HomeController();
$userController = new UserController();

//importer les variables d'environnement 
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

<<<<<<< HEAD
//dd($_ENV);

=======
>>>>>>> 97710f52a4521cac5ae16d5d6a35ff839da16354
//test des valeurs du path
switch ($path) {
    case '/':
        $homeController->accueil();
        break;
    case '/register':
        $userController->register();
        break;
    case '/profil':
        echo "Profil user";
        break;
    case '/login':
        echo  "Se connecter";
        break;
    default:
        echo "Erreur 404";
        break;
}
