<?php

namespace App\Controller;

use App\Controller\AbstractController;

class BandController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Home/bandpage.html.twig');
    }
}
