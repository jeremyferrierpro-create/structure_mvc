<?php

namespace App\Repository;

use App\Database\Mysql;
use App\Entity\User;

class UserRepository
{
    private \PDO $connexion;

    //injection de dépendance
    public function __construct()
    {
        $this->connexion = Mysql::connectBdd();
    }

    //create
    public function create(User $user): ?User
    {
        try {
            //1 Ecrire la requête SQL
            $sql = "INSERT INTO `user`(firstname, lastname, email, `password`) VALUE(?,?,?,?)";
            //2 Préparation de la requête
            $stmt = $this->connexion->prepare($sql);
            //3 Assigner les paramètres
            $stmt->bindValue(1, $user->getFirstname(), \PDO::PARAM_STR);
            $stmt->bindValue(2, $user->getLastname(), \PDO::PARAM_STR);
            $stmt->bindValue(3, $user->getEmail(), \PDO::PARAM_STR);
            $stmt->bindValue(4, $user->getPassword(), \PDO::PARAM_STR);
            //4 Exécuter la requête
            $stmt->execute();
            //5 Récupérer l'id
            $id = $this->connexion->lastInsertId();
            //6 setter l'id au User
            $user->setId($id);
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $user;
    }

    //update
    //find
    public function find(int $id): ?User
    {
        try {
            //1 Ecrire la requête
            $sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.`password `
            FROM `user` AS u WHERE u.id = ?";
            //2 Préparer la requête
            $stmt = $this->connexion->prepare($sql);
            //3 Assigner le paramètre
            $stmt->bindValue(1, $id, \PDO::PARAM_INT);
            //4 Exécuter la requête
            $stmt->execute();
            //5 Fetch le résultat
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            //6 tester si le user existe
            if ($data) {
                //6 Hydrater l'objet User
                $user = User::hydrate($data);
            }
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $user ?? null;
    }

    // findByEmail
    public function findByEmail(string $email): ?User
    {
        try {
            // 1. Écrire la requête SQL
            $sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.`password` 
                    FROM `user` AS u WHERE u.email = ?";
            
            // 2. Préparer la requête
            $stmt = $this->connexion->prepare($sql);
            
            // 3. Assigner l'email (paramètre string)
            $stmt->bindValue(1, $email, \PDO::PARAM_STR);
            
            // 4. Exécuter la requête
            $stmt->execute();
            
            // 5. Fetch un tableau associatif
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // 6. Vérifier si un utilisateur a été trouvé et l'hydrater en objet User
            if ($data) {
                return User::hydrate($data);
            }
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // 7. Retourner null si l'utilisateur n'existe pas
        return null;
    }
    // findAll
    public function findAll(): array
    {
        // Initialisation d'un tableau vide qui contiendra nos objets User
        $users = [];

        try {
            // 1. Écrire la requête SQL pour récupérer tous les utilisateurs
            $sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.`password` 
                    FROM `user` AS u";

            // 2. Préparer la requête
            $stmt = $this->connexion->prepare($sql);

            // 3. Exécuter la requête
            $stmt->execute();

            // 4. FetchAll un tableau indexé de tableaux associatifs
            $datas =$stmt->fetchAll(\PDO::FETCH_ASSOC);

            // 5. Parcourir les résultats et hydrater chaque sous-tableau en objet User
            if ($datas) {
                foreach ($datas as $user) {
                    $users[] = User::hydrate($user);
                }
            }
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // 6. Retourner un tableau vide ou le tableau rempli d'objets User
        return $users;
    }
    //delete
}
