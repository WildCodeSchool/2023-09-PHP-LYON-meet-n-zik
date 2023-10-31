<?php

namespace App\Controller;

use App\Controller\AbstractController;

class AuthController extends AbstractController
{
    public function login(): string
    {
        return $this->twig->render('Home/login.html.twig');
    }
    public function signup(): string
    {
        return $this->twig->render('Home/signup.html.twig');
    }
}
