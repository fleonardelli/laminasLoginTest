<?php

declare(strict_types=1);

namespace Auth\Controller;

use Auth\Form\LoginForm;
use Auth\Service\Auth;
use Laminas\Authentication\Result;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class AuthController
 *
 * @package Auth\Controller
 */
class AuthController extends AbstractActionController
{
    /** @var Auth */
    protected $authService;


    /**
     * AuthController constructor.
     *
     * @param Auth $userService
     */
    public function __construct(Auth $userService)
    {
        $this->authService = $userService;
    }

    /**
     * @return \Laminas\Http\Response|ViewModel
     * @throws \Auth\Exception\UserNotLoggedInException
     */
    public function loginAction()
    {
        $form = new LoginForm();

        if ($this->getRequest()->isPost()) {

            $form->setData($this->params()->fromPost());

            if($form->isValid()) {
                $data = $form->getData();

                 $result = $this->authService->login($data['email'], $data['password']);

                 if ($result->getCode() == Result::SUCCESS) {

                     return $this->redirect()->toRoute('home', ['action'=> 'index']);
                 }

                 $this->flashMessenger()->addMessage($result->getMessages(), 'error');

            } else {
                foreach ($form->getMessages() as $errorKey => $errorMessage) {
                    $message = sprintf('%s: %s', $errorKey, current($errorMessage));
                    $this->flashMessenger()->addMessage($message, 'error');
                }
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }
}
