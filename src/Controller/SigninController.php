<?php

namespace App\Controller;

use App\Controller\AbstractController;

class SigninController extends AbstractController
{
    public function signin(): string
    {
        return $this->twig->render('Home/signin.html.twig');
    }
}
