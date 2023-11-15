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
        return $this->twig->render('User/login.html.twig');
    }
    public function userIndex(): string
    {
    /*    if ($_SESSION['user_type_id' == 2]) {
            $userManager = new UserManager();
            $users = $userManager->selectAllHost('email');
            header('Location :/meet', ['users' => $users]);
        } elseif ($_SESSION['user_type_id' == 1]) {
            $userManager = new UserManager();
            $users = $userManager->selectAllBand('email');
            header('Location :/meet', ['users' => $users]);
        }*/
        return $this->twig->render('User/meet.html.twig');
        //return $this->twig->render('HTTP/1.1 401 Unauthorized');
    }
}
