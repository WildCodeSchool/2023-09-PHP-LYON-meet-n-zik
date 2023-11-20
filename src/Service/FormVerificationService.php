<?php

namespace App\Service;

class FormVerificationService
{
    public array $errors;

    public function __construct()
    {
        $this->errors = [];
    }
    public function formVerification($user): void
    {
        if (empty($user['name'])) {
            $this->errors[] = "Vous devez renseigner votre identifiant";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $user["name"])) {
            $this->errors[] = "Votre pseudo ne peut contenir que des lettres, chiffres ou underscores";
        }

        if (empty($user["password"])) {
            $this->errors[] = "Vous devez renseigner un mot de passe";
        } elseif (strlen($user["password"]) < 8) {
            $this->errors[] = " Votre mot de passe doit avoir au moins 8 characters";
        }

        if (empty($user["confirm-password"])) {
            $this->errors[] = "Confirmez votre mot de passe s'il vous plait";
        } else {
            if (empty($this->errors) && ($user['password'] != $user["confirm-password"])) {
                $this->errors[] = "Le mot de passe ne correspond pas ";
            }
        }

        if (!filter_var($user["email"], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "L'adresse email n'est pas au bon format";
        }
    }

    public function editProfilVerfication($credentials): void
    {
        if (empty($credentials['user_name'])) {
            $this->errors[] = "Vous devez renseigner votre nom";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $credentials['user_name'])) {
            $this->errors[] = "Votre pseudo ne peut contenir que des lettres, chiffres ou underscores";
        }
        if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "L'adresse mail doit être renseignée au bon format.";
        }
        if (empty($credentials['description'])) {
            $this->errors[] = "Vous devez renseigner une descritpion.";
        } elseif (strlen($credentials['description']) < 20 || strlen($credentials['description']) > 500) {
            $this->errors[] = "Votre description doit faire entre 20 et 500 caractères.";
        }
        if (!filter_var($credentials['video'], FILTER_VALIDATE_URL)) {
            $this->errors[] = 'Le lien vidéo n\' est pas valide';
        }
    }
}
