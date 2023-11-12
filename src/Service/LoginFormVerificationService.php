<?php

namespace App\Service;

class LoginFormVerificationService
{
    public array $errors;

    public function __construct()
    {
        $this->errors = [];
    }
    public function loginFormVerification($user): void
    {
        if (empty($user['username']) || !filter_var($user['username'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "L'adresse mail doit être renseignée dans un format approprié";
        }
        if (empty($user['password'])) {
            $this->errors[] = "Vous devez renseigner un mot de passe";
        } elseif (strlen($user['password']) < 8) {
            $this->errors[] = "Votre mot de passe doit avoir au moins 8 caractères";
        }
    }
}
