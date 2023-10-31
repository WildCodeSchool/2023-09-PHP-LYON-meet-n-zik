<?php

namespace App\Controller;

use App\Controller\AbstractController;

class HostpageController extends AbstractController
{
    public function hostpage(): string
    {
        return $this->twig->render('Home/hostpage.html.twig');
    }
}
