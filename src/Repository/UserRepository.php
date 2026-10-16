<?php
//classe qui réalise les requêtes SQL

namespace App\Repository;

//import des dépendances
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
                //7 Hydrater l'objet User
                $user = User::hydrate($data);
            }
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $user ?? null;
    }

    public function findByEmail(string $email): ?User
    {
        try {
            //1 Ecrire la requête
            $sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.`password` 
            FROM `user` AS u WHERE u.email = ?";
            //2 Préparer la requête
            $stmt = $this->connexion->prepare($sql);
            //3 Assigner le paramétre email
            $stmt->bindParam(1, $email, \PDO::PARAM_STR);
            //4 Exécuter la requête
            $stmt->execute();
            //5 Récupérer le resultat
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            //6 hydrater en Objet user ou null
            if ($data) {
                $user = User::hydrate($data);
            }
        } catch(\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $user ?? null;
    }
    
    //findAll
    public function findAll(): array
    {
        $users = [];
        try {
            //1 Ecrire la requête SQL
            $sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.`password` 
            FROM `user` AS u ORDER BY u.id ASC";
            //2 Préparer la requête
            $stmt = $this->connexion->prepare($sql);
            //3 Exécuter la requête
            $stmt->execute();
            //4 Récupérer le résultat
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            //5 hydrater en objet le résultat
            foreach ($data as $user) {
               $users[] = User::hydrate($user);
            }
        } catch(\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return $users;
    }
    //delete
}
