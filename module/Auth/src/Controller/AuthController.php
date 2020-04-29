<?php

declare(strict_types=1);

namespace Auth\Controller;

use Application\Entity\ErrorMessage;
use Application\Service\Content;
use Application\Service\MessageBag;
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

    /** @var MessageBag */
    protected $messageBag;

    /** @var Content  */
    protected $contentService;

    /**
     * AuthController constructor.
     *
     * @param Auth       $userService
     * @param MessageBag $messageBag
     */
    public function __construct(Auth $userService, MessageBag $messageBag, Content $contentService)
    {
        $this->authService = $userService;
        $this->messageBag = $messageBag;
        $this->contentService = $contentService;
    }

    /**
     * @return \Laminas\Http\Response|ViewModel
     */
    public function loginAction()
    {
        $form = new LoginForm();

        if ($this->getRequest()->isPost()) {

            $form->setData($this->params()->fromPost());

            if($form->isValid()) {
                $data = $form->getData();

                 try {
                     $result = $this->authService->login($data['email'], $data['password']);

                     if ($result->getCode() == Result::SUCCESS) {

                         return $this->redirect()->toRoute('home', ['action'=> 'index']);
                     }

                     foreach ($result->getMessages() as $message) {
                         $this->messageBag->addMessage($message, ErrorMessage::TYPE);
                     }

                 } catch (\Exception $e) {
                     $this->messageBag->addMessage($e->getMessage(), ErrorMessage::TYPE);
                 }
            } else {
                foreach ($form->getMessages() as $errorKey => $errorMessage) {
                    $message = sprintf('%s: %s', $errorKey, current($errorMessage));
                    $this->messageBag->addMessage($message, ErrorMessage::TYPE);
                }
            }
        }

        return new ViewModel([
            'form' => $form,
            'errors' => $this->messageBag->getErrorMessages(),
            'content' => $this->contentService->fetchAll(),
        ]);
    }

    /**
     * @return \Laminas\Http\Response
     * @throws \Auth\Exception\UserNotLoggedInException
     */
    public function logoutAction()
    {
        $this->authService->logout();

        return $this->redirect()->toRoute('login');
    }
}
