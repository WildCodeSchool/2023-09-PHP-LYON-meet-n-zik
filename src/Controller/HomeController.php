<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\UserManager;

class HomeController extends AbstractController
{
    public function index(): string
    {

        if (!empty($_SESSION)) {
            $userManager = new UserManager();
            $user = $userManager->selectOneById($_SESSION['user_id']);

            $users = [];

            if ($user['user_type_id'] == 2) {
                $users = $userManager->selectAllHost();
            } elseif ($user['user_type_id'] == 1) {
                $users = $userManager->selectAllBand();

                return $this->twig->render('Home/index.html.twig', [
                    "users" => $users
                ]);
            }
        }
        return $this->twig->render('Home/index.html.twig');
    }
}
