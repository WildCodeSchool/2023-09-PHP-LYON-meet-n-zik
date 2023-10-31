<?php

namespace App\Controller;

use App\Controller\AbstractController;

class BandPageController extends AbstractController
{
    public function Bandpage(): string
    {
        return $this->twig->render('Home/bandpage.html.twig');
    }
}
