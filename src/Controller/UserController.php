<?php
//classe qui représente les entrées et sorties GET et POST
namespace App\Controller;

//Import des dépendances
use App\Service\UserService;

class UserController
{
    private UserService $userService;

    public function __construct() 
    {
        $this->userService = new UserService();
    }

    public function register(): mixed
    {

        //Test si le formulaire est soumis
        if (isset($_POST["submit"])) {
            //Appel de la logique de création du compte
            $data["msg"] = $this->userService->addUser();
        }

        //Affichage du template
        return $this->render('register', 'Inscription', $data ?? []);
    }

    private function render(string $template, ?string $title, array $data = []): mixed
    {
        return include __DIR__ . "/../../template/template_" . $template . ".php";
    }
}
