<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\UserManager;
use App\Service\FormVerificationService;
use App\Service\LoginFormVerificationService;

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
            $trimUser = array_map('trim', $_POST);
            $user = array_map('htmlentities', $trimUser);

            $loginVerification = new LoginFormVerificationService();
            $loginVerification->loginFormVerification($user);
            $errors = $loginVerification->errors;

            if (empty($errors)) {
                $userManager = new UserManager();
                $userData = $userManager->selectOneByEmail($user['email']);
                if ($userData && password_verify($user['password'], $userData['password'])) {
                    $_SESSION['user_id'] = $userData['id'];
                } else {
                    $errors[] = "L'adresse mail ou le mot de passes sont incorrects";
                }
                header('Location:/');
                exit();
            }
        }
        return $this->twig->render('login.html.twig', ['errors' => $errors]);
    }
}
