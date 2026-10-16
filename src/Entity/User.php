<?php
//Classe qui représente la structure de données

namespace App\Entity;

class User
{
    //Attributs
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;

    //constructeur
    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $password
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
    }
    //getter et setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Méthode pour hydrater un tableau en objet
     */
    public static function hydrate(array $user): User
    {
        $newUser = new User(
            $user["firstname"],
            $user["lastname"],
            $user["email"],
            $user["password"],
        );
        $newUser->setId($user["id"] ?? null);

        return $newUser;
    }
}
