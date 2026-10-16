<?php
//classe qui représente la logique métier (Algo)
namespace App\Service;

//Imports des dépendances
use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\Tools;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function addUser(): string 
    {
        //tester si les champs sont remplis
        if (
            empty($_POST["firstname"]) ||
            empty($_POST["lastname"]) ||
            empty($_POST["email"]) ||
            empty($_POST["password"]) ||
            empty($_POST["confirm-password"]) 
        ) {
            return "Veuillez remplir tous les champs";
        }
        //nettoyer les données
        Tools::sanitizeArray($_POST);
        
        //vérifier si les 2 mots de passe sont identiques
        if ($_POST["password"] != $_POST["confirm-password"]) {
            return "Les 2 mots de passe ne sont pas identiques";
        }

        //Récupération du compte
        $user =  $this->userRepository->findByEmail($_POST["email"]);
        
        //vérifier si le compte existe déja
        if ($user) {
            return "Le compte existe déja";
        }
        
        //hasher le mot de passe
        $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        
        //hydater en objet la super globale POST
        $newUser = User::hydrate($_POST);
        
        //Setter le hash à l'objet User
        $newUser->setPassword($hash);
        
        //ajouter en BDD le compte User
        $userBDD = $this->userRepository->create($newUser);
        
        //Message de confirmation
        return "Le compte " . $_POST["email"] . " a été ajouté en BDD";
    }
}
