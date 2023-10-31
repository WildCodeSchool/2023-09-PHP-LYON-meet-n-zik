<?php

namespace App\Controller;

use App\Controller\AbstractController;

class AccountController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('signin/account.html.twig');
    }
}
