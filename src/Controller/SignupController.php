<?php

namespace App\Controller;

use App\Controller\AbstractController;

class SignupController extends AbstractController
{
    public function signup(): string
    {
        return $this->twig->render('Home/signup.html.twig');
    }
}
