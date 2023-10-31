<?php

namespace App\Controller;

use App\Controller\AbstractController;

class HostPageController extends AbstractController
{
    public function hostpage(): string
    {
        return $this->twig->render('Home/hosthome.html.twig');
    }
}
