<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\UserManager;
use App\Service\FormVerificationService;

class UserController extends AbstractController
{
    public function registration(): ?string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trimUser = array_map('trim', $_POST);
            $user = array_map('htmlentities', $trimUser);

            $formVerification = new formVerificationService();
            $formVerification->formVerification($user);
            $errors = $formVerification->errors;
            if (empty($errors)) {
                $userManager = new UserManager();
                $userManager->insert($user);
                header('Location:/login');
            }
        }
        return $this->twig->render('signup.html.twig', ['errors' => $errors]);
    }

    public function login()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataTrimed = array_map('trim', $_POST);
            $credentials = array_map('htmlentities', $dataTrimed);

            if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "L'adresse mail doit être renseignée au bon format.";
                $errors[] = $error;
            }
            $userManager = new UserManager();

            $user = $userManager->selectOneByEmail($credentials['email']);

            if ($user && password_verify($credentials['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location:/');
                exit();
            } else {
                $error = "L'adresse e-mail ou le mot de passe est incotrect.";
                $errors[] = $error;
                return $this->twig->render('login.html.twig', ['errors' => $errors]);
            }
        }
        return $this->twig->render('login.html.twig');
    }
}
