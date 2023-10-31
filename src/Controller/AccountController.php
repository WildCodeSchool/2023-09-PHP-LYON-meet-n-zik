<?php

namespace App\Controller;

use App\Controller\AbstractController;

class AccountController extends AbstractController
{
    public function account(): string
    {
        return $this->twig->render('Home/account.html.twig');
    }
}
