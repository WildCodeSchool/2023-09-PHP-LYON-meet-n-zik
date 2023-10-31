<?php

namespace App\Controller;

use App\Controller\AbstractController;

class HostController extends AbstractController
{
    public function hostpage(): string
    {
        return $this->twig->render('Home/hosthome.html.twig');
    }
}
