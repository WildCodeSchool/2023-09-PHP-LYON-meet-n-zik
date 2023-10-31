<?php

namespace App\Controller;

use App\Controller\AbstractController;

class BandController extends AbstractController
{
    public function bandPage(): string
    {
        return $this->twig->render('Home/bandpage.html.twig');
    }
}
