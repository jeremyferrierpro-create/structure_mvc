<?php
include '../vendor/autoload.php';

//récupération de l'URL (composante)
$url = parse_url($_SERVER["REQUEST_URI"]);

//extraction du path
$path = isset($url["path"]) ? $url["path"] : "/";

//importer
use App\Controller\HomeController;
use App\Controller\ExerciceController;

//instancier les controllers
$homeController = new HomeController();
$exerciceController = new ExerciceController();

//importer les variables d'environnement 
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

//dd($_ENV);

//test des valeurs du path
switch ($path) {
    case '/':
        $homeController->accueil();
        break;
    case '/login':
        echo  "Se connecter";
        break;
    case '/register':
        echo  "S'inscire";
        break;
    case '/profil':
        echo "Profil user";
        break;
    case '/ex1':
        $exerciceController->hello();
        break;
    case '/ex3':
        $exerciceController->gestion();
        break;
    default:
        echo "Erreur 404";
        break;
}
