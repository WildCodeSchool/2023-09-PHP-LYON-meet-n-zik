<?php

namespace App\Controller;
use App\Controller\AbstractController;
use App\Model\UserManager;

class InteractionController extends AbstractController


{
    public function interact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user'])) {
                return 'Vous devez être connecté pour effectuer cette action.';
            }


            $userId = $_POST['userId'] ?? null;
            $action = $_POST['action'] ?? null;



            if ($action === 'like') {
                return 'Like effectué';
            } elseif ($action === 'dislike') {
                return 'Dislike effectué';
            }


            return 'Action effectuée avec succès';
        }

        return 'Méthode non autorisée';
    }

    public function meet()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        return $this->twig->render('User/meet.html.twig');
    }
}

