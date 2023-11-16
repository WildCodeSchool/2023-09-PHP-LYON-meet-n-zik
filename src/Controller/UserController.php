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
        if (isset($_SESSION['user_id'])) {
            header('Location:/');
            exit();
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataTrimed = array_map('trim', $_POST);
            $credentials = array_map('htmlentities', $dataTrimed);

            if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "L'adresse mail doit être renseignée au bon format.";
                $errors[] = $error;
            }
            if (empty($credentials['password'])) {
                $error = "Vous devez renseigner un mot de passe";
                $errors[] = $error;
            }
            if (empty($errors)) {
                $userManager = new UserManager();

                $user = $userManager->selectOneByEmail($credentials['email']);

                if ($user && password_verify($credentials['password'], $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    header('Location:/');
                    exit();
                } else {
                    $error = "Veuillez vérifier l'adresse mail ou le mot de passe.";
                    $errors[] = $error;
                    return $this->twig->render('login.html.twig', ['errors' => $errors]);
                }
            } else {
                return $this->twig->render('login.html.twig', ['errors' => $errors]);
            }
        }
        return $this->twig->render('login.html.twig');
    }

    public function logout()
    {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }

        header('Location:/');
        exit();
    }

    // Method to display a profil
    public function showUser(): string
    {
        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];

            $userManager = new UserManager();
            $user = $userManager->selectOneById($userID);

            return $this->twig->render('User/user-profil.html.twig', ['users' => $user]);
        } else {
            header('Location: /');
            die();
        }
    }

  // Method to edit a profil

    public function editProfil(int $id): ?string
    {
        $userManager = new UserManager();
        $credentials = $userManager->selectOneById($id);
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $dataTrimed = array_map('trim', $_POST);
              $credentials = array_map('htmlentities', $dataTrimed);

            if (empty($credentials['user_name'])) {
                $error = "Vous devez renseigner votre nom";
                $errors[] = $error;
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $credentials['user_name'])) {
                $error[] = "Votre pseudo ne peut contenir que des lettres, chiffres ou underscores";
                $errors[] = $error;
            }
            if (!filter_var($credentials["email"], FILTER_VALIDATE_EMAIL)) {
                $error[] = "L'adresse mail doit être renseignée au bon format.";
                $errors[] = $error;
            }
            if (empty($errors)) {
                $userManager->update($credentials);
                header('Location: /account?id=' . $id);
                return null;
            } else {
                return $this->twig->render('User/edit-user-profil.html.twig', ['errors' => $errors]);
            }
        }
        return $this->twig->render('User/edit-user-profil.html.twig', ['user' => $credentials]);
    }
}
