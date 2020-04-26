<?php

declare(strict_types=1);

namespace Auth\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    public function loginAction()
    {
        return new ViewModel();
    }
}
