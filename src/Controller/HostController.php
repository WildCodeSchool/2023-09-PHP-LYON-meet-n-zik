<?php

namespace App\Controller;

use App\Controller\AbstractController;

class HostController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Home/hosthome.html.twig');
    }
}
