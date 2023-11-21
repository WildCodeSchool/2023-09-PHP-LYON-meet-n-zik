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

    public function userIndex(): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($_SESSION['user_id']);
        $users = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $userManager->likeAUser($user['id'], $data['targetId']);
        }

        if ($user['user_type_id'] == 2) {
            $users = $userManager->selectAllHostNoLike($user['id']);
        } elseif ($user['user_type_id'] == 1) {
            $users = $userManager->selectAllBandNoLike($user['id']);
        }

        return $this->twig->render('User/meet.html.twig', ['users' => $users]);
    }
    public function likeUser($id)
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($_SESSION['user_id']);
                $userManager->likeAUser($user['user_id'], $id);
    }
    public function showMatches()
    {
        $matches = [];
        if (isset($_SESSION['user_id'])) {
            $userManager = new UserManager();
            $user = $userManager->selectOneById($_SESSION['user_id']);
            $matches = $userManager->matchedIndex($user['user_id']);
            header('Location: /my-matches?id=' . $user);
        }

        return $this->twig->render('User/user-matches.html.twig', ['matches' => $matches]);

        if ($user['user_type_id'] == 2) {
            $userManager = new UserManager();
            $users = $userManager->selectAllHost();
        } elseif ($user['user_type_id'] == 1) {
            $userManager = new UserManager();
            $users = $userManager->selectAllBand();
        }
        return $this->twig->render('User/meet.html.twig', ['users' => $users]);
    }
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

    public function editProfil(int $id): ?string
    {
        $userManager = new UserManager();
        $credentials = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataTrimed = array_map('trim', $_POST);
            $credentials = array_map('htmlentities', $dataTrimed);

            $formVerification = new FormVerificationService();
            $formVerification->editProfilVerfication($credentials);
            $errors = $formVerification->errors;
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

    public function showMatches()
    {
        if (isset($_SESSION['user_id'])) {
            $userManager = new UserManager();
            $user = $userManager->selectOneById($_SESSION['user_id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = $_POST;

                $userManager->likeBack($user['id'], $data['targetId']);
            }

            $userManager = new UserManager();
            $matches = $userManager->matchedIndex($user['id']);


            return $this->twig->render('User/user-matches.html.twig', ['matchess' => $matches]);
        } else {
            header('Location: /login');
            die();
        }
    }
}
