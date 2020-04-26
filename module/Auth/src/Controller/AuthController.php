<?php

declare(strict_types=1);

namespace Auth\Controller;

use Auth\Service\User;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class AuthController
 *
 * @package Auth\Controller
 */
class AuthController extends AbstractActionController
{
    /** @var User */
    protected $userService;

    /**
     * AuthController constructor.
     *
     * @param User $userService
     */
    public function __construct(User $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return ViewModel
     */
    public function loginAction()
    {
        return new ViewModel(['A' => $this->userService->getUserBy()]);
    }
}
